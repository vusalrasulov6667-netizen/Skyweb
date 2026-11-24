<?php
/**
 * SKYWEB.AZ — Partner brendlər anbarı (fayl əsaslı)
 * ---------------------------------------------------------------
 * Bölmə publik frontend-də DEFAULT OLARAQ GİZLƏDİLİB.
 * Yalnız Admin Panel (`/admin/`) vasitəsilə idarə olunur:
 *   - brend adı + loqo əlavə / redaktə / sil
 *   - bölmənin publik görünürlüyünü aç/bağla
 *
 * Saxlama: `data/partners.json` (atomik yazma, LOCK_EX)
 * Loqolar: `uploads/partners/`
 */

if (!defined('SKY_PARTNERS_STORE')) {
    define('SKY_PARTNERS_STORE', dirname(__DIR__) . '/data/partners.json');
}
if (!defined('SKY_PARTNERS_UPLOAD_DIR')) {
    define('SKY_PARTNERS_UPLOAD_DIR', dirname(__DIR__) . '/uploads/partners');
}
if (!defined('SKY_PARTNERS_UPLOAD_URL')) {
    define('SKY_PARTNERS_UPLOAD_URL', 'uploads/partners');
}

/** Standart (boş + gizli) vəziyyət */
function sky_partners_defaults(): array {
    return ['visible' => false, 'updated_at' => '', 'items' => []];
}

/**
 * Anbarı oxuyur. Fayl yoxdursa və ya zədəlidirsə təhlükəsiz default qaytarır.
 */
function sky_partners_load(): array {
    $data = sky_partners_defaults();

    if (!is_file(SKY_PARTNERS_STORE)) {
        return $data;
    }

    $raw = @file_get_contents(SKY_PARTNERS_STORE);
    if ($raw === false || $raw === '') {
        return $data;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return $data;
    }

    $data['visible']    = !empty($decoded['visible']);
    $data['updated_at'] = isset($decoded['updated_at']) && is_string($decoded['updated_at'])
        ? $decoded['updated_at']
        : '';

    if (isset($decoded['items']) && is_array($decoded['items'])) {
        foreach ($decoded['items'] as $item) {
            if (!is_array($item)) {
                continue;
            }
            $name  = isset($item['name'])  ? trim((string) $item['name'])  : '';
            $logo  = isset($item['logo'])  ? trim((string) $item['logo'])  : '';
            $url   = isset($item['url'])   ? trim((string) $item['url'])   : '';

            if ($name === '' && $logo === '') {
                continue;
            }

            $data['items'][] = [
                'id'      => isset($item['id']) ? (string) $item['id'] : '',
                'name'    => $name,
                'logo'    => $logo,
                'url'     => $url,
                'visible' => !empty($item['visible']),
            ];
        }
    }

    return $data;
}

/**
 * Anbarı atomik şəkildə yazır.
 */
function sky_partners_save(array $data): bool {
    $dir = dirname(SKY_PARTNERS_STORE);
    if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
        return false;
    }

    $items = [];
    foreach (($data['items'] ?? []) as $item) {
        if (!is_array($item)) {
            continue;
        }
        $name = trim((string) ($item['name'] ?? ''));
        $logo = trim((string) ($item['logo'] ?? ''));
        if ($name === '' && $logo === '') {
            continue;
        }
        $items[] = [
            'id'      => (string) ($item['id'] ?? ''),
            'name'    => $name,
            'logo'    => $logo,
            'url'     => trim((string) ($item['url'] ?? '')),
            'visible' => !empty($item['visible']),
        ];
    }

    $payload = [
        'visible'    => !empty($data['visible']),
        'updated_at' => date('c'),
        'items'      => array_values($items),
    ];

    $json = json_encode(
        $payload,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    if ($json === false) {
        return false;
    }

    $tmp = SKY_PARTNERS_STORE . '.tmp';
    if (@file_put_contents($tmp, $json, LOCK_EX) === false) {
        return false;
    }

    if (!@rename($tmp, SKY_PARTNERS_STORE)) {
        @unlink($tmp);
        return false;
    }

    return true;
}

/** Bölmə publik olaraq göstərilməlidir? (default: XEYR) */
function sky_partners_is_public(): bool {
    $data = sky_partners_load();
    return !empty($data['visible']);
}

/**
 * Publik frontend üçün görünən elementlər.
 * Bölmə söndürülübsə həmişə boş massiv qaytarır.
 */
function sky_partners_public_items(): array {
    $data = sky_partners_load();
    if (empty($data['visible'])) {
        return [];
    }

    $out = [];
    foreach ($data['items'] as $item) {
        if (empty($item['visible'])) {
            continue;
        }
        if ($item['name'] === '' && $item['logo'] === '') {
            continue;
        }
        $out[] = $item;
    }

    return $out;
}

/**
 * Brend səviyyəsində «Saytda göstər» seçilibsə, bölməni də avtomatik açır.
 * Admin ayrıca bölmə açarı axtarmasın: bir brend görünən edildikdə sayt
 * istifadəçiləri onu dərhal görür.
 *
 * @return bool Bölmə bu çağırışda açıldısa `true`.
 */
