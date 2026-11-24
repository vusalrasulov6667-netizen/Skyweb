<?php
/**
 * SKYWEB.AZ — ADMIN PANEL
 * ---------------------------------------------------------------
 * Yalnız admin girişi ilə açılır.
 * İdarə edir:
 *   • «Əməkdaşlıq Etdiyimiz Brendlər» bölməsinin publik görünürlüyü
 *   • Partner brend adları, loqoları, keçid linkləri (CRUD)
 *   • Sıralama və hər brendin ayrıca görünürlüyü
 *   • Admin şifrəsinin dəyişdirilməsi
 *
 * Bölmə publik frontend-də DEFAULT OLARAK GİZLİDİR.
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/admin.php';
require_once __DIR__ . '/../config/partners.php';

header('X-Robots-Tag: noindex, nofollow', true);
header('Referrer-Policy: same-origin', true);

/* ───────────────────────── Köməkçilər ───────────────────────── */

function sky_admin_flash(string $type, string $message): void {
    $_SESSION['sky_admin_flash'][] = ['type' => $type, 'message' => $message];
}

function sky_admin_take_flash(): array {
    $flash = $_SESSION['sky_admin_flash'] ?? [];
    unset($_SESSION['sky_admin_flash']);
    return is_array($flash) ? $flash : [];
}

function sky_admin_redirect(string $to = 'index.php'): void {
    header('Location: ' . $to);
    exit;
}

