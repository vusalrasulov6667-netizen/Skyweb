<?php
/**
 * SKYWEB.AZ — CV Storage & Management API
 * POST/GET /api/cv-service.php
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// Determine user storage folder
$user_id = $_SESSION['user_id'] ?? null;
$user_info = $_SESSION['user'] ?? null;

if ($user_id) {
    $folder_name = 'user_' . $user_id;
    $account_display = ($user_info['fullname'] ?? 'User #' . $user_id) . ' (' . ($user_info['email'] ?? 'hesab') . ')';
} else {
    // Guest session
    if (empty($_SESSION['guest_cv_id'])) {
        $guestSalt = defined('SKY_SECRET_CV_SALT') ? SKY_SECRET_CV_SALT : 'local-dev-salt';
        $_SESSION['guest_cv_id'] = substr(md5(session_id() . $guestSalt), 0, 12);
    }
    $folder_name = 'guest_' . $_SESSION['guest_cv_id'];
    $account_display = sky_literal_translate('Qonaq Hesab Qovluğu');
}

$base_dir = __DIR__ . '/../uploads/cvs/' . $folder_name;
if (!is_dir($base_dir)) {
    mkdir($base_dir, 0777, true);
}

$transparent_path = '/uploads/cvs/' . $folder_name . '/';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? $_POST['action'] ?? 'list';

if ($method === 'POST') {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
    if (is_array($input) && isset($input['action'])) {
        $action = $input['action'];
    }
}

// ── 1. LIST ACTION ──
if ($action === 'list') {
    $files = glob($base_dir . '/*.json');
    $cvs = [];
    $total_bytes = 0;

    foreach ($files as $file) {
        $total_bytes += filesize($file);
        $content = file_get_contents($file);
        $data = json_decode($content, true);
        if ($data && isset($data['id'])) {
            $cvs[] = $data;
        }
    }

    // Sort by updated_at desc
    usort($cvs, function($a, $b) {
        return strtotime($b['updated_at'] ?? $b['created_at']) <=> strtotime($a['updated_at'] ?? $a['created_at']);
    });

    $size_kb = round($total_bytes / 1024, 1);

    echo json_encode([
        'success' => true,
        'folder_path' => $transparent_path,
        'account_display' => $account_display,
        'total_files' => count($cvs),
        'storage_used_kb' => $size_kb,
        'cvs' => $cvs
    ]);
    exit;
}

// ── 2. SAVE ACTION ──
if ($action === 'save') {
    $payload = $input['cv'] ?? $_POST['cv'] ?? null;
    if (!$payload) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => sky_literal_translate('CV məlumatları tapılmadı.')]);
        exit;
    }

    $id = !empty($payload['id']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $payload['id']) : 'cv_' . time() . '_' . substr(md5(uniqid()), 0, 6);
    $fname = trim($payload['fname'] ?? sky_literal_translate('İsimsiz'));
    $lname = trim($payload['lname'] ?? '');
    $fullname = trim($fname . ' ' . $lname) ?: sky_literal_translate('İsimsiz CV');
    $role = trim($payload['role'] ?? sky_literal_translate('Mütəxəssis'));
    $title = $fullname . ' — ' . $role;
    $template_id = $payload['template_id'] ?? 'tpl-1';
    $template_name = $payload['template_name'] ?? 'Professional Elite';
    $status = $payload['status'] ?? 'draft'; // 'draft' or 'exported'
    $created_at = $payload['created_at'] ?? date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');
    
    $clean_filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($fullname)) . '_' . $id . '.pdf';
    $json_file = $base_dir . '/' . $id . '.json';
    $html_file = $base_dir . '/' . $id . '.html';

    $cv_record = [
        'id' => $id,
        'title' => $title,
        'fullname' => $fullname,
        'role' => $role,
        'fname' => $fname,
        'lname' => $lname,
        'template_id' => $template_id,
        'template_name' => $template_name,
        'status' => $status,
        'status_text' => ($status === 'exported') ? sky_literal_translate('Tamamlandı (PDF Export)') : sky_literal_translate('Qaralama (Yadda Saxlanılıb)'),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
        'file_name' => $clean_filename,
        'file_path' => $transparent_path . $clean_filename,
        'view_url' => SITE_URL . '/modules/cv-builder/view.php?id=' . $id . '&f=' . $folder_name,
        'size_kb' => round(strlen(json_encode($payload)) / 1024, 1) + 12.5,
        'data' => $payload
    ];

    // Save JSON metadata
    file_put_contents($json_file, json_encode($cv_record, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Save printable HTML preview file
    $html_content = generatePrintableHtml($cv_record);
    file_put_contents($html_file, $html_content);

    // Get updated folder stats
    $files = glob($base_dir . '/*.json');
    $total_bytes = 0;
    foreach ($files as $f) { $total_bytes += filesize($f); }

    echo json_encode([
        'success' => true,
        'message' => ($status === 'exported') ? sky_literal_translate('CV PDF faylı uğurla yaradıldı və qovluğunuza saxlanıldı!') : sky_literal_translate('CV uğurla şəxsi qovluğunuza yadda saxlanıldı!'),
        'cv' => $cv_record,
        'folder_path' => $transparent_path,
        'account_display' => $account_display,
        'total_files' => count($files),
        'storage_used_kb' => round($total_bytes / 1024, 1)
    ]);
    exit;
}

// ── 3. DELETE ACTION ──
if ($action === 'delete') {
    $id = preg_replace('/[^a-zA-Z0-9_-]/', '', $input['id'] ?? $_POST['id'] ?? $_GET['id'] ?? '');
    if (!$id) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => sky_literal_translate('Fayl ID göstərilməyib.')]);
        exit;
    }

    $json_file = $base_dir . '/' . $id . '.json';
    $html_file = $base_dir . '/' . $id . '.html';

    if (file_exists($json_file)) { unlink($json_file); }
    if (file_exists($html_file)) { unlink($html_file); }

    $files = glob($base_dir . '/*.json');
    $total_bytes = 0;
    foreach ($files as $f) { $total_bytes += filesize($f); }

    echo json_encode([
        'success' => true,
        'message' => sky_literal_translate('CV qovluqdan uğurla silindi.'),
        'total_files' => count($files),
        'storage_used_kb' => round($total_bytes / 1024, 1)
    ]);
    exit;
}

/**
 * Generate Standard A4 Printable HTML Document for the CV
 */