function sky_partners_auto_publish(array &$data): bool {
    if (!empty($data['visible'])) {
        return false;
    }
    foreach (($data['items'] ?? []) as $item) {
        if (!empty($item['visible'])) {
            $data['visible'] = true;
            return true;
        }
    }
    return false;
}

/** Loqo üçün URL (nisbi yol — istənilən hostda işləyir) */
function sky_partner_logo_url(string $logo): string {
    $logo = trim($logo);
    if ($logo === '') {
        return '';
    }
    if (preg_match('~^(https?:)?//~i', $logo) === 1) {
        return $logo;
    }
    return ltrim($logo, '/');
}

/** Loqo olmayanda göstərilən baş hərflər (maks. 2) */
function sky_partner_initials(string $name): string {
    $name = trim(preg_replace('/\s+/u', ' ', $name) ?? '');
    if ($name === '') {
        return '★';
    }

    $words = preg_split('/\s+/u', $name) ?: [];

    // Tək sözlü ad: ilk 2 hərf (məs. «AZPetrol» → «AZ»)
    if (count($words) === 1) {
        return mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
    }

    $initials = '';
    foreach ($words as $word) {
        if ($word === '') {
            continue;
        }
        $initials .= mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8');
        if (mb_strlen($initials, 'UTF-8') >= 2) {
            break;
        }
    }

    return $initials !== '' ? $initials : '★';
}

/** Yeni element üçün unikal id */
function sky_partner_new_id(): string {
    return 'pt_' . bin2hex(random_bytes(6));
}

/* ───────────────────────── Ortaq köməkçilər ─────────────────────────
 * Admin panel və footer-daxili idarəetmə eyni funksiyalardan istifadə edir.
 * ------------------------------------------------------------------ */

/** Loqo faylını təhlükəsiz şəkildə yükləyir; uğurlu olsa nisbi URL qaytarır. */
function sky_partners_upload_logo(?array $file, ?string &$error = null): ?string {
    $error = null;

    if (!is_array($file) || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Loqo yüklənmədi (xəta kodu: ' . (int) $file['error'] . ').';
        return null;
    }

    if (($file['size'] ?? 0) > 3 * 1024 * 1024) {
        $error = 'Loqo ölçüsü 3 MB-dan çox ola bilməz.';
        return null;
    }

    $info = @getimagesize($file['tmp_name']);
    if ($info === false) {
        $error = 'Fayl şəkil deyil. PNG, JPG, WEBP və ya GIF yükləyin.';
        return null;
    }

    $allowed = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp', 'image/gif' => 'gif'];
    $mime = $info['mime'] ?? '';
    if (!isset($allowed[$mime])) {
        $error = 'Dəstəklənməyən format: ' . e((string) $mime) . '. PNG, JPG, WEBP, GIF.';
        return null;
    }

    if (!is_dir(SKY_PARTNERS_UPLOAD_DIR) && !@mkdir(SKY_PARTNERS_UPLOAD_DIR, 0775, true) && !is_dir(SKY_PARTNERS_UPLOAD_DIR)) {
        $error = 'Loqo qovluğu yaradıla bilmədi.';
        return null;
    }

    $filename = 'partner_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
    $target = SKY_PARTNERS_UPLOAD_DIR . DIRECTORY_SEPARATOR . $filename;

    if (!@move_uploaded_file($file['tmp_name'], $target)) {
        $error = 'Loqo faylı saxlanıla bilmədi.';
        return null;
    }

    @chmod($target, 0644);

    return SKY_PARTNERS_UPLOAD_URL . '/' . $filename;
}

/** Loqo faylını diskdən silir (yalnız uploads/partners daxilində). */
function sky_partners_delete_logo_file(string $logo): void {
    if ($logo === '' || preg_match('~^https?://~i', $logo) === 1) {
        return;
    }

    $relative = ltrim($logo, '/');
    if (strpos($relative, SKY_PARTNERS_UPLOAD_URL . '/') !== 0) {
        return;
    }

    $path = realpath(dirname(__DIR__) . '/' . $relative);
    $root = realpath(SKY_PARTNERS_UPLOAD_DIR);
    if ($path !== false && $root !== false && strpos($path, $root) === 0 && is_file($path)) {
        @unlink($path);
    }
}

/** URL-i təmizləyir; boş və ya etibarsızsa null qaytarır. */
function sky_partners_clean_url(string $url): ?string {
    $url = trim($url);
    if ($url === '') {
        return '';
    }
    if (preg_match('~^https?://~i', $url) !== 1) {
        $url = 'https://' . ltrim($url, '/');
    }
    return filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
}

/** Footer-daxili idarəetmə üçün qısa bildirişlər */
function sky_partners_flash(string $type, string $message): void {
    $_SESSION['sky_partner_flash'][] = ['type' => $type, 'message' => $message];
}

function sky_partners_take_flash(): array {
    $flash = $_SESSION['sky_partner_flash'] ?? [];
    unset($_SESSION['sky_partner_flash']);
    return is_array($flash) ? $flash : [];
}