function sky_admin_is_post(): bool {
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

/* Loqo upload / silmə və URL təmizləmə funksiyaları `config/partners.php`-dədir
   (footer-daxili idarəetmə ilə ortaq istifadə üçün). */

/* ───────────────────────── POST əməliyyatları ───────────────────────── */

$editId = trim((string) ($_GET['edit'] ?? ''));

if (sky_admin_is_post()) {
    if (!csrf_verify((string) ($_POST['csrf'] ?? ''))) {
        sky_admin_flash('error', 'Təhlükəsizlik xətası (CSRF). Səhifəni yeniləyib yenidən cəhd edin.');
        sky_admin_redirect();
    }

    $action = (string) ($_POST['action'] ?? '');

    /* ── Giriş ───────────────────────────────────────────── */
    if ($action === 'login') {
        if (sky_admin_is_locked()) {
            sky_admin_flash('error', 'Çox sayda uğursuz cəhd. ' . (int) ceil(sky_admin_lock_seconds_left() / 60) . ' dəqiqə sonra yenidən cəhd edin.');
            sky_admin_redirect();
        }

        $user = trim((string) ($_POST['username'] ?? ''));
        $pass = (string) ($_POST['password'] ?? '');

        $userOk = hash_equals(strtolower(SKY_ADMIN_USER), strtolower($user));
        if ($userOk && sky_admin_verify_password($pass)) {
            sky_admin_login_session();
            sky_admin_clear_failures();
            sky_admin_flash('success', 'Xoş gəldiniz! Admin panelinə daxil oldunuz.');
            sky_admin_redirect();
        }

        usleep(400000);
        sky_admin_register_failure();
        sky_admin_flash('error', 'İstifadəçi adı və ya şifrə yanlışdır.');
        sky_admin_redirect();
    }

    /* Aşağıdakı əməliyyatlar üçün giriş tələb olunur */
    if (!sky_admin_is_logged_in()) {
        sky_admin_flash('error', 'Sessiyanın vaxtı bitdi. Yenidən daxil olun.');
        sky_admin_redirect();
    }

    sky_admin_touch();

    switch ($action) {
        /* ── Çıxış ────────────────────────────────────────── */
        case 'logout':
            sky_admin_logout();
            sky_admin_flash('success', 'Panel sessiyası bağlandı.');
            sky_admin_redirect();
            break;

        /* ── Bölmənin publik görünürlüyü ─────────────────── */
        case 'toggle_section':
            $data = sky_partners_load();
            $data['visible'] = ((string) ($_POST['visible'] ?? '0')) === '1';
            if (sky_partners_save($data)) {
                $active = 0;
                foreach ($data['items'] as $item) {
                    if (!empty($item['visible'])) {
                        $active++;
                    }
                }
                if ($data['visible'] && $active === 0) {
                    sky_admin_flash('warning', 'Bölmə aktiv edildi, lakin hələ aktiv brend yoxdur — saytda heç nə görünməyəcək.');
                } else {
                    sky_admin_flash('success', $data['visible']
                        ? 'Bölmə saytda GÖRÜNÜR edildi.'
                        : 'Bölmə saytda GİZLİDİR.');
                }
            } else {
                sky_admin_flash('error', 'Yadda saxlamaq alınmadı. `data/` qovluğunun yazma icazəsini yoxlayın.');
            }
            sky_admin_redirect();
            break;

        /* ── Brend əlavə et / redaktə et ─────────────────── */
        case 'save_partner':
            $id          = trim((string) ($_POST['id'] ?? ''));
            $name        = trim((string) ($_POST['name'] ?? ''));
            $urlInput    = (string) ($_POST['url'] ?? '');
            $itemVisible = !empty($_POST['item_visible']);
            $removeLogo  = !empty($_POST['remove_logo']);

            $data = sky_partners_load();
            $index = null;
            foreach ($data['items'] as $i => $item) {
                if ($item['id'] === $id && $id !== '') {
                    $index = $i;
                    break;
                }
            }

            $currentLogo = $index !== null ? (string) $data['items'][$index]['logo'] : '';

            $uploadError = null;
            $newLogo = sky_partners_upload_logo($_FILES['logo'] ?? null, $uploadError);
            if ($uploadError !== null) {
                sky_admin_flash('error', $uploadError);
                sky_admin_redirect($index !== null ? 'index.php?edit=' . rawurlencode($id) : 'index.php');
            }

            $logo = $currentLogo;

            if ($newLogo !== null) {
                if ($currentLogo !== '') {
                    sky_partners_delete_logo_file($currentLogo);
                }
                $logo = $newLogo;
            } elseif ($removeLogo && $currentLogo !== '') {
                sky_partners_delete_logo_file($currentLogo);
                $logo = '';
            }

            if ($name === '' && $logo === '') {
                sky_admin_flash('error', 'Brend adı və ya loqo tələb olunur.');
                sky_admin_redirect($index !== null ? 'index.php?edit=' . rawurlencode($id) : 'index.php');
            }

            $url = sky_partners_clean_url($urlInput);
            if ($url === null) {
                sky_admin_flash('error', 'Vebsayt ünvanı düzgün deyil. Nümunə: https://brend.az');
                sky_admin_redirect($index !== null ? 'index.php?edit=' . rawurlencode($id) : 'index.php');
            }

            if ($index !== null) {
                $data['items'][$index]['name']    = $name;
                $data['items'][$index]['logo']    = $logo;
                $data['items'][$index]['url']     = $url;
                $data['items'][$index]['visible'] = $itemVisible;
                $message = 'Brend yeniləndi.';
            } else {
                $data['items'][] = [
                    'id'      => sky_partner_new_id(),
                    'name'    => $name,
                    'logo'    => $logo,
                    'url'     => $url,
                    'visible' => $itemVisible,
                ];
                $message = 'Yeni brend əlavə olundu.';
            }

            $autoOpened = sky_partners_auto_publish($data);

            if (sky_partners_save($data)) {
                sky_admin_flash('success', $message
                    . ($autoOpened
                        ? ' Bölmə də avtomatik saytda görünür edildi.'
                        : (empty($data['visible']) ? ' Qeyd: bölmə hələ gizlidir.' : '')));
            } else {
                sky_admin_flash('error', 'Yadda saxlamaq alınmadı (`data/partners.json`).');
            }
            sky_admin_redirect();
            break;

        /* ── Brendi sil ───────────────────────────────────── */
        case 'delete_partner':
            $id   = trim((string) ($_POST['id'] ?? ''));
            $data = sky_partners_load();
            $kept = [];
            $removed = false;

            foreach ($data['items'] as $item) {
                if ($item['id'] === $id && $id !== '') {
                    sky_partners_delete_logo_file((string) $item['logo']);
                    $removed = true;
                    continue;
                }
                $kept[] = $item;
            }

            $data['items'] = $kept;
            sky_partners_save($data);
            sky_admin_flash($removed ? 'success' : 'warning', $removed ? 'Brend silindi.' : 'Brend tapılmadı.');
            sky_admin_redirect();
            break;

        /* ── Tək brendin görünürlüyü ─────────────────────── */
        case 'toggle_partner':
            $id   = trim((string) ($_POST['id'] ?? ''));
            $data = sky_partners_load();
            $state = null;

            foreach ($data['items'] as $i => $item) {
                if ($item['id'] === $id && $id !== '') {
                    $data['items'][$i]['visible'] = empty($item['visible']);
                    $state = $data['items'][$i]['visible'];
                    break;
                }
            }

            if ($state === null) {
                sky_admin_flash('warning', 'Brend tapılmadı.');
            } else {
                $autoOpened = $state ? sky_partners_auto_publish($data) : false;
                sky_partners_save($data);
                sky_admin_flash('success', $state ? 'Brend saytda göstərilir.' : 'Brend gizlədildi.');
                if ($autoOpened) {
                    sky_admin_flash('success', 'Bölmə də avtomatik saytda görünür edildi.');
                }
            }
            sky_admin_redirect();
            break;

        /* ── Sıralama (yuxarı / aşağı) ───────────────────── */
        case 'move_partner':
            $id  = trim((string) ($_POST['id'] ?? ''));
            $dir = ((string) ($_POST['dir'] ?? 'up')) === 'down' ? 1 : -1;
            $data = sky_partners_load();
            $pos = null;

            foreach ($data['items'] as $i => $item) {
                if ($item['id'] === $id && $id !== '') {
                    $pos = $i;
                    break;
                }
            }

            $target = $pos === null ? null : $pos + $dir;
            if ($pos !== null && $target !== null && isset($data['items'][$target])
                && $target >= 0 && $target < count($data['items'])) {
                $tmp = $data['items'][$pos];
                $data['items'][$pos] = $data['items'][$target];
                $data['items'][$target] = $tmp;
                sky_partners_save($data);
                sky_admin_flash('success', 'Sıra dəyişdirildi.');
            } else {
                sky_admin_flash('warning', 'Sıra dəyişdirilə bilmədi.');
            }
            sky_admin_redirect();
            break;

        /* ── Şifrə dəyişmə ───────────────────────────────── */
        case 'change_password':
            $current = (string) ($_POST['current_password'] ?? '');
            $new     = (string) ($_POST['new_password'] ?? '');
            $repeat  = (string) ($_POST['repeat_password'] ?? '');

            if (!sky_admin_verify_password($current)) {
                sky_admin_flash('error', 'Cari şifrə yanlışdır.');
            } elseif (mb_strlen($new, 'UTF-8') < 8) {
                sky_admin_flash('error', 'Yeni şifrə ən azı 8 simvol olmalıdır.');
            } elseif ($new !== $repeat) {
                sky_admin_flash('error', 'Yeni şifrə təkrarı uyğun deyil.');
            } elseif (sky_admin_set_password($new)) {
                sky_admin_flash('success', 'Şifrə dəyişdirildi.');
            } else {
                sky_admin_flash('error', 'Şifrə saxlanıla bilmədi (`data/admin_auth.json`).');
            }
            sky_admin_redirect();
            break;

        default:
            sky_admin_flash('error', 'Naməlum əməliyyat.');
            sky_admin_redirect();
    }
}

/* ───────────────────────── Vəziyyət ───────────────────────── */

$flash    = sky_admin_take_flash();
$loggedIn = sky_admin_is_logged_in();

if ($loggedIn) {
    sky_admin_touch();
}

$store        = $loggedIn ? sky_partners_load() : sky_partners_defaults();
$items        = $store['items'];
$sectionOn    = !empty($store['visible']);
$activeCount  = 0;
foreach ($items as $item) {
    if (!empty($item['visible'])) {
        $activeCount++;
    }
}
$publicCount  = $sectionOn ? $activeCount : 0;
$editItem     = null;
if ($editId !== '') {
    foreach ($items as $item) {
        if ($item['id'] === $editId) {
            $editItem = $item;
            break;
        }
    }
}
$updatedAt = $store['updated_at'];
?>
<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Admin Panel — <?= e(SITE_NAME) ?></title>
<style>
  :root{
    --bg:#001a1a; --panel:rgba(0,32,40,.72); --panel-2:rgba(0,40,50,.55);
    --border:rgba(0,255,255,.15); --border-strong:rgba(0,255,255,.35);
    --cyan:#00FFFF; --text:#f0fefe; --muted:#9fd3d3; --dim:#7ab8b8;
    --ok:#10b981; --warn:#f59e0b; --err:#ef4444;
    --radius:14px; --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;
    --mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,monospace;
  }
  *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
  body{
    font-family:var(--font);color:var(--text);min-height:100vh;line-height:1.5;
    background:
      radial-gradient(900px 500px at 15% -10%,rgba(0,255,255,.10),transparent 60%),
      radial-gradient(700px 420px at 100% 0%,rgba(0,188,212,.10),transparent 55%),
      linear-gradient(160deg,#001a1a 0%,#002027 45%,#002b33 100%);
    background-attachment:fixed;
    -webkit-font-smoothing:antialiased;
    padding:1.25rem 1rem 3rem;
  }
  a{color:var(--cyan);text-decoration:none}
  img{max-width:100%;display:block}
  .wrap{width:100%;max-width:1040px;margin:0 auto}
  .mono{font-family:var(--mono)}

  /* ── Topbar ── */
  .topbar{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem}
  .brand{display:flex;align-items:center;gap:.7rem;min-width:0}
  .brand-mark{width:38px;height:38px;border-radius:11px;flex:0 0 auto;display:grid;place-items:center;
    background:linear-gradient(135deg,rgba(0,255,255,.20),rgba(0,188,212,.08));border:1px solid var(--border-strong);
    color:var(--cyan);font-weight:800;font-size:.95rem;font-family:var(--mono)}
  .brand-txt{min-width:0}
  .brand-txt b{display:block;font-size:1rem;letter-spacing:.2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .brand-txt span{display:block;font-size:.72rem;color:var(--dim);text-transform:uppercase;letter-spacing:1.4px}
  .topbar-actions{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}

  /* ── Buttons ── */
  .btn{display:inline-flex;align-items:center;justify-content:center;gap:.4rem;
    padding:.55rem .95rem;border-radius:10px;border:1px solid var(--border);
    background:rgba(255,255,255,.03);color:var(--text);font:inherit;font-size:.85rem;font-weight:600;
    cursor:pointer;transition:.2s;text-decoration:none;white-space:nowrap}
  .btn:hover{border-color:var(--border-strong);background:rgba(0,255,255,.07)}
  .btn-primary{background:linear-gradient(135deg,var(--cyan),#00bcd4);color:#00231f;border-color:transparent}
  .btn-primary:hover{filter:brightness(1.06);color:#00231f}
  .btn-danger{color:#ffb4b4;border-color:rgba(239,68,68,.35);background:rgba(239,68,68,.08)}
  .btn-danger:hover{background:rgba(239,68,68,.16);border-color:rgba(239,68,68,.55)}
  .btn-sm{padding:.35rem .6rem;font-size:.78rem;border-radius:8px}
  .btn[disabled]{opacity:.45;cursor:not-allowed}

  /* ── Cards / panels ── */
  .card{background:var(--panel);border:1px solid var(--border);border-radius:var(--radius);
    padding:1.15rem;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);margin-bottom:1rem}
  .card-head{display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap;margin-bottom:.9rem}
  .card-title{font-size:.95rem;font-weight:700;letter-spacing:.2px}
  .card-sub{font-size:.78rem;color:var(--dim);margin-top:.15rem}
  .muted{color:var(--dim);font-size:.8rem}
  .hr{height:1px;background:var(--border);margin:1rem 0;border:0}

  /* ── Flash ── */
  .flash{border-radius:11px;padding:.7rem .85rem;font-size:.83rem;margin-bottom:.7rem;
    border:1px solid var(--border);background:rgba(255,255,255,.03);display:flex;gap:.55rem;align-items:flex-start}
  .flash b{font-weight:700}
  .flash.success{border-color:rgba(16,185,129,.4);background:rgba(16,185,129,.10)}
  .flash.warning{border-color:rgba(245,158,11,.4);background:rgba(245,158,11,.10)}
  .flash.error{border-color:rgba(239,68,68,.4);background:rgba(239,68,68,.10)}

  /* ── Visibility banner ── */
  .status{display:grid;grid-template-columns:1fr auto;gap:1rem;align-items:center}
  .status-state{display:flex;align-items:center;gap:.65rem;min-width:0}
  .dot{width:9px;height:9px;border-radius:50%;flex:0 0 auto;box-shadow:0 0 0 4px rgba(255,255,255,.04)}
  .dot.on{background:var(--ok);box-shadow:0 0 12px rgba(16,185,129,.8)}
  .dot.off{background:var(--err);box-shadow:0 0 12px rgba(239,68,68,.7)}
  .status-title{font-size:.95rem;font-weight:700}
  .status-desc{font-size:.78rem;color:var(--dim);margin-top:.2rem}
  .toggle-form{display:flex;gap:.5rem;align-items:center;flex-wrap:wrap}

  /* ── Form ── */
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:.85rem}
  .field{display:flex;flex-direction:column;gap:.35rem;min-width:0}
  .field label{font-size:.78rem;font-weight:600;color:var(--muted)}
  .field input[type=text],.field input[type=url],.field input[type=password],.field input[type=file]{
    width:100%;padding:.6rem .7rem;border-radius:9px;border:1px solid var(--border);
    background:rgba(0,0,0,.28);color:var(--text);font:inherit;font-size:.86rem;min-width:0}
  .field input[type=file]{padding:.45rem .5rem;font-size:.8rem}
  .field input:focus-visible{outline:2px solid rgba(0,255,255,.45);outline-offset:1px;border-color:var(--border-strong)}
  .check{display:flex;align-items:center;gap:.5rem;font-size:.82rem;color:var(--muted)}
  .check input{width:16px;height:16px;accent-color:#00e5ff}
  .form-actions{display:flex;gap:.5rem;flex-wrap:wrap;margin-top:1rem}
  .hint{font-size:.74rem;color:var(--dim)}
  .logo-current{display:flex;align-items:center;gap:.6rem;margin-top:.4rem;flex-wrap:wrap}
  .logo-current img{height:34px;width:auto;max-width:120px;object-fit:contain;border-radius:6px;
    background:rgba(255,255,255,.06);padding:3px 5px}

  /* ── List ── */
  .list{display:flex;flex-direction:column;gap:.6rem}
  .row{display:grid;grid-template-columns:auto 1fr auto;gap:.8rem;align-items:center;
    padding:.7rem;border:1px solid var(--border);border-radius:12px;background:var(--panel-2);min-width:0}
  .row.is-off{opacity:.55}
  .thumb{width:52px;height:40px;border-radius:8px;display:grid;place-items:center;flex:0 0 auto;
    background:rgba(255,255,255,.06);border:1px solid var(--border);overflow:hidden}
  .thumb img{max-width:100%;max-height:100%;object-fit:contain;padding:3px}
  .thumb .initials{font-family:var(--mono);font-weight:800;font-size:.9rem;color:var(--cyan)}
  .row-main{min-width:0}
  .row-name{font-weight:600;font-size:.9rem;overflow-wrap:anywhere}
  .row-meta{font-size:.74rem;color:var(--dim);overflow-wrap:anywhere}
  .row-actions{display:flex;gap:.35rem;flex-wrap:wrap;justify-content:flex-end}
  .badge{display:inline-flex;align-items:center;gap:.3rem;font-size:.68rem;font-weight:700;
    padding:.12rem .45rem;border-radius:999px;border:1px solid var(--border);color:var(--muted);text-transform:uppercase;letter-spacing:.6px}
  .badge.on{border-color:rgba(16,185,129,.45);color:#8ff0c8;background:rgba(16,185,129,.10)}
  .badge.off{border-color:rgba(239,68,68,.35);color:#ffb4b4;background:rgba(239,68,68,.08)}
  .empty{border:1px dashed var(--border);border-radius:12px;padding:1.6rem 1rem;text-align:center;color:var(--dim);font-size:.85rem}

  /* ── Login ── */
  .login-wrap{max-width:420px;margin:8vh auto 0}
  .login-title{font-size:1.25rem;font-weight:800;margin-bottom:.25rem}
  .login-sub{font-size:.82rem;color:var(--dim);margin-bottom:1.2rem}
  .login-note{margin-top:1rem;font-size:.75rem;color:var(--dim);border-top:1px solid var(--border);padding-top:.85rem;line-height:1.6}
  .login-note code{font-family:var(--mono);color:var(--muted);background:rgba(0,0,0,.3);padding:.1rem .35rem;border-radius:5px}

  details.pw{margin-top:.25rem}
  details.pw summary{cursor:pointer;font-size:.82rem;color:var(--muted);font-weight:600;list-style:none}
  details.pw summary::-webkit-details-marker{display:none}
  details.pw summary::before{content:'▸ ';color:var(--cyan)}
  details.pw[open] summary::before{content:'▾ '}

  /* ── Responsive ── */
  @media (max-width:720px){
    body{padding:.9rem .75rem 2.4rem}
    .grid-2{grid-template-columns:1fr}
    .status{grid-template-columns:1fr}
    .toggle-form{width:100%}
    .toggle-form .btn{flex:1 1 auto}
  }
  @media (max-width:560px){
    .row{grid-template-columns:auto 1fr;align-items:start}
    .row-actions{grid-column:1 / -1;justify-content:flex-start}
    .card{padding:.9rem}
    .topbar{gap:.6rem}
    .brand-txt span{font-size:.66rem}
  }
  @media (max-width:380px){
    .brand-mark{width:32px;height:32px;border-radius:9px;font-size:.82rem}
    .btn{padding:.5rem .7rem;font-size:.8rem}
  }
</style>
</head>
<body>
<div class="wrap">

<?php if (!$loggedIn): ?>

  <!-- ══════════ GİRİŞ ══════════ -->
  <div class="login-wrap">
    <div class="topbar">
      <div class="brand">
        <div class="brand-mark">SA</div>
        <div class="brand-txt">
          <b><?= e(SITE_NAME) ?></b>
          <span>Admin Panel</span>
        </div>
      </div>
      <div class="topbar-actions">
        <a class="btn btn-sm" href="../index.php">&larr; Sayta qayıt</a>
      </div>
    </div>

    <?php foreach ($flash as $f): ?>
      <div class="flash <?= e((string) $f['type']) ?>"><?= e((string) $f['message']) ?></div>
    <?php endforeach; ?>

    <div class="card">
      <div class="login-title">Panelə giriş</div>
      <div class="login-sub">Bu bölmə yalnız administrator üçündür.</div>

      <?php if (sky_admin_is_locked()): ?>
        <div class="flash warning">
          Çox sayda uğursuz cəhd. <?= (int) ceil(sky_admin_lock_seconds_left() / 60) ?> dəqiqə sonra yenidən cəhd edin.
        </div>
      <?php endif; ?>

      <form method="post" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="login">

        <div class="field" style="margin-bottom:.7rem">
          <label for="username">İstifadəçi adı</label>
          <input type="text" id="username" name="username" value="" required maxlength="60" autocapitalize="none" autocomplete="username">
        </div>

        <div class="field" style="margin-bottom:.9rem">
          <label for="password">Şifrə</label>
          <input type="password" id="password" name="password" value="" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%" <?= sky_admin_is_locked() ? 'disabled' : '' ?>>
          Daxil ol
        </button>
      </form>

      <div class="login-note">
        Giriş məlumatları layihə sənədində (<code>DEV-HANDOFF.md</code>) göstərilib.<br>
        İlk girişdən sonra şifrəni mütləq dəyişin.
      </div>
    </div>
  </div>

<?php else: ?>

  <!-- ══════════ PANEL ══════════ -->
  <div class="topbar">
    <div class="brand">
      <div class="brand-mark">SA</div>
      <div class="brand-txt">
        <b><?= e(SITE_NAME) ?></b>
        <span>Admin Panel</span>
      </div>
    </div>
    <div class="topbar-actions">
      <a class="btn btn-sm" href="../index.php#partners" target="_blank" rel="noopener">Saytda bölmə ↗</a>
      <a class="btn btn-sm" href="../index.php">Sayta keç</a>
      <form method="post" style="display:inline">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="logout">
        <button type="submit" class="btn btn-sm">Çıxış</button>
      </form>
    </div>
  </div>

  <?php foreach ($flash as $f): ?>
    <div class="flash <?= e((string) $f['type']) ?>"><?= e((string) $f['message']) ?></div>
  <?php endforeach; ?>

  <?php if (sky_admin_password_hash() === SKY_ADMIN_DEFAULT_HASH): ?>
    <div class="flash warning">
      <span>⚠</span>
      <span>Default admin şifrəsi hələ də aktivdir. Təhlükəsizlik üçün aşağıdakı «Şifrəni dəyiş» bölməsindən dərhal dəyişin.</span>
    </div>
  <?php endif; ?>

  <!-- ── Görünürlük ── -->
  <div class="card">
    <div class="status">
      <div class="status-state">
        <span class="dot <?= $sectionOn ? 'on' : 'off' ?>" aria-hidden="true"></span>
        <div style="min-width:0">
          <div class="status-title">
            «Əməkdaşlıq Etdiyimiz Brendlər» bölməsi:
            <?= $sectionOn ? 'GÖRÜNÜR' : 'GİZLİ' ?>
          </div>
          <div class="status-desc">
            <?php if (!$sectionOn): ?>
              Bölmə publik saytda göstərilmir (default vəziyyət).
            <?php elseif ($activeCount === 0): ?>
              Bölmə aktivdir, lakin aktiv brend yoxdur — saytda heç nə görünmür.
            <?php else: ?>
              Saytda <?= (int) $activeCount ?> brend göstərilir.
            <?php endif; ?>
            <?php if ($updatedAt !== ''): ?>
              · Son dəyişiklik: <?= e(date('d.m.Y H:i', strtotime($updatedAt) ?: time())) ?>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="toggle-form">
        <form method="post" style="display:inline">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="action" value="toggle_section">
          <input type="hidden" name="visible" value="<?= $sectionOn ? '0' : '1' ?>">
          <button type="submit" class="btn <?= $sectionOn ? '' : 'btn-primary' ?>">
            <?= $sectionOn ? 'Saytda gizlət' : 'Saytda göstər' ?>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- ── Brend əlavə / redaktə ── -->
  <div class="card">
    <div class="card-head">
      <div>
        <div class="card-title"><?= $editItem !== null ? 'Brendi redaktə et' : 'Yeni brend əlavə et' ?></div>
        <div class="card-sub">Ad, loqo (PNG/JPG/WEBP/GIF, maks. 3 MB) və istəyə bağlı vebsayt linki.</div>
      </div>
      <?php if ($editItem !== null): ?>
        <a class="btn btn-sm" href="index.php">Yeni brend</a>
      <?php endif; ?>
    </div>

    <?php if ($editItem === null && count($items) >= 60): ?>
      <div class="flash warning">Maksimum 60 brendə çatdınız. Yeni əlavə etmək üçün birini silin.</div>
    <?php else: ?>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <input type="hidden" name="action" value="save_partner">
      <input type="hidden" name="id" value="<?= e((string) ($editItem['id'] ?? '')) ?>">

      <div class="grid-2">
        <div class="field">
          <label for="name">Brend adı</label>
          <input type="text" id="name" name="name" maxlength="120"
                 value="<?= e((string) ($editItem['name'] ?? '')) ?>"
                 placeholder="Məs: Bravo Supermarket">
        </div>

        <div class="field">
          <label for="url">Vebsayt (istəyə bağlı)</label>
          <input type="url" id="url" name="url" maxlength="300"
                 value="<?= e((string) ($editItem['url'] ?? '')) ?>"
                 placeholder="https://brend.az">
        </div>

        <div class="field">
          <label for="logo">Loqo yüklə</label>
          <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/webp,image/gif">
          <span class="hint">Kvadrat və ya enli loqo daha yaxşı görünür.</span>

          <?php if (!empty($editItem['logo'])): ?>
            <div class="logo-current">
              <img src="../<?= e(sky_partner_logo_url((string) $editItem['logo'])) ?>" alt="">
              <label class="check">
                <input type="checkbox" name="remove_logo" value="1">
                Loqonu sil
              </label>
            </div>
          <?php endif; ?>
        </div>

        <div class="field" style="justify-content:flex-end">
          <label class="check" style="margin-bottom:.4rem">
            <input type="checkbox" name="item_visible" value="1"
              <?= ($editItem === null || !empty($editItem['visible'])) ? 'checked' : '' ?>>
            Bu brend saytda görünsün
          </label>
          <span class="hint">Brend görünən edildikdə bölmə də avtomatik açılır.</span>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <?= $editItem !== null ? 'Dəyişiklikləri saxla' : 'Brendi əlavə et' ?>
        </button>
        <?php if ($editItem !== null): ?>
          <a class="btn" href="index.php">Ləğv et</a>
        <?php endif; ?>
      </div>
    </form>
    <?php endif; ?>
  </div>

  <!-- ── Brend siyahısı ── -->
  <div class="card">
    <div class="card-head">
      <div>
        <div class="card-title">Brendlər (<?= count($items) ?>)</div>
        <div class="card-sub">
          Saytda görünən: <?= (int) $publicCount ?>
          <?= $sectionOn ? '' : ' — bölmə gizli olduğu üçün 0' ?>
        </div>
      </div>
      <div class="muted mono">data/partners.json</div>
    </div>

    <?php if (!$items): ?>
      <div class="empty">
        Hələ brend yoxdur. Yuxarıdakı forma ilə ilk brendi əlavə edin.<br>
        <span class="muted">Bölmə saytda yalnız o zaman görünəcək ki, görünürlük aktiv olsun və ən azı 1 aktiv brend olsun.</span>
      </div>
    <?php else: ?>
      <div class="list">
        <?php foreach ($items as $i => $item): ?>
          <div class="row <?= empty($item['visible']) ? 'is-off' : '' ?>">
            <div class="thumb">
              <?php if (!empty($item['logo'])): ?>
                <img src="../<?= e(sky_partner_logo_url((string) $item['logo'])) ?>" alt="">
              <?php else: ?>
                <span class="initials"><?= e(sky_partner_initials((string) $item['name'])) ?></span>
              <?php endif; ?>
            </div>

            <div class="row-main">
              <div class="row-name"><?= e((string) $item['name']) ?></div>
              <div class="row-meta">
                <?php if (!empty($item['url'])): ?>
                  <?= e((string) $item['url']) ?>
                <?php else: ?>
                  <span class="muted">link yoxdur</span>
                <?php endif; ?>
              </div>
              <div style="margin-top:.3rem">
                <span class="badge <?= !empty($item['visible']) ? 'on' : 'off' ?>">
                  <?= !empty($item['visible']) ? 'aktiv' : 'gizli' ?>
                </span>
              </div>
            </div>

            <div class="row-actions">
              <form method="post">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="move_partner">
                <input type="hidden" name="id" value="<?= e((string) $item['id']) ?>">
                <input type="hidden" name="dir" value="up">
                <button type="submit" class="btn btn-sm" title="Yuxarı" <?= $i === 0 ? 'disabled' : '' ?>>↑</button>
              </form>
              <form method="post">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="move_partner">
                <input type="hidden" name="id" value="<?= e((string) $item['id']) ?>">
                <input type="hidden" name="dir" value="down">
                <button type="submit" class="btn btn-sm" title="Aşağı" <?= $i === count($items) - 1 ? 'disabled' : '' ?>>↓</button>
              </form>
              <form method="post">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="toggle_partner">
                <input type="hidden" name="id" value="<?= e((string) $item['id']) ?>">
                <button type="submit" class="btn btn-sm"><?= !empty($item['visible']) ? 'Gizlət' : 'Göstər' ?></button>
              </form>
              <a class="btn btn-sm" href="index.php?edit=<?= e(urlencode((string) $item['id'])) ?>">Redaktə</a>
              <form method="post" onsubmit="return confirm('Bu brend silinsin?');">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="delete_partner">
                <input type="hidden" name="id" value="<?= e((string) $item['id']) ?>">
                <button type="submit" class="btn btn-sm btn-danger">Sil</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- ── Şifrə ── -->
  <div class="card">
    <details class="pw">
      <summary>Şifrəni dəyiş</summary>
      <form method="post" style="margin-top:.9rem">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="change_password">

        <div class="grid-2">
          <div class="field">
            <label for="current_password">Cari şifrə</label>
            <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
          </div>
          <div class="field">
            <label for="new_password">Yeni şifrə (min. 8 simvol)</label>
            <input type="password" id="new_password" name="new_password" required minlength="8" autocomplete="new-password">
          </div>
          <div class="field">
            <label for="repeat_password">Yeni şifrə (təkrar)</label>
            <input type="password" id="repeat_password" name="repeat_password" required minlength="8" autocomplete="new-password">
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn">Şifrəni yenilə</button>
        </div>
      </form>
    </details>
  </div>

  <p class="muted" style="text-align:center;margin-top:1.4rem">
    <?= e(SITE_NAME) ?> · Admin Panel · Bölmə publik saytda default olaraq gizlidir.
  </p>

<?php endif; ?>

</div>
</body>
</html>