function generatePrintableHtml(array $cv): string {
    $d = $cv['data'] ?? [];
    
    // Extract base fields safely
    $fname    = trim($d['fname'] ?? '');
    $lname    = trim($d['lname'] ?? '');
    $fullname = htmlspecialchars(($cv['fullname'] ?? trim($fname . ' ' . $lname)) ?: sky_literal_translate('Namizəd'), ENT_QUOTES, 'UTF-8');
    $role     = htmlspecialchars($cv['role']     ?? $d['role'] ?? sky_literal_translate('Mütəxəssis'), ENT_QUOTES, 'UTF-8');
    $email    = htmlspecialchars($d['email']     ?? '', ENT_QUOTES, 'UTF-8');
    $phone    = htmlspecialchars($d['phone']     ?? '', ENT_QUOTES, 'UTF-8');
    $city     = htmlspecialchars($d['city']      ?? '', ENT_QUOTES, 'UTF-8');
    $linkedin = htmlspecialchars($d['linkedin']  ?? '', ENT_QUOTES, 'UTF-8');
    $portfolio= htmlspecialchars($d['portfolio'] ?? '', ENT_QUOTES, 'UTF-8');
    $summary_text = trim($d['summary'] ?? '');
    $summary  = nl2br(htmlspecialchars($summary_text, ENT_QUOTES, 'UTF-8'));
    $photo_url = $d['photo_url'] ?? '';
    $tpl_id    = $cv['template_id'] ?? $d['template_id'] ?? 'tpl-1';
    $lang_code = CURRENT_LANG;
    $cv_doc_label = sky_literal_translate('📄 Skyweb.az CV Sənədi');
    $print_label = sky_literal_translate('🖨️ Çap Et / PDF Saxla');
    $tpl_name  = htmlspecialchars($cv['template_name'] ?? $d['template_name'] ?? 'Professional Elite', ENT_QUOTES, 'UTF-8');

    // Theme color mapping based on selected template
    $theme_color = match($tpl_id) {
        'tpl-2' => '#0284c7', // Cyan Tech
        'tpl-3' => '#7c3aed', // Creative Purple
        'tpl-4' => '#059669', // Executive Emerald
        'tpl-5' => '#4f46e5', // Indigo Youth
        'tpl-6' => '#0e7490', // ATS Cyan-slate
        default => '#0f172a'  // Professional Navy
    };
    $accent_color = match($tpl_id) {
        'tpl-2' => '#0369a1',
        'tpl-3' => '#6d28d9',
        'tpl-4' => '#047857',
        'tpl-5' => '#4338ca',
        'tpl-6' => '#0369a1',
        default => '#d97706'
    };

    // ── Photo ──
    $photo_html = '';
    if (!empty($photo_url)) {
        $photo_html = '<div class="cv-photo-box"><img src="' . htmlspecialchars($photo_url, ENT_QUOTES, 'UTF-8') . '" alt="' . $fullname . '"></div>';
    }

    // ── Contact chips ──
    $contact_parts = [];
    if ($email)    $contact_parts[] = '📧 ' . $email;
    if ($phone)    $contact_parts[] = '📞 ' . $phone;
    if ($city)     $contact_parts[] = '📍 ' . $city;
    if ($linkedin) $contact_parts[] = '🔗 ' . $linkedin;
    if ($portfolio)$contact_parts[] = '🌐 ' . $portfolio;
    $contact_html = implode('', array_map(fn($p) => '<span>' . $p . '</span>', $contact_parts));

    // ── Summary section ──
    $summary_html = '';
    if ($summary_text) {
        $summary_html = '<div class="cv-section-title">' . sky_literal_translate('Peşəkar Xülasə') . '</div><p class="cv-text">' . $summary . '</p>';
    }

    // ── Experience section ──
    $exp_html = '';
    $experience = $d['experience'] ?? [];
    if (!empty($experience) && is_array($experience)) {
        $exp_items = '';
        foreach ($experience as $exp) {
            $company   = htmlspecialchars($exp['company']    ?? '', ENT_QUOTES, 'UTF-8');
            $position  = htmlspecialchars($exp['position']   ?? '', ENT_QUOTES, 'UTF-8');
            $dateStart = htmlspecialchars($exp['date_start'] ?? '', ENT_QUOTES, 'UTF-8');
            $dateEnd   = htmlspecialchars($exp['date_end']   ?? sky_literal_translate('İndiyə qədər'), ENT_QUOTES, 'UTF-8');
            $duties    = nl2br(htmlspecialchars($exp['duties'] ?? '', ENT_QUOTES, 'UTF-8'));
            $dateRange = trim($dateStart . ($dateStart ? ' — ' : '') . $dateEnd, ' —');
            $titleLine = implode(' — ', array_filter([$position, $company]));
            
            if ($titleLine || $duties) {
                $exp_items .= '<div class="cv-item">';
                $exp_items .= '<div class="cv-item-head"><span>' . $titleLine . '</span><span>' . $dateRange . '</span></div>';
                if ($duties) $exp_items .= '<p class="cv-text">' . $duties . '</p>';
                $exp_items .= '</div>';
            }
        }
        if ($exp_items) {
            $exp_html = '<div class="cv-section-title">' . sky_literal_translate('İş Təcrübəsi') . '</div>' . $exp_items;
        }
    }

    // ── Education section ──
    $edu_html = '';
    $education = $d['education'] ?? [];
    if (!empty($education) && is_array($education)) {
        $edu_items = '';
        foreach ($education as $edu) {
            $school = htmlspecialchars($edu['school'] ?? '', ENT_QUOTES, 'UTF-8');
            $field  = htmlspecialchars($edu['field']  ?? '', ENT_QUOTES, 'UTF-8');
            $degree = htmlspecialchars($edu['degree'] ?? '', ENT_QUOTES, 'UTF-8');
            $year   = htmlspecialchars($edu['year']   ?? '', ENT_QUOTES, 'UTF-8');
            $note   = htmlspecialchars($edu['note']   ?? '', ENT_QUOTES, 'UTF-8');
            $sub    = trim(implode(' · ', array_filter([$degree, $field])));
            
            if ($school || $sub || $year || $note) {
                $edu_items .= '<div class="cv-item">';
                $edu_items .= '<div class="cv-item-head"><span>' . $school . '</span><span>' . $year . '</span></div>';
                if ($sub)  $edu_items .= '<div class="cv-item-sub">' . $sub . '</div>';
                if ($note) $edu_items .= '<p class="cv-text" style="margin:0;">' . $note . '</p>';
                $edu_items .= '</div>';
            }
        }
        if ($edu_items) {
            $edu_html = '<div class="cv-section-title">' . sky_literal_translate('Təhsil') . '</div>' . $edu_items;
        }
    }

    // ── Skills section ──
    $skills_html = '';
    $skills = $d['skills'] ?? [];
    if (!empty($skills) && is_array($skills)) {
        $valid_skills = array_filter(array_map('trim', $skills));
        if (!empty($valid_skills)) {
            $skill_chips = implode('', array_map(fn($s) => '<span class="cv-skill-chip">' . htmlspecialchars($s, ENT_QUOTES, 'UTF-8') . '</span>', $valid_skills));
            $skills_html = '<div class="cv-section-title">' . sky_literal_translate('Texniki Bacarıqlar') . '</div><div class="cv-skills-row">' . $skill_chips . '</div>';
        }
    }

    // ── Languages section ──
    $lang_html = '';
    $languages = $d['languages'] ?? [];
    if (!empty($languages) && is_array($languages)) {
        $lang_rows = '';
        foreach ($languages as $lang) {
            $l = htmlspecialchars($lang['lang']  ?? '', ENT_QUOTES, 'UTF-8');
            $v = htmlspecialchars($lang['level'] ?? '', ENT_QUOTES, 'UTF-8');
            if ($l) $lang_rows .= '<span class="cv-skill-chip">' . $l . ($v ? ' <small>(' . $v . ')</small>' : '') . '</span>';
        }
        if ($lang_rows) {
            $lang_html = '<div class="cv-section-title">' . sky_literal_translate('Dil Bilikləri') . '</div><div class="cv-skills-row">' . $lang_rows . '</div>';
        }
    }

    // ── Extra sections ──
    $extra_html = '';
    $certifications = trim($d['certifications'] ?? $d['cv-cert'] ?? $d['cert'] ?? '');
    $awards         = trim($d['awards']         ?? $d['cv-awards'] ?? '');
    $volunteer      = trim($d['volunteer']      ?? $d['cv-volunteer'] ?? '');
    $cv_language    = trim($d['cv_language']    ?? $d['cv-lang-pref'] ?? '');

    if ($certifications) {
        $extra_html .= '<div class="cv-section-title">' . sky_literal_translate('Sertifikatlar') . '</div>';
        $extra_html .= '<p class="cv-text">' . nl2br(htmlspecialchars($certifications, ENT_QUOTES, 'UTF-8')) . '</p>';
    }
    if ($awards) {
        $extra_html .= '<div class="cv-section-title">' . sky_literal_translate('Mükafatlar & Nailiyyətlər') . '</div>';
        $extra_html .= '<p class="cv-text">' . nl2br(htmlspecialchars($awards, ENT_QUOTES, 'UTF-8')) . '</p>';
    }
    if ($volunteer) {
        $extra_html .= '<div class="cv-section-title">' . sky_literal_translate('Könüllü Fəaliyyət') . '</div>';
        $extra_html .= '<p class="cv-text">' . nl2br(htmlspecialchars($volunteer, ENT_QUOTES, 'UTF-8')) . '</p>';
    }
    if ($cv_language && $cv_language !== 'az') {
        $lang_map = [
            'en' => sky_literal_translate('İngiliscə'),
            'az-en' => sky_literal_translate('İkidilli (AZ + EN)'),
            'ru' => sky_literal_translate('Rusca')
        ];
        $lang_str = $lang_map[$cv_language] ?? $cv_language;
        $extra_html .= '<div class="cv-section-title">' . sky_literal_translate('CV Dili') . '</div>';
        $extra_html .= '<p class="cv-text">' . htmlspecialchars($lang_str, ENT_QUOTES, 'UTF-8') . '</p>';
    }

    return <<<HTML
<!DOCTYPE html>
<html lang="{$lang_code}">
<head>
  <meta charset="UTF-8">
  <title>{$fullname} — CV ({$tpl_name})</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
  <style>
    @page { size: A4 portrait; margin: 12mm; }
    *, *::before, *::after { box-sizing: border-box; }
    body {
      font-family: 'Inter', sans-serif;
      color: #1e293b;
      background: #f8fafc;
      margin: 0;
      padding: 20px;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    .cv-sheet {
      max-width: 210mm;
      min-height: 297mm;
      margin: 0 auto;
      background: #ffffff;
      padding: 28mm 20mm;
      box-shadow: 0 4px 25px rgba(0,0,0,0.1);
      position: relative;
    }
    .cv-header {
      display: flex;
      align-items: center;
      gap: 20px;
      border-bottom: 2.5px solid {$theme_color};
      padding-bottom: 18px;
      margin-bottom: 22px;
    }
    .cv-photo-box {
      width: 75px; height: 100px;
      border-radius: 6px; overflow: hidden;
      border: 1px solid #cbd5e1; flex-shrink: 0;
    }
    .cv-photo-box img { width: 100%; height: 100%; object-fit: cover; }
    .cv-name { font-size: 24px; font-weight: 800; color: {$theme_color}; text-transform: uppercase; letter-spacing: -0.5px; }
    .cv-role { font-size: 15px; color: {$accent_color}; font-weight: 700; margin-top: 4px; }
    .cv-contact { display: flex; flex-wrap: wrap; gap: 14px; font-size: 12px; color: #64748b; margin-top: 8px; }
    .cv-section-title {
      font-size: 13px; font-weight: 800; color: {$theme_color};
      border-bottom: 1.5px solid #e2e8f0;
      padding-bottom: 4px; margin-top: 20px; margin-bottom: 10px;
      text-transform: uppercase; letter-spacing: 0.5px;
    }
    .cv-text { font-size: 12.5px; line-height: 1.6; color: #334155; margin: 0 0 10px 0; }
    .cv-item { margin-bottom: 14px; }
    .cv-item-head { display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: #0f172a; }
    .cv-item-sub { font-size: 12px; color: #64748b; font-style: italic; margin-bottom: 4px; }
    .cv-skills-row { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
    .cv-skill-chip {
      background: #f1f5f9; border: 1px solid #e2e8f0;
      color: #334155; font-size: 11.5px; font-weight: 600;
      padding: 3px 10px; border-radius: 999px;
    }
    .cv-skill-chip small { color: #64748b; font-weight: 400; }
    .no-print-bar {
      max-width: 210mm; margin: 0 auto 15px;
      display: flex; justify-content: space-between; align-items: center;
      background: #0f172a; color: #fff;
      padding: 12px 20px; border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .btn-print {
      background: linear-gradient(135deg, #f59e0b, #f97316);
      color: #000; font-weight: 700; border: none;
      padding: 8px 16px; border-radius: 6px; cursor: pointer;
    }
    @media print {
      body { background: #fff; padding: 0; }
      .cv-sheet { box-shadow: none; padding: 0; }
      .no-print-bar { display: none !important; }
    }
  </style>
</head>
<body>
  <div class="no-print-bar">
    <div><strong>{$cv_doc_label}</strong> &nbsp;|&nbsp; <span>{$fullname} ({$tpl_name})</span></div>
    <div><button class="btn-print" onclick="window.print()">{$print_label}</button></div>
  </div>

  <div class="cv-sheet">
    <div class="cv-header">
      {$photo_html}
      <div style="flex:1;">
        <div class="cv-name">{$fullname}</div>
        <div class="cv-role">{$role}</div>
        <div class="cv-contact">{$contact_html}</div>
      </div>
    </div>

    {$summary_html}
    {$exp_html}
    {$edu_html}
    {$skills_html}
    {$lang_html}
    {$extra_html}
  </div>
</body>
</html>
HTML;
}

