<?php
/**
 * SKY BEAUTY — Salon idarəetmə paneli
 * ---------------------------------------------------------------
 * Şifrə: config/secrets.php → SKY_SECRET_BEAUTY_PANEL_PASSWORD.
 * İdarə edir:
 *   • Salon adı, telefon, WhatsApp, sosial şəbəkələr, ünvan, iş saatları
 *   • 10 rəng teması (pink/rose daxil)
 *   • Xidmətlər: ad (4 dil), qiymət, köhnə qiymət (təklif), müddət, aktivlik
 *
 * Dəyişikliklər `data/demo-beauty.json` faylına atomik yazılır;
 * demo (`demo-beauty.php`) həmin faylı oxuyur. Default dəyərlər
 * `config/demo-beauty.php`-də qalır — «Sıfırla» düyməsi JSON-u silir.
 */
declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/beauty-media.php';
require_once __DIR__ . '/../../config/beauty-bookings.php';
require_once __DIR__ . '/../../config/beauty-reviews.php';
require_once __DIR__ . '/../../config/beauty-inbox.php';
require_once __DIR__ . '/../../config/beauty-staff.php';
require_once __DIR__ . '/../../config/beauty-studio.php';

ob_start(static function (string $html): string { return sky_translate_document_html($html); });

header('X-Robots-Tag: noindex, nofollow', true);
header('Referrer-Policy: same-origin', true);

if (!defined('BEAUTY_PANEL_PASSWORD')) {
    define('BEAUTY_PANEL_PASSWORD', defined('SKY_SECRET_BEAUTY_PANEL_PASSWORD') ? SKY_SECRET_BEAUTY_PANEL_PASSWORD : '');
}
const BEAUTY_LANGS = ['az', 'en', 'tr', 'ru'];
const BEAUTY_LANG_LABELS = ['az' => 'AZ', 'en' => 'EN', 'tr' => 'TR', 'ru' => 'RU'];
const BEAUTY_SERVICE_CATS = ['hair', 'nails', 'face', 'makeup'];
const BEAUTY_CAT_LABELS = ['hair' => 'Saç', 'nails' => 'Dırnaq', 'face' => 'Üz / Spa', 'makeup' => 'Makiyaj'];

$root    = dirname(__DIR__, 2);
$cfgPath = $root . '/config/demo-beauty.php';
$jsonPath = $root . '/data/demo-beauty.json';

$CFG = require $cfgPath;
$studioCfg = require $root . '/config/beauty-styles.php';
$studioPalette = bsx_palette();

/* ───────────────────────── Köməkçilər ───────────────────────── */

function bp_e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function bp_flash(string $type, string $msg): void {
    $_SESSION['bp_flash'][] = ['type' => $type, 'msg' => $msg];
}

function bp_take_flash(): array {
    $f = $_SESSION['bp_flash'] ?? [];
    unset($_SESSION['bp_flash']);
    return is_array($f) ? $f : [];
}

function bp_redirect(): void {
    header('Location: beauty-panel.php');
    exit;
}

function bp_redirect_query(array $params): void {
    $params = array_filter($params, fn($v) => $v !== '' && $v !== null);
    $q = http_build_query($params);
    header('Location: beauty-panel.php' . ($q !== '' ? '?' . $q : ''));
    exit;
}

/** Panel daxilində status etiketləri (panelin özü tam AZ-dır). */
function bp_status_label(string $s): string {
    $m = [
        'pending'   => 'Beh gözlənilir',
        'confirmed' => 'Təsdiqləndi',
        'completed' => 'Tamamlandı',
        'no_show'   => 'Gəlmədi',
        'cancelled' => 'Ləğv edildi',
    ];
    return $m[$s] ?? $s;
}

function bp_is_post(): bool {
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

/** Panelin nəzərdə tutduğu JSON strukturunu qaytarır (default + mövcud override). */
function bp_state(string $jsonPath, array $cfg): array {
    $state = [
        'brand'    => $cfg['brand'],
        'theme'    => $cfg['theme'] ?? 'rose',
        'services' => [],
        'booking'  => bb_default_settings(),
        'offer'    => bb_offer($cfg),
    ];
    foreach ($cfg['services'] as $s) {
        $state['services'][(string)$s['id']] = [
            'active'    => $s['active'] ?? true,
            'cat'       => (string)($s['cat'] ?? 'hair'),
            'img'       => (string)($s['img'] ?? ''),
            'custom'    => false,
            'price'     => (int)$s['price'],
            'old_price' => (int)($s['old_price'] ?? 0),
            'duration'  => (int)$s['duration'],
            'title'     => $s['title'],
            'desc'      => $s['desc'],
        ];
    }

    if (!is_file($jsonPath)) return $state;
    $over = json_decode((string)file_get_contents($jsonPath), true);
    if (!is_array($over)) return $state;

    if (!empty($over['brand']) && is_array($over['brand'])) {
        foreach (['name', 'phone', 'whatsapp', 'instagram', 'tiktok', 'facebook'] as $k) {
            if (array_key_exists($k, $over['brand'])) $state['brand'][$k] = (string)$over['brand'][$k];
        }
        foreach (['address', 'hours'] as $k) {
            if (!empty($over['brand'][$k]) && is_array($over['brand'][$k])) {
                foreach (BEAUTY_LANGS as $l) {
                    if (isset($over['brand'][$k][$l])) $state['brand'][$k][$l] = (string)$over['brand'][$k][$l];
                }
            }
        }
    }
    if (!empty($over['theme']) && isset($cfg['themes'][$over['theme']])) {
        $state['theme'] = (string)$over['theme'];
    }
    if (!empty($over['services']) && is_array($over['services'])) {
        foreach ($state['services'] as $id => $s) {
            $ov = $over['services'][$id] ?? null;
            if (!is_array($ov)) continue;
            foreach (['price', 'old_price', 'duration'] as $k) {
                if (array_key_exists($k, $ov)) $state['services'][$id][$k] = (int)$ov[$k];
            }
            if (array_key_exists('active', $ov)) $state['services'][$id]['active'] = (bool)$ov['active'];
            if (!empty($ov['cat']) && in_array((string)$ov['cat'], BEAUTY_SERVICE_CATS, true)) {
                $state['services'][$id]['cat'] = (string)$ov['cat'];
            }
            if (!empty($ov['img']) && is_string($ov['img'])) {
                $state['services'][$id]['img'] = (string)$ov['img'];
            }
            foreach (['title', 'desc'] as $k) {
                if (!empty($ov[$k]) && is_array($ov[$k])) {
                    foreach (BEAUTY_LANGS as $l) {
                        if (isset($ov[$k][$l]) && $ov[$k][$l] !== '') {
                            $state['services'][$id][$k][$l] = (string)$ov[$k][$l];
                        }
                    }
                }
            }
        }
        // Panel ilə əlavə olunmuş xidmətlər default kataloqda yoxdur.
        foreach ($over['services'] as $key => $ov) {
            if (!is_array($ov) || empty($ov['custom'])) continue;
            $id = (string)$key;
            if (isset($state['services'][$id])) continue;
            $title = isset($ov['title']) && is_array($ov['title']) ? $ov['title'] : [];
            $desc  = isset($ov['desc']) && is_array($ov['desc']) ? $ov['desc'] : [];
            if (trim((string)($title['az'] ?? '')) === '') continue;
            $state['services'][$id] = [
                'active'    => (bool)($ov['active'] ?? true),
                'cat'       => in_array((string)($ov['cat'] ?? ''), BEAUTY_SERVICE_CATS, true) ? (string)$ov['cat'] : 'hair',
                'img'       => (string)($ov['img'] ?? ''),
                'custom'    => true,
                'price'     => max(0, (int)($ov['price'] ?? 0)),
                'old_price' => max(0, (int)($ov['old_price'] ?? 0)),
                'duration'  => max(0, (int)($ov['duration'] ?? 30)),
                'title'     => $title,
                'desc'      => $desc,
            ];
        }
    }
    $state['booking'] = bb_settings($over);
    $state['offer']   = bb_offer($cfg, $over);
    return $state;
}

/** JSON-a yazılan tam payload (bütün bölmələr). */
function bp_payload(array $state): array {
    return [
        'updated'  => date('c'),
        'brand'    => $state['brand'],
        'theme'    => $state['theme'],
        'services' => $state['services'],
        'booking'  => $state['booking'],
        'offer'    => $state['offer'],
    ];
}

/** Atomik JSON yazısı (tmp + rename). */
function bp_save(string $path, array $data): bool {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) return false;
    $tmp = $path . '.tmp' . bin2hex(random_bytes(4));
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    if (!rename($tmp, $path)) {
        @unlink($tmp);
        return false;
    }
    return true;
}

/* ───────────────────────── Giriş / çıxış ───────────────────────── */

if (isset($_GET['logout'])) {
    unset($_SESSION['bp_ok']);
    bp_flash('ok', 'Panelden çıxdınız.');
    bp_redirect();
}

$loginError = '';
if (bp_is_post() && ($_POST['action'] ?? '') === 'login') {
    if (!csrf_verify((string)($_POST['csrf'] ?? ''))) {
        $loginError = 'Təhlükəsizlik xətası (CSRF). Səhifəni yeniləyin.';
    } elseif (BEAUTY_PANEL_PASSWORD !== ''
        && hash_equals(BEAUTY_PANEL_PASSWORD, (string)($_POST['password'] ?? ''))) {
        $_SESSION['bp_ok'] = true;
        bp_redirect();
    } else {
        usleep(400000);
        $loginError = 'Şifrə yanlışdır.';
    }
}

$authed = !empty($_SESSION['bp_ok']);
$state  = bp_state($jsonPath, $CFG);
$gallery = beauty_gallery_read();
$mediaBase = '../../uploads/beauty/';
$mediaLimits = beauty_media_limits();

/* ───────────────────────── Rezervasiya / davamiyyət / hesabat dataları ───────────────────────── */

$validDate = fn($v): bool => is_string($v) && (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $v);

$bookStore = bb_bookings();
$custStore = bb_customers();
$attStore  = bb_attendance();

$bDate   = $validDate($_GET['bdate'] ?? '') ? (string)$_GET['bdate'] : '';
$bStatus = in_array($_GET['bstatus'] ?? '', BB_STATUSES, true) ? (string)$_GET['bstatus'] : '';
$adate   = $validDate($_GET['adate'] ?? '') ? (string)$_GET['adate'] : date('Y-m-d');
$rdate   = $validDate($_GET['rdate'] ?? '') ? (string)$_GET['rdate'] : date('Y-m-d');

$viewBookings = array_values(array_filter($bookStore['items'], function ($b) use ($bDate, $bStatus) {
    if ($bDate !== '' && ($b['date'] ?? '') !== $bDate) return false;
    if ($bStatus !== '' && ($b['status'] ?? '') !== $bStatus) return false;
    return true;
}));
$statusOrder = ['pending' => 0, 'confirmed' => 1, 'completed' => 2, 'no_show' => 3, 'cancelled' => 4];
usort($viewBookings, function ($a, $b) use ($statusOrder) {
    $oa = $statusOrder[$a['status'] ?? 'pending'] ?? 9;
    $ob = $statusOrder[$b['status'] ?? 'pending'] ?? 9;
    if ($oa !== $ob) return $oa <=> $ob;
    return strcmp(($a['date'] ?? '') . ' ' . ($a['time'] ?? ''), ($b['date'] ?? '') . ' ' . ($b['time'] ?? ''));
});

$pendingCount = count(array_filter($bookStore['items'], fn($b) => ($b['status'] ?? '') === 'pending'));

$customers = array_values($custStore['customers']);
usort($customers, fn($a, $b) => strcmp((string)($b['last'] ?? ''), (string)($a['last'] ?? '')));
$customersTop = array_slice($customers, 0, 20);

$report = bb_report($rdate, $CFG);
$workingCount = 0;
foreach (($CFG['stylists'] ?? []) as $st) {
    if (bb_attendance_state($attStore, $adate, (string)$st['name']) === 'work') $workingCount++;
}

/* ─────────────── Ustalar (profillər) + rəylər ─────────────── */

$staffAll = bs_list($CFG, false);
$studioAll = bsx_all_styles($studioCfg);
$studioCats = $studioCfg['categories'] ?? [];

$reviewsAll     = br_list();
$reviewsPending = array_values(array_filter($reviewsAll, fn($r) => ($r['status'] ?? '') === 'pending'));
$reviewsHidden  = array_values(array_filter($reviewsAll, fn($r) => ($r['status'] ?? '') === 'hidden'));
$reviewsPublic  = array_values(array_filter($reviewsAll, fn($r) => ($r['status'] ?? '') === 'approved'));
$rSummary       = br_summary();
$pendingComments = br_pending_comments();
$reviewByCode   = [];
foreach ($reviewsAll as $rv) {
    $reviewByCode[(string)($rv['code'] ?? '')] = $rv;
}

/* ─────────────── Usta inbox-u (bron mesajları) ─────────────── */

$masterNames = bi_master_names($CFG);
$inboxMaster = in_array($_GET['imaster'] ?? '', $masterNames, true) ? (string)$_GET['imaster'] : '';
$inboxItems  = bi_list($inboxMaster);
$inboxCounts = bi_counts();
$waNumber    = preg_replace('/\D+/', '', (string)($state['brand']['whatsapp'] ?? ''));
$waLink      = $waNumber !== '' ? 'https://wa.me/' . $waNumber : '';

$demoAbs = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')
    . rtrim(str_replace('\\', '/', dirname((string)($_SERVER['SCRIPT_NAME'] ?? '/sky/modules/web-demos/beauty-panel.php'))), '/')
    . '/demo-beauty.php';

/* ───────────────────────── POST əməliyyatları ───────────────────────── */

if ($authed && bp_is_post()) {
    if (!csrf_verify((string)($_POST['csrf'] ?? ''))) {
        bp_flash('err', 'Təhlükəsizlik xətası (CSRF). Yenidən cəhd edin.');
        bp_redirect();
    }
    $action = (string)($_POST['action'] ?? '');

    if ($action === 'save_salon') {
        foreach (['name', 'phone', 'whatsapp', 'instagram', 'tiktok', 'facebook'] as $k) {
            $state['brand'][$k] = trim((string)($_POST['brand'][$k] ?? ''));
        }
        foreach (['address', 'hours'] as $k) {
            foreach (BEAUTY_LANGS as $l) {
                $state['brand'][$k][$l] = trim((string)($_POST['brand'][$k][$l] ?? ''));
            }
        }
        $theme = (string)($_POST['theme'] ?? 'rose');
        if (isset($CFG['themes'][$theme])) $state['theme'] = $theme;
        $state['brand']['name'] = $state['brand']['name'] !== '' ? $state['brand']['name'] : 'Sky Beauty';

        bp_save($jsonPath, bp_payload($state))
            ? bp_flash('ok', 'Salon məlumatları yadda saxlanıldı.')
            : bp_flash('err', 'Yazma alınmadı. `data/` qovluğunun icazəsini yoxlayın.');
        bp_redirect();
    }

    if ($action === 'save_services') {
        foreach ($state['services'] as $id => $s) {
            $price = max(0, (int)($_POST['svc'][$id]['price'] ?? $s['price']));
            $old   = max(0, (int)($_POST['svc'][$id]['old_price'] ?? $s['old_price']));
            $dur   = max(0, (int)($_POST['svc'][$id]['duration'] ?? $s['duration']));
            if ($old > 0 && $old <= $price) $old = 0; // köhnə qiymət yeni qiymətdən böyük olmalıdır
            $state['services'][$id]['price'] = $price;
            $state['services'][$id]['old_price'] = $old;
            $state['services'][$id]['duration'] = $dur;
            $state['services'][$id]['active'] = !empty($_POST['svc'][$id]['active']);
            $cat = (string)($_POST['svc'][$id]['cat'] ?? $state['services'][$id]['cat']);
            if (in_array($cat, BEAUTY_SERVICE_CATS, true)) $state['services'][$id]['cat'] = $cat;
            $img = trim((string)($_POST['svc'][$id]['img'] ?? ''));
            if ($img !== '') $state['services'][$id]['img'] = $img;
            foreach (BEAUTY_LANGS as $l) {
                $t = trim((string)($_POST['svc'][$id]['title'][$l] ?? ''));
                $d = trim((string)($_POST['svc'][$id]['desc'][$l] ?? ''));
                if ($t !== '') $state['services'][$id]['title'][$l] = $t;
                if ($d !== '') $state['services'][$id]['desc'][$l] = $d;
            }
        }
        bp_save($jsonPath, bp_payload($state))
            ? bp_flash('ok', 'Qiymətlər və mətnlər yadda saxlanıldı.')
            : bp_flash('err', 'Yazma alınmadı. `data/` qovluğunun icazəsini yoxlayın.');
        bp_redirect();
    }

    if ($action === 'add_service') {
        $azTitle = trim((string)($_POST['new']['title']['az'] ?? ''));
        if ($azTitle === '') {
            bp_flash('err', 'Yeni xidmət üçün azərbaycanca ad yazın.');
            bp_redirect_query(['tab' => 'services']);
        }
        $ids = array_map('intval', array_keys($state['services']));
        $newId = max(900, !empty($ids) ? max($ids) + 1 : 900);
        $titles = [];
        $descs  = [];
        foreach (BEAUTY_LANGS as $l) {
            $titles[$l] = trim((string)($_POST['new']['title'][$l] ?? ''));
            if ($titles[$l] === '') $titles[$l] = $azTitle;
            $descs[$l] = trim((string)($_POST['new']['desc'][$l] ?? ''));
        }
        $old = max(0, (int)($_POST['new']['old_price'] ?? 0));
        $price = max(0, (int)($_POST['new']['price'] ?? 0));
        if ($old > 0 && $old <= $price) $old = 0;
        $state['services'][(string)$newId] = [
            'active'    => true,
            'cat'       => in_array((string)($_POST['new']['cat'] ?? ''), BEAUTY_SERVICE_CATS, true)
                ? (string)$_POST['new']['cat'] : 'hair',
            'img'       => trim((string)($_POST['new']['img'] ?? '')) ?: (string)($CFG['services'][0]['img'] ?? ''),
            'custom'    => true,
            'price'     => $price,
            'old_price' => $old,
            'duration'  => max(0, (int)($_POST['new']['duration'] ?? 30)),
            'title'     => $titles,
            'desc'      => $descs,
        ];
        bp_save($jsonPath, bp_payload($state))
            ? bp_flash('ok', 'Yeni xidmət əlavə edildi — saytda dərhal görünür.')
            : bp_flash('err', 'Yazma alınmadı. `data/` qovluğunun icazəsini yoxlayın.');
        bp_redirect_query(['tab' => 'services']);
    }

    if ($action === 'save_offer') {
        $sid = (int)($_POST['offer']['service_id'] ?? 0);
        $svc = $state['services'][(string)$sid] ?? null;
        if (!is_array($svc)) {
            bp_flash('err', 'Təklif üçün xidmət seçin.');
            bp_redirect_query(['tab' => 'offers']);
        }
        $price = max(0, (int)($_POST['offer']['price'] ?? 0));
        if ($price > 0 && $price >= (int)$svc['price']) {
            bp_flash('err', 'Təklif qiyməti xidmətin qiymətindən (' . (int)$svc['price'] . ' AZN) kiçik olmalıdır.');
            bp_redirect_query(['tab' => 'offers']);
        }
        $note = [];
        foreach (BEAUTY_LANGS as $l) {
            $note[$l] = trim((string)($_POST['offer']['note'][$l] ?? ''));
        }
        $state['offer'] = [
            'active'     => !empty($_POST['offer']['active']),
            'service_id' => $sid,
            'price'      => $price,
            'period'     => (string)($_POST['offer']['period'] ?? 'daily') === 'weekly' ? 'weekly' : 'daily',
            'audience'   => (string)($_POST['offer']['audience'] ?? 'all') === 'corporate' ? 'corporate' : 'all',
            'note'       => $note,
        ];
        bp_save($jsonPath, bp_payload($state))
            ? bp_flash('ok', 'Təklif yadda saxlanıldı — saytda dərhal görünür.')
            : bp_flash('err', 'Yazma alınmadı. `data/` qovluğunun icazəsini yoxlayın.');
        bp_redirect_query(['tab' => 'offers']);
    }

    if ($action === 'save_booking_settings') {
        $state['booking']['card_number'] = trim((string)($_POST['booking']['card_number'] ?? ''));
        $state['booking']['card_holder'] = trim((string)($_POST['booking']['card_holder'] ?? ''));
        $state['booking']['deposit_percent'] = min(100, max(1, (int)($_POST['booking']['deposit_percent'] ?? 20)));
        $state['booking']['deposit_min'] = min(1000, max(0, (int)($_POST['booking']['deposit_min'] ?? 10)));
        bp_save($jsonPath, bp_payload($state))
            ? bp_flash('ok', 'Beh ayarları və kart nömrəsi yadda saxlanıldı.')
            : bp_flash('err', 'Yazma alınmadı. `data/` qovluğunun icazəsini yoxlayın.');
        bp_redirect_query(['bdate' => (string)($_POST['bdate'] ?? ''), 'bstatus' => (string)($_POST['bstatus'] ?? '')]);
    }

    if ($action === 'booking_status') {
        $code   = trim((string)($_POST['code'] ?? ''));
        $status = (string)($_POST['status'] ?? '');
        $res    = bb_set_status($code, $status);
        if (!empty($res['ok'])) {
            bp_flash('ok', $code . ' → ' . bp_status_label($status));
        } else {
            bp_flash('err', (string)($res['error'] ?? 'Status dəyişmədi.'));
        }
        bp_redirect_query(['bdate' => (string)($_POST['bdate'] ?? ''), 'bstatus' => (string)($_POST['bstatus'] ?? '')]);
    }

    if ($action === 'delete_booking') {
        $code = trim((string)($_POST['code'] ?? ''));
        bb_delete_booking($code)
            ? bp_flash('ok', $code . ' bronu silindi.')
            : bp_flash('err', 'Bron silinmədi.');
        bp_redirect_query(['bdate' => (string)($_POST['bdate'] ?? ''), 'bstatus' => (string)($_POST['bstatus'] ?? '')]);
    }

    if ($action === 'set_attendance') {
        $date    = (string)($_POST['adate'] ?? '');
        $stylist = (string)($_POST['stylist'] ?? '');
        $stState = (string)($_POST['state'] ?? 'work') === 'off' ? 'off' : 'work';
        $names = array_map(fn($s) => (string)$s['name'], $CFG['stylists'] ?? []);
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || !in_array($stylist, $names, true)) {
            bp_flash('err', 'Davamiyyət məlumatı düzgün deyil.');
        } elseif (bb_set_attendance($date, $stylist, $stState)) {
            bp_flash('ok', $stylist . ' — ' . $date . ' → ' . ($stState === 'off' ? 'İşdə deyil' : 'İşdədir'));
        } else {
            bp_flash('err', 'Davamiyyət yazılmadı.');
        }
        bp_redirect_query(['adate' => $date]);
    }

    if ($action === 'save_staff_profile') {
        $res = bs_save_profile($_POST, $_FILES['photo'] ?? [], $CFG);
        if (!empty($res['ok'])) {
            bp_flash('ok', 'Usta profili yadda saxlanıldı: ' . (string)($_POST['name'] ?? ''));
        } else {
            bp_flash('err', (string)($res['error'] ?? 'Yazma alınmadı.'));
        }
        bp_redirect_query(['tab' => 'staff']);
    }

    if ($action === 'save_style') {
        $res = bsx_save_style($_POST, $_FILES['img'] ?? [], $studioCfg);
        if (!empty($res['ok'])) {
            bp_flash('ok', 'Stil yadda saxlanıldı — saytda dərhal görünür.');
        } else {
            bp_flash('err', (string)($res['error'] ?? 'Yazma alınmadı.'));
        }
        bp_redirect_query(['tab' => 'studio']);
    }

    if ($action === 'delete_style') {
        $res = bsx_delete_style((string)($_POST['id'] ?? ''), $studioCfg);
        if (!empty($res['ok'])) {
            bp_flash('ok', 'Stil kataloqdan çıxarıldı.');
        } else {
            bp_flash('err', (string)($res['error'] ?? 'Silinmədi.'));
        }
        bp_redirect_query(['tab' => 'studio']);
    }

    if ($action === 'review_status') {
        $id  = trim((string)($_POST['id'] ?? ''));
        $st  = (string)($_POST['status'] ?? '');
        $res = br_set_status($id, $st);
        $labels = ['approved' => 'dərc edildi', 'hidden' => 'gizlədildi', 'pending' => 'gözləməyə qaytarıldı'];
        if (!empty($res['ok'])) {
            bp_flash('ok', $id . ' ' . ($labels[$st] ?? 'yeniləndi') . '.');
        } else {
            bp_flash('err', (string)($res['error'] ?? 'Status dəyişmədi.'));
        }
        bp_redirect_query(['tab' => 'reviews']);
    }

    if ($action === 'review_reply') {
        $id  = trim((string)($_POST['id'] ?? ''));
        $res = br_set_reply($id, (string)($_POST['reply'] ?? ''));
        if (!empty($res['ok'])) {
            bp_flash('ok', $id . ' — cavab yadda saxlanıldı.');
        } else {
            bp_flash('err', (string)($res['error'] ?? 'Cavab yazılmadı.'));
        }
        bp_redirect_query(['tab' => 'reviews']);
    }

    if ($action === 'comment_status') {
        $rid  = trim((string)($_POST['rid'] ?? ''));
        $cid  = trim((string)($_POST['cid'] ?? ''));
        $st   = (string)($_POST['cstatus'] ?? '');
        $res  = br_set_comment_status($rid, $cid, $st);
        $labels = ['approved' => 'dərc edildi', 'hidden' => 'gizlədildi'];
        if (!empty($res['ok'])) {
            bp_flash('ok', $cid . ' fikri ' . ($labels[$st] ?? 'yeniləndi') . '.');
        } else {
            bp_flash('err', (string)($res['error'] ?? 'Fikir yenilənmədi.'));
        }
        bp_redirect_query(['tab' => 'reviews']);
    }

    if ($action === 'delete_review') {
        $id = trim((string)($_POST['id'] ?? ''));
        br_delete($id)
            ? bp_flash('ok', $id . ' rəyi silindi.')
            : bp_flash('err', 'Rəy silinmədi.');
        bp_redirect_query(['tab' => 'reviews']);
    }

    /* ── Usta inbox-u ── */
    if ($action === 'inbox_status') {
        $id  = trim((string)($_POST['id'] ?? ''));
        $st  = (string)($_POST['istatus'] ?? '');
        $labels = ['new' => 'yeni', 'read' => 'oxundu', 'replied' => 'cavablandı'];
        bi_set_status($id, $st)
            ? bp_flash('ok', $id . ' — ' . ($labels[$st] ?? 'yeniləndi') . '.')
            : bp_flash('err', 'Mesaj statusu dəyişmədi.');
        bp_redirect_query(['tab' => 'messages', 'imaster' => (string)($_POST['imaster'] ?? '')]);
    }

    if ($action === 'inbox_reply') {
        $id = trim((string)($_POST['id'] ?? ''));
        bi_reply($id, (string)($_POST['reply'] ?? ''))
            ? bp_flash('ok', $id . ' — cavab ustaya qeyd edildi.')
            : bp_flash('err', 'Cavab yazılmadı.');
        bp_redirect_query(['tab' => 'messages', 'imaster' => (string)($_POST['imaster'] ?? '')]);
    }

    if ($action === 'inbox_delete') {
        $id = trim((string)($_POST['id'] ?? ''));
        bi_delete($id)
            ? bp_flash('ok', $id . ' mesajı silindi.')
            : bp_flash('err', 'Mesaj silinmədi.');
        bp_redirect_query(['tab' => 'messages', 'imaster' => (string)($_POST['imaster'] ?? '')]);
    }

    if ($action === 'reset') {
        if (is_file($jsonPath)) @unlink($jsonPath);
        $studioStore = $root . '/data/beauty-studio.json';
        if (is_file($studioStore)) @unlink($studioStore);
        foreach ((glob(bsx_upload_dir() . '/style-*') ?: []) as $sf) @unlink($sf);
        bp_flash('ok', 'Bütün dəyişikliklər sıfırlandı — default dəyərlər bərpa olundu.');
        bp_redirect();
    }

    /* ── Loqo yükləmə ── */
    if ($action === 'save_logo') {
        $f = $_FILES['logo'] ?? null;
        $dir = beauty_media_dir();
        if (!$f || ($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            bp_flash('err', 'Loqo faylı seçilmədi.');
        } elseif ($f['size'] > 3 * 1024 * 1024) {
            bp_flash('err', 'Loqo 3 MB-dan böyük olmamalıdır.');
        } elseif (!($info = @getimagesize($f['tmp_name']))) {
            bp_flash('err', 'Loqo şəkil deyil (PNG, JPG, WEBP).');
        } else {
            $extMap = [IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_WEBP => 'webp'];
            $ext = $extMap[$info[2]] ?? '';
            if ($ext === '') {
                bp_flash('err', 'Yalnız PNG, JPG və ya WEBP qəbul olunur.');
            } else {
                if (!is_dir($dir)) @mkdir($dir, 0775, true);
                $g = beauty_gallery_read();
                $old = !empty($g['logo']) ? $dir . '/' . basename($g['logo']) : '';
                $name = 'logo-' . bin2hex(random_bytes(3)) . '.' . $ext;
                if (move_uploaded_file($f['tmp_name'], $dir . '/' . $name)) {
                    $g['logo'] = $name;
                    beauty_gallery_write($g);
                    if ($old !== '' && is_file($old) && basename($old) !== $name && basename($old) !== 'logo.png') @unlink($old);
                    bp_flash('ok', 'Loqo yükləndi — bütün yeni şəkil/videolara avtomatik vurulacaq.');
                } else {
                    bp_flash('err', 'Loqo saxlanmadı (qovluq icazəsi).');
                }
            }
        }
        bp_redirect();
    }

    /* ── Qalereya: şəkil / video yükləmə (limitlər + watermark) ── */
    if ($action === 'upload_media') {
        $type  = (string)($_POST['media_type'] ?? 'photo');
        $title = trim((string)($_POST['media_title'] ?? ''));
        $title = function_exists('mb_substr') ? mb_substr($title, 0, 80) : substr($title, 0, 240);
        $f     = $_FILES['media'] ?? null;
        $dir   = beauty_media_dir();
        $lim   = beauty_media_limits();
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        $g = beauty_gallery_read();

        if (!$f || ($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            bp_flash('err', 'Fayl seçilmədi.');
        } elseif ($type === 'photo') {
            $info = @getimagesize($f['tmp_name']);
            $mime = is_array($info) ? (string)($info['mime'] ?? '') : '';
            if ($f['size'] > (int)$lim['photo_mb'] * 1048576) {
                bp_flash('err', 'Şəkil ' . (int)$lim['photo_mb'] . ' MB-dan böyük olmamalıdır.');
            } elseif (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
                bp_flash('err', 'Şəkil düzgün deyil — JPG, PNG və ya WEBP seçin.');
            } else {
                $name = 'photo-' . bin2hex(random_bytes(6)) . '.jpg';
                $tmp  = $dir . '/_upl-' . bin2hex(random_bytes(4));
                if (move_uploaded_file($f['tmp_name'], $tmp) && beauty_watermark_image($tmp, $dir . '/' . $name)) {
                    @unlink($tmp);
                    $item = ['file' => $name, 'type' => 'photo', 'added' => date('c')];
                    if ($title !== '') $item['title'] = $title;
                    $g['items'][] = $item;
                    beauty_gallery_write($g);
                    bp_flash('ok', 'Şəkil qalereyaya əlavə edildi.');
                } else {
                    @unlink($tmp);
                    bp_flash('err', 'Şəkil emal olunmadı.');
                }
            }
        } elseif ($type === 'video') {
            $ext    = strtolower(pathinfo((string)($f['name'] ?? ''), PATHINFO_EXTENSION));
            $maxSec = (int)$lim['video_sec'];
            if ($ext !== 'mp4') {
                bp_flash('err', 'Video yalnız MP4 formatında olmalıdır.');
            } elseif ($f['size'] > (int)$lim['video_mb'] * 1048576) {
                bp_flash('err', 'Video ' . (int)$lim['video_mb'] . ' MB-dan böyük olmamalıdır.');
            } elseif (beauty_find_ffmpeg() === '' || beauty_find_ffprobe() === '') {
                bp_flash('err', 'ffmpeg/ffprobe tapılmadı — video emal edilə bilmir.');
            } else {
                $name  = 'video-' . bin2hex(random_bytes(6)) . '.mp4';
                $tmp   = $dir . '/_upl-' . bin2hex(random_bytes(4)) . '.mp4';
                $moved = move_uploaded_file($f['tmp_name'], $tmp);
                $dur   = $moved ? beauty_video_duration($tmp) : null;
                if ($dur !== null && $dur > $maxSec + 0.2) {
                    @unlink($tmp);
                    bp_flash('err', 'Video ' . $maxSec . ' saniyədən uzundur (' . round($dur) . ' s). Qısaldıb yenidən yükləyin.');
                } elseif ($moved && beauty_watermark_video($tmp, $dir . '/' . $name)) {
                    @unlink($tmp);
                    $item = [
                        'file' => $name,
                        'type' => 'video',
                        'added' => date('c'),
                        'duration' => $dur !== null ? round($dur, 1) : null,
                    ];
                    $poster = 'poster-' . bin2hex(random_bytes(6)) . '.jpg';
                    if (beauty_video_poster($dir . '/' . $name, $dir . '/' . $poster)) {
                        $item['poster'] = $poster;
                    }
                    if ($title !== '') $item['title'] = $title;
                    $g['items'][] = $item;
                    beauty_gallery_write($g);
                    bp_flash('ok', 'Video qalereyaya əlavə edildi (max ' . $maxSec . ' saniyə).');
                } else {
                    @unlink($tmp);
                    bp_flash('err', 'Video emal olunmadı — MP4 kodeyini yoxlayın.');
                }
            }
        }
        bp_redirect();
    }

    /* ── Qalereyadan silmə (poster də silinir) ── */
    if ($action === 'delete_media') {
        $file = basename((string)($_POST['file'] ?? ''));
        if (preg_match('/^(photo|video|poster)-[a-f0-9]{8,}\.(jpg|mp4)$/', $file)) {
            $g = beauty_gallery_read();
            foreach ($g['items'] as $it) {
                if (($it['poster'] ?? '') === $file) {
                    $file = (string)$it['file'];
                    break;
                }
            }
            $g['items'] = array_values(array_filter($g['items'], fn($it) => ($it['file'] ?? '') !== $file));
            beauty_gallery_write($g);
            foreach ([$file, preg_replace('/^video-/', 'poster-', preg_replace('/\.mp4$/', '.jpg', $file))] as $p) {
                $p = beauty_media_dir() . '/' . basename((string)$p);
                if (is_file($p)) @unlink($p);
            }
            bp_flash('ok', 'Fayl qalereyadan silindi.');
        } else {
            bp_flash('err', 'Fayl adı düzgün deyil.');
        }
        bp_redirect();
    }
}

$flash = bp_take_flash();
$demoUrl = 'demo-beauty.php?lang=az';
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sky Beauty — <?= e(sky_literal_translate('İdarəetmə Paneli')) ?></title>
<meta name="robots" content="noindex, nofollow">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='88'%3E%F0%9F%92%8E%3C/text%3E%3C/svg%3E">
<style>
  :root{
    --bg:#070d12; --card:#0e1720; --card2:#111d28; --line:rgba(255,255,255,.09);
    --txt:#eaf4f6; --mut:#93aeb6; --rose:#ff2a85; --cyan:#22d3ee; --ok:#22c55e; --err:#f87171;
  }
  *{box-sizing:border-box}
  body{margin:0;background:radial-gradient(1200px 500px at 20% -10%,rgba(255,42,133,.16),transparent 60%),var(--bg);
    color:var(--txt);font:15px/1.6 Inter,system-ui,-apple-system,'Segoe UI',sans-serif}
  a{color:inherit}
  .wrap{max-width:1000px;margin:0 auto;padding:26px 18px 60px}
  .top{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-bottom:22px}
  .logo{display:flex;align-items:center;gap:10px;font:800 20px/1.2 'Segoe UI',sans-serif}
  .logo b{color:var(--rose)}
  .pill{border:1px solid var(--line);border-radius:999px;padding:7px 13px;font-size:13px;color:var(--mut);text-decoration:none;background:rgba(255,255,255,.03)}
  .pill:hover{color:#fff;border-color:var(--rose)}
  .pill.primary{background:var(--rose);border-color:var(--rose);color:#fff;font-weight:700}
  .card{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:20px;margin-bottom:18px}
  h1{font-size:20px;margin:0 0 4px}
  h2{font-size:17px;margin:0 0 16px}
  .sub{color:var(--mut);font-size:14px}
  label{display:block;font-size:13px;font-weight:600;color:var(--mut);margin-bottom:5px}
  input[type=text],input[type=password],input[type=number],input[type=url],input[type=date],select,textarea{
    width:100%;background:rgba(255,255,255,.04);border:1px solid var(--line);border-radius:10px;
    color:var(--txt);padding:9px 11px;font:14px/1.45 inherit;outline:none}
  input:focus,select:focus,textarea:focus{border-color:var(--rose);box-shadow:0 0 0 3px rgba(255,42,133,.14)}
  .grid2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
  .grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
  .field{margin-bottom:13px}
  .tabs{display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap}
  .tab{border:1px solid var(--line);background:rgba(255,255,255,.03);color:var(--mut);
    padding:9px 16px;border-radius:10px;cursor:pointer;font:600 14px inherit}
  .tab.active{background:var(--rose);border-color:var(--rose);color:#fff}
  .pane{display:none}.pane.active{display:block}
  .themes{display:flex;flex-wrap:wrap;gap:10px}
  .theme{position:relative}
  .theme input{position:absolute;opacity:0;width:0;height:0}
  .theme span{display:flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid var(--line);
    border-radius:10px;cursor:pointer;font-size:13px;color:var(--mut)}
  .theme i{width:14px;height:14px;border-radius:50%;display:inline-block;background:var(--c)}
  .theme input:checked + span{border-color:var(--rose);color:#fff;background:rgba(255,42,133,.1)}
  .btns{display:flex;flex-wrap:wrap;gap:10px;margin-top:8px}
  button.btn{border:none;border-radius:10px;padding:11px 20px;font:700 14px inherit;cursor:pointer;
    background:linear-gradient(135deg,var(--rose),#ff007f);color:#fff}
  button.btn.ghost{background:rgba(255,255,255,.05);border:1px solid var(--line);color:var(--mut)}
  button.btn.danger{background:rgba(248,113,113,.14);border:1px solid rgba(248,113,113,.4);color:#fca5a5}
  .flash{padding:11px 14px;border-radius:10px;margin-bottom:14px;font-size:14px}
  .flash.ok{background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.4);color:#86efac}
  .flash.err{background:rgba(248,113,113,.12);border:1px solid rgba(248,113,113,.4);color:#fca5a5}
  .svc{border:1px solid var(--line);border-radius:13px;padding:15px;margin-bottom:14px;background:var(--card2)}
  .svc-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:10px;margin-bottom:12px}
  .svc-head strong{font-size:15px}
  .id{font-size:12px;color:var(--mut)}
  .langs{display:grid;grid-template-columns:1fr 1fr;gap:12px}
  .lang-box{background:rgba(0,0,0,.22);border:1px solid var(--line);border-radius:11px;padding:11px}
  .flag{font-size:12px;font-weight:800;color:var(--cyan);letter-spacing:.06em;margin-bottom:7px}
  .switch{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--mut);font-weight:600}
  .switch input{width:auto}
  .hint{font-size:12.5px;color:var(--mut);margin-top:4px}
  .logo-row{display:flex;flex-wrap:wrap;gap:18px;align-items:center}
  .logo-preview{width:220px;max-width:100%;border:1px solid var(--line);border-radius:12px;background:rgba(255,255,255,.04);padding:8px}
  .upload-box{border:1px dashed rgba(255,255,255,.16);border-radius:12px;padding:14px;background:rgba(0,0,0,.16)}
  .media-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(210px,100%),1fr));gap:14px}
  .media-item{background:rgba(0,0,0,.22);border:1px solid var(--line);border-radius:12px;overflow:hidden}
  .media-item img,.media-item video{width:100%;height:140px;object-fit:cover;display:block;background:#000}
  .media-meta{display:flex;align-items:center;justify-content:space-between;gap:8px;padding:9px 11px}
  .media-title{font-size:12px;color:var(--txt);margin-top:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:150px}
  .field .hint{display:block;font-size:11.5px;color:var(--mut);margin-top:4px}
  .tag{font-size:11px;font-weight:800;letter-spacing:.08em;color:var(--cyan);background:rgba(34,211,238,.1);border:1px solid rgba(34,211,238,.3);border-radius:6px;padding:3px 7px}
  .btn.sm{padding:6px 12px;font-size:12.5px;border-radius:8px}
  .btn.sm.ok{background:rgba(34,197,94,.16);border:1px solid rgba(34,197,94,.45);color:#86efac}
  .btn.sm.warn{background:rgba(234,179,8,.14);border:1px solid rgba(234,179,8,.4);color:#fde68a}
  .btn.sm.mut{background:rgba(255,255,255,.06);border:1px solid var(--line);color:var(--mut)}

  /* Rezervasiyalar / davamiyyət / hesabat */
  .table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
  table.bk{width:100%;border-collapse:collapse;font-size:13.5px;min-width:860px}
  table.bk th{text-align:left;font-size:12px;letter-spacing:.05em;text-transform:uppercase;color:var(--mut);
    padding:8px 10px;border-bottom:1px solid var(--line);white-space:nowrap}
  table.bk td{padding:10px;border-bottom:1px solid rgba(255,255,255,.06);vertical-align:top}
  table.bk tr:last-child td{border-bottom:none}
  table.bk tr.is-pending td{background:rgba(234,179,8,.05)}
  .bk-code{font-weight:800;color:var(--cyan);letter-spacing:.04em;white-space:nowrap}
  .bk-sub{display:block;font-size:12.5px;color:var(--mut);margin-top:2px}
  .bk-sub a{white-space:nowrap}
  .bk-actions{display:flex;flex-wrap:wrap;gap:6px}
  table.bk td:last-child{min-width:200px}
  .bk-actions form{margin:0}
  .badge{display:inline-block;padding:3px 9px;border-radius:999px;font-size:12px;font-weight:700;white-space:nowrap}
  .badge.pending{background:rgba(234,179,8,.14);border:1px solid rgba(234,179,8,.4);color:#fde68a}
  .badge.confirmed{background:rgba(34,197,94,.14);border:1px solid rgba(34,197,94,.4);color:#86efac}
  .badge.completed{background:rgba(34,211,238,.14);border:1px solid rgba(34,211,238,.4);color:#a5f3fc}
  .badge.no_show{background:rgba(248,113,113,.14);border:1px solid rgba(248,113,113,.4);color:#fca5a5}
  .badge.cancelled{background:rgba(255,255,255,.06);border:1px solid var(--line);color:var(--mut)}
  .badge-count{background:var(--rose);color:#fff;border-radius:999px;padding:1px 8px;font-size:12px;margin-left:6px}
  .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(160px,100%),1fr));gap:12px;margin-bottom:18px}
  .stat{background:var(--card2);border:1px solid var(--line);border-radius:13px;padding:14px}
  .stat b{display:block;font-size:23px;line-height:1.2;color:#fff}
  .stat span{font-size:12.5px;color:var(--mut)}
  .stat.good b{color:#86efac}
  .stat.money b{color:var(--cyan)}
  .att-list{display:flex;flex-direction:column;gap:10px}
  .att-row{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:10px;
    background:var(--card2);border:1px solid var(--line);border-radius:12px;padding:12px 14px}
  .att-name{font-weight:700}
  .att-name small{display:block;font-weight:400;font-size:12.5px;color:var(--mut)}
  .att-pill{display:inline-flex;align-items:center;gap:6px;border-radius:999px;padding:5px 12px;font-size:12.5px;font-weight:700}
  .att-pill i{width:8px;height:8px;border-radius:50%;background:currentColor}
  .att-pill.work{color:#86efac;background:rgba(34,197,94,.14);border:1px solid rgba(34,197,94,.4)}
  .att-pill.off{color:#fca5a5;background:rgba(248,113,113,.14);border:1px solid rgba(248,113,113,.4)}
  .att-actions{display:flex;gap:8px;flex-wrap:wrap}
  .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;margin-bottom:14px}
  .filter-row .field{margin-bottom:0;min-width:160px}
  .empty{padding:18px;border:1px dashed var(--line);border-radius:12px;color:var(--mut);font-size:13.5px;text-align:center}

  /* Usta inbox-u */
  .ib-pill{display:inline-flex;align-items:center;gap:6px;border-radius:999px;padding:5px 12px;font-size:12.5px;font-weight:700}
  .ib-new{color:#fde68a;background:rgba(234,179,8,.14);border:1px solid rgba(234,179,8,.4)}
  .ib-read{color:#a5b4fc;background:rgba(99,102,241,.14);border:1px solid rgba(99,102,241,.4)}
  .ib-replied{color:#86efac;background:rgba(34,197,94,.14);border:1px solid rgba(34,197,94,.4)}
  .ib-reply{display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap;margin-top:6px}
  .ib-reply input{min-width:240px;flex:1}
  .wa-box{display:flex;align-items:center;gap:14px;flex-wrap:wrap;border:1px solid var(--line);border-radius:14px;padding:16px;background:var(--card2)}
  .wa-box .wa-num{font-size:18px;font-weight:700;letter-spacing:.02em}

  /* Ustalar (profillər) */
  .staff-list{display:flex;flex-direction:column;gap:16px}
  .staff-card{background:var(--card2);border:1px solid var(--line);border-radius:14px;padding:16px}
  .staff-head{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:14px}
  .staff-photo{width:64px;height:64px;border-radius:50%;object-fit:cover;border:2px solid var(--line);flex:0 0 64px}
  .staff-ava{width:64px;height:64px;border-radius:50%;display:grid;place-items:center;font-size:26px;background:rgba(255,255,255,.05);border:1px solid var(--line);flex:0 0 64px}
  .staff-head h3{font-size:16px;margin:0}
  .staff-flags{display:flex;gap:18px;flex-wrap:wrap;margin:10px 0 4px}
  .staff-flags label{display:flex;align-items:center;gap:7px;font-size:13.5px;color:var(--txt)}
  .staff-flags input{width:auto}

  /* Stil kataloqu */
  .style-thumb{width:58px;height:58px;border-radius:12px;object-fit:cover;border:1px solid var(--line);flex:0 0 58px;background:rgba(255,255,255,.04)}
  .style-thumb--empty{display:grid;place-items:center;font-size:20px;color:var(--mut)}
  .color-checks{display:flex;flex-wrap:wrap;gap:8px;margin-top:4px}
  .color-checks label{display:inline-flex;align-items:center;gap:6px;padding:5px 10px;border:1px solid var(--line);border-radius:999px;font-size:12.5px;background:rgba(255,255,255,.03);cursor:pointer}
  .color-checks label:has(input:checked){border-color:var(--rose);background:rgba(244,114,182,.14)}
  .color-checks input{width:auto;margin:0}
  .color-checks i{width:14px;height:14px;border-radius:50%;display:block;border:1px solid rgba(255,255,255,.35)}
  .style-meta{display:flex;flex-wrap:wrap;gap:6px;margin-top:6px}
  .style-meta span{font-size:11px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;padding:3px 8px;border-radius:999px;background:rgba(255,255,255,.06);color:var(--mut)}
  .style-meta span.on{background:rgba(34,197,94,.16);color:#86efac}
  .style-meta span.off{background:rgba(248,113,113,.14);color:#fca5a5}
  .style-meta span.live{background:rgba(56,189,248,.14);color:#7dd3fc}
  .style-card-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:flex-start}

  /* Rəylər */
  .rev-admin-list{display:flex;flex-direction:column;gap:12px}
  .rev-admin{background:var(--card2);border:1px solid var(--line);border-radius:14px;padding:16px;display:flex;flex-direction:column;gap:9px}
  .rev-admin-head{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
  .rev-admin-name{font-weight:700}
  .rev-admin-meta{font-size:12.5px;color:var(--mut)}
  .rev-admin-text{font-size:14px;line-height:1.6;color:var(--txt)}
  .stars-gold{color:#fbbf24;letter-spacing:2px;font-size:14px}
  .rev-reply-form{display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap;margin:2px 0 0}
  .rev-reply-form textarea{flex:1;min-width:220px}

  @media(max-width:760px){.grid2,.grid3,.langs{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="wrap">

  <?php if (!$authed): ?>
    <div class="top">
      <div class="logo">💎 Sky <b>Beauty</b></div>
      <a class="pill" href="<?= bp_e($demoUrl) ?>">Demo saytı →</a>
    </div>
    <div class="card" style="max-width:430px;margin:40px auto">
      <h1>İdarəetmə paneli</h1>
      <p class="sub">Salon adı, qiymətlər, temalar — hamısı bir yerdə.</p>
      <?php if ($loginError !== ''): ?><div class="flash err"><?= bp_e($loginError) ?></div><?php endif; ?>
      <form method="post" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="login">
        <div class="field">
          <label for="pw">Şifrə</label>
          <input type="password" id="pw" name="password" required autofocus>
        </div>
        <button class="btn" type="submit" style="width:100%">Daxil ol</button>
      </form>
    </div>
  <?php else: ?>
    <div class="top">
      <div class="logo">💎 Sky <b>Beauty</b></div>
      <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="pill primary" href="<?= bp_e($demoUrl) ?>" target="_blank" rel="noopener">Demo saytı →</a>
        <a class="pill" href="?logout=1">Çıxış</a>
      </div>
    </div>

    <?php foreach ($flash as $f): ?>
      <div class="flash <?= $f['type'] === 'ok' ? 'ok' : 'err' ?>"><?= bp_e($f['msg']) ?></div>
    <?php endforeach; ?>

    <div class="tabs">
      <button class="tab active" data-pane="salon">Salon</button>
      <button class="tab" data-pane="bookings">Rezervasiyalar<?php if ($pendingCount > 0): ?><span class="badge-count"><?= (int)$pendingCount ?></span><?php endif; ?></button>
      <button class="tab" data-pane="messages">Mesajlar<?php if ($inboxCounts['new'] > 0): ?><span class="badge-count"><?= (int)$inboxCounts['new'] ?></span><?php endif; ?></button>
      <button class="tab" data-pane="attendance">Davamiyyət</button>
      <button class="tab" data-pane="staff">Ustalar</button>
      <button class="tab" data-pane="reviews">Rəylər<?php if (count($reviewsPending) > 0): ?><span class="badge-count"><?= count($reviewsPending) ?></span><?php endif; ?></button>
      <button class="tab" data-pane="report">Hesabat</button>
      <button class="tab" data-pane="services">Xidmətlər və qiymətlər</button>
      <button class="tab" data-pane="studio">Stil kataloqu</button>
      <button class="tab" data-pane="offers">Təkliflər</button>
      <button class="tab" data-pane="gallery">Qalereya</button>
      <button class="tab" data-pane="whatsapp" title="Yalnız qəbul / administrator / salon sahibi">WhatsApp</button>
      <button class="tab" data-pane="system">Sistem</button>
    </div>

    <!-- SALON -->
    <div class="pane active" id="pane-salon">
      <form method="post" class="card">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="save_salon">
        <h2>Salon məlumatları</h2>
        <p class="sub" style="margin-bottom:16px">Adı bir dəfə dəyişin — başlıq, header, footer, WhatsApp və kart avtomatik yenilənir.</p>

        <div class="grid2">
          <div class="field">
            <label for="bname">Salon adı</label>
            <input type="text" id="bname" name="brand[name]" value="<?= bp_e($state['brand']['name'] ?? '') ?>" required>
          </div>
          <div class="field">
            <label for="bphone">Telefon</label>
            <input type="text" id="bphone" name="brand[phone]" value="<?= bp_e($state['brand']['phone'] ?? '') ?>">
          </div>
          <div class="field">
            <label for="bwa">WhatsApp (rəqəmlərlə)</label>
            <input type="text" id="bwa" name="brand[whatsapp]" value="<?= bp_e($state['brand']['whatsapp'] ?? '') ?>" placeholder="994503936998">
          </div>
          <div class="field">
            <label for="binsta">Instagram</label>
            <input type="url" id="binsta" name="brand[instagram]" value="<?= bp_e($state['brand']['instagram'] ?? '') ?>">
          </div>
          <div class="field">
            <label for="btiktok">TikTok</label>
            <input type="url" id="btiktok" name="brand[tiktok]" value="<?= bp_e($state['brand']['tiktok'] ?? '') ?>">
          </div>
          <div class="field">
            <label for="bfb">Facebook</label>
            <input type="url" id="bfb" name="brand[facebook]" value="<?= bp_e($state['brand']['facebook'] ?? '') ?>">
          </div>
        </div>

        <?php foreach (['address' => 'Ünvan', 'hours' => 'İş saatları'] as $key => $label): ?>
          <h2 style="margin-top:10px"><?= $label ?> (4 dil)</h2>
          <div class="langs">
            <?php foreach (BEAUTY_LANGS as $l): ?>
              <div class="lang-box">
                <div class="flag"><?= BEAUTY_LANG_LABELS[$l] ?></div>
                <input type="text" name="brand[<?= $key ?>][<?= $l ?>]" value="<?= bp_e($state['brand'][$key][$l] ?? '') ?>" aria-label="<?= $label . ' ' . $l ?>">
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

        <h2 style="margin-top:22px">Rəng teması</h2>
        <div class="themes">
          <?php foreach ($CFG['themes'] as $tk => $th): ?>
            <label class="theme">
              <input type="radio" name="theme" value="<?= bp_e($tk) ?>" <?= $state['theme'] === $tk ? 'checked' : '' ?>>
              <span><i style="--c:<?= bp_e($th['primary']) ?>"></i><?= bp_e($th['label']) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
        <p class="hint">Demo səhifədəki rəng nöqtələri ilə də canlı önizləmə etmək olar.</p>

        <div class="btns"><button class="btn" type="submit">Yadda saxla</button></div>
      </form>
    </div>

    <!-- SERVICES -->
    <div class="pane" id="pane-services">
      <form method="post" class="card">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="save_services">
        <h2>Xidmətlər və qiymətlər</h2>
        <p class="sub" style="margin-bottom:16px">«Köhnə qiymət» yeni qiymətdən böyükdürsə, saytda üstündən xətt çəkilir və endirim faizi göstərilir. 0 = təklif yoxdur.</p>

        <?php foreach ($state['services'] as $id => $s): ?>
          <div class="svc">
            <div class="svc-head">
              <div>
                <strong><?= bp_e($s['title']['az'] ?? ('#' . $id)) ?></strong>
                <div class="id">ID <?= bp_e((string)$id) ?></div>
              </div>
              <label class="switch">
                <input type="checkbox" name="svc[<?= bp_e((string)$id) ?>][active]" value="1" <?= !empty($s['active']) ? 'checked' : '' ?>>
                Saytda göstər
              </label>
            </div>

            <div class="grid3" style="margin-bottom:12px">
              <div class="field">
                <label>Qiymət (AZN)</label>
                <input type="number" min="0" step="1" name="svc[<?= bp_e((string)$id) ?>][price]" value="<?= (int)$s['price'] ?>">
              </div>
              <div class="field">
                <label>Köhnə qiymət (AZN)</label>
                <input type="number" min="0" step="1" name="svc[<?= bp_e((string)$id) ?>][old_price]" value="<?= (int)$s['old_price'] ?>">
              </div>
              <div class="field">
                <label>Müddət (dəqiqə)</label>
                <input type="number" min="0" step="5" name="svc[<?= bp_e((string)$id) ?>][duration]" value="<?= (int)$s['duration'] ?>">
              </div>
            </div>

            <div class="grid2" style="margin-bottom:12px">
              <div class="field">
                <label>Kateqoriya</label>
                <select name="svc[<?= bp_e((string)$id) ?>][cat]">
                  <?php foreach (BEAUTY_CAT_LABELS as $ck => $cl): ?>
                    <option value="<?= bp_e($ck) ?>" <?= ($s['cat'] ?? 'hair') === $ck ? 'selected' : '' ?>><?= bp_e($cl) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="field">
                <label>Şəkil URL</label>
                <input type="url" name="svc[<?= bp_e((string)$id) ?>][img]" value="<?= bp_e($s['img'] ?? '') ?>" placeholder="https://...">
              </div>
            </div>

            <div class="langs">
              <?php foreach (BEAUTY_LANGS as $l): ?>
                <div class="lang-box">
                  <div class="flag"><?= BEAUTY_LANG_LABELS[$l] ?></div>
                  <input type="text" name="svc[<?= bp_e((string)$id) ?>][title][<?= $l ?>]" value="<?= bp_e($s['title'][$l] ?? '') ?>" aria-label="Ad <?= $l ?>">
                  <div style="height:8px"></div>
                  <textarea rows="2" name="svc[<?= bp_e((string)$id) ?>][desc][<?= $l ?>]" aria-label="Təsvir <?= $l ?>"><?= bp_e($s['desc'][$l] ?? '') ?></textarea>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>

        <div class="btns"><button class="btn" type="submit">Qiymətləri yadda saxla</button></div>
      </form>

      <form method="post" class="card" style="margin-top:18px">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="add_service">
        <h2>Yeni xidmət əlavə et</h2>
        <p class="sub" style="margin-bottom:16px">Ad və qiymət kifayətdir. Qalan sahələri sonradan da dəyişə bilərsiniz. Yeni xidmət saytdakı filtrə də dərhal qoşulur.</p>
        <div class="grid2">
          <div class="field">
            <label for="nsCat">Kateqoriya</label>
            <select id="nsCat" name="new[cat]">
              <?php foreach (BEAUTY_CAT_LABELS as $ck => $cl): ?>
                <option value="<?= bp_e($ck) ?>"><?= bp_e($cl) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label for="nsPrice">Qiymət (AZN)</label>
            <input type="number" id="nsPrice" name="new[price]" min="0" step="1" value="0">
          </div>
          <div class="field">
            <label for="nsOld">Köhnə qiymət (AZN)</label>
            <input type="number" id="nsOld" name="new[old_price]" min="0" step="1" value="0">
          </div>
          <div class="field">
            <label for="nsDur">Müddət (dəqiqə)</label>
            <input type="number" id="nsDur" name="new[duration]" min="0" step="5" value="30">
          </div>
          <div class="field" style="grid-column:1/-1">
            <label for="nsImg">Şəkil URL (isteğe bağlı)</label>
            <input type="url" id="nsImg" name="new[img]" placeholder="https://...">
          </div>
        </div>
        <div class="langs">
          <?php foreach (BEAUTY_LANGS as $l): ?>
            <div class="lang-box">
              <div class="flag"><?= BEAUTY_LANG_LABELS[$l] ?></div>
              <input type="text" name="new[title][<?= $l ?>]" value="" aria-label="Yeni xidmətin adı <?= $l ?>" placeholder="Ad <?= $l ?>" <?= $l === 'az' ? 'required' : '' ?>>
              <div style="height:8px"></div>
              <textarea rows="2" name="new[desc][<?= $l ?>]" aria-label="Təsvir <?= $l ?>" placeholder="Qısa təsvir"></textarea>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="btns"><button class="btn" type="submit">Xidməti əlavə et</button></div>
      </form>
    </div>

    <!-- OFFERS -->
    <div class="pane" id="pane-offers">
      <form method="post" class="card">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="save_offer">
        <h2>Günün / həftənin təklifi</h2>
        <p class="sub" style="margin-bottom:16px">Bu blok demo saytın hero hissəsindəki «SPA &amp; SALON» kartında reklam kimi görünür. Təklifi söndürsəniz, kart əvvəlki standart görünüşünə qayıdır.</p>

        <label class="switch" style="margin-bottom:14px">
          <input type="checkbox" name="offer[active]" value="1" <?= !empty($state['offer']['active']) ? 'checked' : '' ?>>
          Saytda göstər (aktiv)
        </label>

        <div class="grid2">
          <div class="field">
            <label for="ofsvc">Xidmət</label>
            <select id="ofsvc" name="offer[service_id]">
              <?php foreach ($state['services'] as $id => $s): ?>
                <option value="<?= bp_e((string)$id) ?>" <?= (int)$state['offer']['service_id'] === (int)$id ? 'selected' : '' ?>>
                  <?= bp_e($s['title']['az'] ?? ('#' . $id)) ?> — <?= (int)$s['price'] ?> AZN<?= empty($s['active']) ? ' (gizli)' : '' ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label for="ofprice">Təklif qiyməti (AZN)</label>
            <input type="number" id="ofprice" name="offer[price]" min="0" step="1" value="<?= (int)$state['offer']['price'] ?>">
          </div>
          <div class="field">
            <label for="ofperiod">Dövr</label>
            <select id="ofperiod" name="offer[period]">
              <option value="daily" <?= $state['offer']['period'] === 'daily' ? 'selected' : '' ?>>Günlük təklif</option>
              <option value="weekly" <?= $state['offer']['period'] === 'weekly' ? 'selected' : '' ?>>Həftəlik təklif</option>
            </select>
          </div>
          <div class="field">
            <label for="ofaud">Kimə aiddir</label>
            <select id="ofaud" name="offer[audience]">
              <option value="all" <?= $state['offer']['audience'] === 'all' ? 'selected' : '' ?>>Bütün müştərilər</option>
              <option value="corporate" <?= $state['offer']['audience'] === 'corporate' ? 'selected' : '' ?>>Yalnız kompaniya əməkdaşları</option>
            </select>
          </div>
        </div>

        <p class="hint" style="margin-top:10px">Qiymət 0 olsa, xidmətin adi qiyməti göstərilir. Təklif qiyməti xidmətin qiymətindən kiçik olmalıdır.</p>

        <h2 style="margin-top:22px">Reklam mətni (istəyə bağlı, 4 dil)</h2>
        <div class="langs">
          <?php foreach (BEAUTY_LANGS as $l): ?>
            <div class="lang-box">
              <div class="flag"><?= BEAUTY_LANG_LABELS[$l] ?></div>
              <input type="text" maxlength="140" name="offer[note][<?= $l ?>]" value="<?= bp_e($state['offer']['note'][$l] ?? '') ?>" placeholder="Məs: Kompaniyanız üçün 4 nəfərlik paket" aria-label="Təklif mətni <?= $l ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <div class="btns"><button class="btn" type="submit">Təklifi yadda saxla</button></div>
      </form>

      <?php
        $oSvc   = $state['services'][(string)$state['offer']['service_id']] ?? null;
        $oBase  = $oSvc ? (int)$oSvc['price'] : 0;
        $oPrice = (int)$state['offer']['price'];
        if ($oPrice <= 0 || $oPrice >= $oBase) $oPrice = $oBase;
        $oOff   = $oBase > 0 && $oPrice < $oBase ? (int)round((1 - $oPrice / $oBase) * 100) : 0;
      ?>
      <div class="card">
        <h2>Saytda necə görünəcək</h2>
        <?php if (!empty($state['offer']['active']) && $oSvc && !empty($oSvc['active'])): ?>
          <p class="sub" style="margin-bottom:10px">
            <b style="color:var(--rose)"><?= $state['offer']['period'] === 'weekly' ? 'HƏFTƏNİN TƏKLİFİ' : 'GÜNÜN TƏKLİFİ' ?></b>
            · <?= $state['offer']['audience'] === 'corporate' ? 'Kompaniya əməkdaşları üçün' : 'Bütün müştərilər' ?>
          </p>
          <div style="display:flex;flex-wrap:wrap;align-items:baseline;gap:12px">
            <strong style="font-size:19px"><?= bp_e($oSvc['title']['az'] ?? '') ?></strong>
            <span style="color:var(--rose);font-weight:800;font-size:22px"><?= (int)$oPrice ?> AZN</span>
            <?php if ($oOff > 0): ?>
              <span style="color:var(--mut);text-decoration:line-through"><?= $oBase ?> AZN</span>
              <span class="pill primary" style="padding:2px 9px;font-size:12px">−<?= $oOff ?>%</span>
            <?php endif; ?>
          </div>
        <?php elseif (!empty($state['offer']['active'])): ?>
          <div class="empty">Seçilmiş xidmət saytda gizlidir — təklif görünmür. «Xidmətlər» tabından onu aktiv edin.</div>
        <?php else: ?>
          <div class="empty">Təklif söndürülüb — hero kartı standart görünüşdədir.</div>
        <?php endif; ?>
      </div>
    </div>

    <!-- GALLERY -->
    <div class="pane" id="pane-gallery">
      <div class="card">
        <h2>Loqo (watermark)</h2>
        <p class="sub" style="margin-bottom:14px">Yüklədiyiniz loqo bütün yeni şəkil və videolara avtomatik vurulur. PNG (şəffaf) tövsiyə olunur.</p>
        <div class="logo-row">
          <img src="<?= bp_e($mediaBase . basename(beauty_logo_path())) ?>?v=<?= (int)@filemtime(beauty_logo_path()) ?>" alt="Loqo" class="logo-preview">
          <form method="post" enctype="multipart/form-data" style="flex:1;min-width:240px">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="save_logo">
            <div class="field">
              <label for="logo">Yeni loqo (PNG/JPG/WEBP, max 3 MB)</label>
              <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/webp" required>
            </div>
            <button class="btn" type="submit">Loqonu yüklə</button>
          </form>
        </div>
      </div>

      <div class="card">
        <h2>Qalereya — foto və video</h2>
        <p class="sub" style="margin-bottom:14px">
          Şəkil: JPG / PNG / WEBP, max <b><?= (int)$mediaLimits['photo_mb'] ?> MB</b>.
          Video: MP4, max <b><?= (int)$mediaLimits['video_mb'] ?> MB</b> və <b><?= (int)$mediaLimits['video_sec'] ?> saniyə</b>.
          Hər fayla loqo watermark-ı vurulur; videodan önizləmə kadrı avtomatik alınır.
        </p>
        <div class="grid2">
          <form method="post" enctype="multipart/form-data" class="upload-box" data-media-form="photo">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="upload_media">
            <input type="hidden" name="media_type" value="photo">
            <div class="field">
              <label for="ph">Şəkil seç</label>
              <input type="file" id="ph" name="media" accept="image/jpeg,image/png,image/webp" required>
            </div>
            <div class="field">
              <label for="ph-title">İşin adı <span style="font-weight:400">(isteğe bağlı)</span></label>
              <input type="text" id="ph-title" name="media_title" maxlength="80" placeholder="Məs: Klassik kəsim və boyama">
            </div>
            <button class="btn" type="submit">Şəkli əlavə et</button>
          </form>
          <form method="post" enctype="multipart/form-data" class="upload-box" data-media-form="video">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="upload_media">
            <input type="hidden" name="media_type" value="video">
            <div class="field">
              <label for="vd">Video seç <span style="font-weight:400">(MP4, max <?= (int)$mediaLimits['video_sec'] ?> s)</span></label>
              <input type="file" id="vd" name="media" accept="video/mp4" required>
            </div>
            <div class="field">
              <label for="vd-title">Çəkilişin adı <span style="font-weight:400">(isteğe bağlı)</span></label>
              <input type="text" id="vd-title" name="media_title" maxlength="80" placeholder="Məs: Model çəkilişi — payız kolleksiyası">
            </div>
            <button class="btn" type="submit">Videonu əlavə et</button>
          </form>
        </div>
      </div>

      <div class="card">
        <h2>Yüklənmiş işlər (<?= count($gallery['items']) ?>)</h2>
        <?php if (!$gallery['items']): ?>
          <p class="sub">Hələ media yoxdur. Yuxarıdan şəkil və ya video yükləyin — saytda «Ustaların əl işləri» bölməsində görünəcək.</p>
        <?php else: ?>
          <div class="media-grid">
            <?php foreach (array_reverse($gallery['items']) as $it): ?>
              <?php
                $file = basename((string)($it['file'] ?? ''));
                $poster = basename((string)($it['poster'] ?? ''));
                $isVideo = ($it['type'] ?? '') === 'video';
                $seconds = isset($it['duration']) ? (float)$it['duration'] : null;
                $label = trim((string)($it['title'] ?? ''));
              ?>
              <div class="media-item">
                <?php if ($isVideo): ?>
                  <?php if ($poster !== '' && is_file(beauty_media_dir() . '/' . $poster)): ?>
                    <img src="<?= bp_e($mediaBase . $poster) ?>" alt="<?= bp_e($label) ?>" loading="lazy">
                  <?php else: ?>
                    <video src="<?= bp_e($mediaBase . $file) ?>" preload="metadata" playsinline></video>
                  <?php endif; ?>
                <?php else: ?>
                  <img src="<?= bp_e($mediaBase . $file) ?>" alt="<?= bp_e($label) ?>" loading="lazy">
                <?php endif; ?>
                <div class="media-meta">
                  <div style="min-width:0">
                    <span class="tag"><?= $isVideo ? 'VIDEO' : 'FOTO' ?><?= $seconds !== null ? ' · ' . gmdate('i:s', (int)round($seconds)) : '' ?></span>
                    <?php if ($label !== ''): ?><div class="media-title" title="<?= bp_e($label) ?>"><?= bp_e($label) ?></div><?php endif; ?>
                  </div>
                  <form method="post" onsubmit="return confirm('Silinsin?');" style="margin:0">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="delete_media">
                    <input type="hidden" name="file" value="<?= bp_e($file) ?>">
                    <button class="btn danger sm" type="submit">Sil</button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- BOOKINGS -->
    <div class="pane" id="pane-bookings">
      <div class="card">
        <h2>Beh və kart nömrəsi</h2>
        <p class="sub" style="margin-bottom:14px">Müştəri bron edəndə beh məbləği və bu kart nömrəsi göstərilir. Ödənişi yoxladıqdan sonra bronu əl ilə təsdiqləyin.</p>
        <form method="post">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="action" value="save_booking_settings">
          <input type="hidden" name="bdate" value="<?= bp_e($bDate) ?>">
          <input type="hidden" name="bstatus" value="<?= bp_e($bStatus) ?>">
          <div class="grid2">
            <div class="field">
              <label for="bkcard">Kart nömrəsi</label>
              <input type="text" id="bkcard" name="booking[card_number]" value="<?= bp_e($state['booking']['card_number'] ?? '') ?>" placeholder="4169 7388 0000 0000">
            </div>
            <div class="field">
              <label for="bkholder">Kart sahibi</label>
              <input type="text" id="bkholder" name="booking[card_holder]" value="<?= bp_e($state['booking']['card_holder'] ?? '') ?>" placeholder="Sky Beauty MMC">
            </div>
            <div class="field">
              <label for="bkpct">Beh faizi (%)</label>
              <input type="number" id="bkpct" name="booking[deposit_percent]" min="1" max="100" step="1" value="<?= (int)($state['booking']['deposit_percent'] ?? 20) ?>">
            </div>
            <div class="field">
              <label for="bkmin">Minimum beh (AZN)</label>
              <input type="number" id="bkmin" name="booking[deposit_min]" min="0" max="1000" step="1" value="<?= (int)($state['booking']['deposit_min'] ?? 10) ?>">
            </div>
          </div>
          <p class="hint">Beh = xidmət qiymətinin <?= (int)($state['booking']['deposit_percent'] ?? 20) ?>%-i, amma ən azı <?= (int)($state['booking']['deposit_min'] ?? 10) ?> AZN (məs. 19 AZN xidmət → <?= bb_deposit(19, $state['booking']) ?> AZN beh).</p>
          <div class="btns"><button class="btn" type="submit">Yadda saxla</button></div>
        </form>
      </div>

      <div class="card">
        <h2>Rezervasiyalar <?php if ($pendingCount > 0): ?><span class="badge-count"><?= (int)$pendingCount ?> gözləyir</span><?php endif; ?></h2>
        <form method="get" class="filter-row">
          <div class="field">
            <label for="fbdate">Tarix</label>
            <input type="date" id="fbdate" name="bdate" value="<?= bp_e($bDate) ?>">
          </div>
          <div class="field">
            <label for="fbstatus">Status</label>
            <select id="fbstatus" name="bstatus">
              <option value="">Bütün statuslar</option>
              <?php foreach (BB_STATUSES as $stOpt): ?>
                <option value="<?= bp_e($stOpt) ?>" <?= $bStatus === $stOpt ? 'selected' : '' ?>><?= bp_e(bp_status_label($stOpt)) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="btns" style="margin:0">
            <button class="btn sm" type="submit">Filtrələ</button>
            <a class="btn sm mut" href="beauty-panel.php?bdate=&amp;bstatus=" style="text-decoration:none">Sıfırla</a>
          </div>
        </form>

        <?php if (!$viewBookings): ?>
          <div class="empty">Bu filtr üzrə bron yoxdur. Müştəri saytdan onlayn növbə götürəndə burada görünəcək.</div>
        <?php else: ?>
          <div class="table-wrap">
            <table class="bk">
              <thead>
                <tr>
                  <th>Kod</th><th>Tarix / saat</th><th>Müştəri</th><th>Xidmət</th><th>Usta</th><th>Məbləğ</th><th>Status</th><th>Əməliyyat</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($viewBookings as $b): ?>
                  <?php
                    $bStatusVal = (string)($b['status'] ?? 'pending');
                    $bPhone = (string)($b['phone'] ?? '');
                    $bCode  = (string)($b['code'] ?? '');
                    $ret    = ['bdate' => $bDate, 'bstatus' => $bStatus];
                  ?>
                  <tr class="<?= $bStatusVal === 'pending' ? 'is-pending' : '' ?>">
                    <td><span class="bk-code"><?= bp_e($bCode) ?></span></td>
                    <td><?= bp_e((string)($b['date'] ?? '')) ?><span class="bk-sub"><?= bp_e((string)($b['time'] ?? '')) ?></span></td>
                    <td>
                      <?= bp_e((string)($b['customer'] ?? '')) ?>
                      <span class="bk-sub"><a href="tel:<?= bp_e('+' . preg_replace('/\D+/', '', $bPhone)) ?>"><?= bp_e(bb_format_phone($bPhone)) ?></a></span>
                      <?php if (!empty($b['visit_no'])): ?><span class="bk-sub"><?= (int)$b['visit_no'] ?>-ci ziyarət</span><?php endif; ?>
                    </td>
                    <td><?= bp_e((string)($b['service'] ?? '')) ?></td>
                    <td><?= bp_e((string)($b['stylist'] ?? '')) ?></td>
                    <td>
                      <?= bp_e(number_format((int)($b['price'] ?? 0), 0, '', ' ') . ' AZN') ?>
                      <span class="bk-sub">Beh: <?= bp_e(number_format((int)($b['deposit'] ?? 0), 0, '', ' ') . ' AZN') ?></span>
                    </td>
                    <td><span class="badge <?= bp_e($bStatusVal) ?>"><?= bp_e(bp_status_label($bStatusVal)) ?></span></td>
                    <td>
                      <div class="bk-actions">
                        <?php if (in_array($bStatusVal, ['pending', 'cancelled', 'no_show'], true)): ?>
                          <form method="post" onsubmit="return confirm('<?= $bStatusVal === 'pending' ? 'Ödəniş yoxlanıldı və bron təsdiqlənir?' : 'Bron yenidən gözləmə statusuna qaytarılsın?' ?>');">
                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="booking_status">
                            <input type="hidden" name="code" value="<?= bp_e($bCode) ?>">
                            <input type="hidden" name="status" value="confirmed">
                            <?php foreach ($ret as $k => $v): ?><input type="hidden" name="<?= bp_e($k) ?>" value="<?= bp_e($v) ?>"><?php endforeach; ?>
                            <button class="btn sm ok" type="submit">Təsdiqlə</button>
                          </form>
                        <?php endif; ?>
                        <?php if (in_array($bStatusVal, ['pending', 'confirmed'], true)): ?>
                          <form method="post">
                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="booking_status">
                            <input type="hidden" name="code" value="<?= bp_e($bCode) ?>">
                            <input type="hidden" name="status" value="completed">
                            <?php foreach ($ret as $k => $v): ?><input type="hidden" name="<?= bp_e($k) ?>" value="<?= bp_e($v) ?>"><?php endforeach; ?>
                            <button class="btn sm mut" type="submit">Tamamla</button>
                          </form>
                          <form method="post">
                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="booking_status">
                            <input type="hidden" name="code" value="<?= bp_e($bCode) ?>">
                            <input type="hidden" name="status" value="no_show">
                            <?php foreach ($ret as $k => $v): ?><input type="hidden" name="<?= bp_e($k) ?>" value="<?= bp_e($v) ?>"><?php endforeach; ?>
                            <button class="btn sm warn" type="submit">Gəlmədi</button>
                          </form>
                        <?php endif; ?>
                        <?php if (in_array($bStatusVal, ['pending', 'confirmed'], true)): ?>
                          <form method="post" onsubmit="return confirm('Bron ləğv edilsin?');">
                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="booking_status">
                            <input type="hidden" name="code" value="<?= bp_e($bCode) ?>">
                            <input type="hidden" name="status" value="cancelled">
                            <?php foreach ($ret as $k => $v): ?><input type="hidden" name="<?= bp_e($k) ?>" value="<?= bp_e($v) ?>"><?php endforeach; ?>
                            <button class="btn sm danger" type="submit">Ləğv et</button>
                          </form>
                        <?php endif; ?>
                        <?php if (in_array($bStatusVal, ['completed', 'cancelled', 'no_show'], true)): ?>
                          <form method="post">
                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="booking_status">
                            <input type="hidden" name="code" value="<?= bp_e($bCode) ?>">
                            <input type="hidden" name="status" value="pending">
                            <?php foreach ($ret as $k => $v): ?><input type="hidden" name="<?= bp_e($k) ?>" value="<?= bp_e($v) ?>"><?php endforeach; ?>
                            <button class="btn sm mut" type="submit">Geri qaytar</button>
                          </form>
                        <?php endif; ?>
                        <form method="post" onsubmit="return confirm('Bron tamamilə silinsin?');">
                          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                          <input type="hidden" name="action" value="delete_booking">
                          <input type="hidden" name="code" value="<?= bp_e($bCode) ?>">
                          <?php foreach ($ret as $k => $v): ?><input type="hidden" name="<?= bp_e($k) ?>" value="<?= bp_e($v) ?>"><?php endforeach; ?>
                          <button class="btn sm danger" type="submit">Sil</button>
                        </form>
                        <?php if ($bStatusVal === 'completed'): ?>
                          <?php if (isset($reviewByCode[$bCode])): ?>
                            <?php $rvStatus = (string)($reviewByCode[$bCode]['status'] ?? 'pending'); ?>
                            <a class="btn sm mut" href="#" data-goto-tab="reviews">Rəy: <?= bp_e(['pending' => 'gözləyir', 'approved' => 'dərcdə', 'hidden' => 'gizli'][$rvStatus] ?? $rvStatus) ?></a>
                          <?php else: ?>
                            <?php
                              $waPhone = bb_normalize_phone($bPhone);
                              $invite = 'Salam, ' . (string)($b['customer'] ?? '') . '! '
                                  . (string)($state['brand']['name'] ?? 'Sky Beauty')
                                  . ' ziyarətiniz üçün təşəkkür edirik. Rəyinizi bu linkdən yaza bilərsiniz: '
                                  . $demoAbs . '?lang=az&review=' . $bCode . '#reviews';
                            ?>
                            <?php if ($waPhone !== ''): ?>
                              <a class="btn sm ok" target="_blank" rel="noopener" href="https://wa.me/<?= bp_e($waPhone) ?>?text=<?= bp_e(rawurlencode($invite)) ?>">Rəy dəvəti</a>
                            <?php endif; ?>
                          <?php endif; ?>
                        <?php endif; ?>
                      </div>
                      <?php if (!empty($b['note'])): ?><span class="bk-sub">Qeyd: <?= bp_e((string)$b['note']) ?></span><?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <div class="card">
        <h2>Müştəri bazası (<?= count($customers) ?>)</h2>
        <p class="sub" style="margin-bottom:14px">Hər onlayn bron müştəri kimi avtomatik qeydə alınır — telefon nömrəsi açarıdır, təkrar ziyarətlər bir sətirdə toplanır.</p>
        <?php if (!$customersTop): ?>
          <div class="empty">Hələ müştəri yoxdur.</div>
        <?php else: ?>
          <div class="table-wrap">
            <table class="bk">
              <thead><tr><th>Müştəri</th><th>Telefon</th><th>Ziyarətlər</th><th>Xərc</th><th>Son bron</th></tr></thead>
              <tbody>
                <?php foreach ($customersTop as $c): ?>
                  <tr>
                    <td><?= bp_e((string)($c['name'] ?? '')) ?></td>
                    <td><a href="tel:<?= bp_e('+' . preg_replace('/\D+/', '', (string)($c['phone'] ?? ''))) ?>"><?= bp_e(bb_format_phone((string)($c['phone'] ?? ''))) ?></a></td>
                    <td><?= (int)($c['visits'] ?? 0) ?></td>
                    <td><?= bp_e(number_format((int)($c['spent'] ?? 0), 0, '', ' ') . ' AZN') ?></td>
                    <td><?= bp_e((string)($c['last'] ?? '—')) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- ATTENDANCE -->
    <div class="pane" id="pane-attendance">
      <div class="card">
        <h2>Davamiyyət</h2>
        <p class="sub" style="margin-bottom:14px">«İşdə deyil» edilən usta həmin gün onlayn bron qəbul etmir. Saytda usta kartında yaşıl/qırmızı nişan görünür.</p>
        <form method="get" class="filter-row">
          <div class="field">
            <label for="fadate">Gün</label>
            <input type="date" id="fadate" name="adate" value="<?= bp_e($adate) ?>">
          </div>
          <div class="btns" style="margin:0"><button class="btn sm" type="submit">Göstər</button></div>
        </form>

        <div class="stats">
          <div class="stat good"><b><?= (int)$workingCount ?></b><span>İşdədir</span></div>
          <div class="stat"><b><?= count($CFG['stylists'] ?? []) - $workingCount ?></b><span>İşdə deyil</span></div>
          <div class="stat"><b><?= bp_e($adate) ?></b><span>Seçilmiş gün</span></div>
        </div>

        <div class="att-list">
          <?php foreach (($CFG['stylists'] ?? []) as $st): ?>
            <?php
              $sName  = (string)$st['name'];
              $sState = bb_attendance_state($attStore, $adate, $sName);
              $sRole  = $st['role']['az'] ?? '';
            ?>
            <div class="att-row">
              <div class="att-name"><?= bp_e($sName) ?><small><?= bp_e((string)$sRole) ?></small></div>
              <div class="att-actions">
                <span class="att-pill <?= $sState === 'off' ? 'off' : 'work' ?>"><i></i><?= $sState === 'off' ? 'İşdə deyil' : 'İşdədir' ?></span>
                <form method="post">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="action" value="set_attendance">
                  <input type="hidden" name="adate" value="<?= bp_e($adate) ?>">
                  <input type="hidden" name="stylist" value="<?= bp_e($sName) ?>">
                  <input type="hidden" name="state" value="work">
                  <button class="btn sm ok" type="submit">İşdədir</button>
                </form>
                <form method="post">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="action" value="set_attendance">
                  <input type="hidden" name="adate" value="<?= bp_e($adate) ?>">
                  <input type="hidden" name="stylist" value="<?= bp_e($sName) ?>">
                  <input type="hidden" name="state" value="off">
                  <button class="btn sm danger" type="submit">İşdə deyil</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- STAFF PROFILES -->
    <div class="pane" id="pane-staff">
      <div class="card">
        <h2>Ustalar və profillər</h2>
        <p class="sub" style="margin-bottom:6px">Ad, vəzifə, təcrübə, bio, foto və «sahibi/sahibəsi» nişanı. Dəyişikliklər dərhal demo saytda görünür.</p>
        <p class="sub">«Saytda göstər» işarəsi götürülən usta saytdan və onlayn bron seçimindən çıxarılır.</p>
      </div>

      <div class="staff-list">
        <?php foreach ($staffAll as $i => $st): ?>
          <?php $sName = (string)$st['name']; ?>
          <form method="post" enctype="multipart/form-data" class="staff-card">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="save_staff_profile">
            <input type="hidden" name="name" value="<?= bp_e($sName) ?>">

            <div class="staff-head">
              <?php if (!empty($st['img'])): ?>
                <img class="staff-photo" src="<?= bp_e($st['img']) ?>" alt="<?= bp_e($sName) ?>">
              <?php else: ?>
                <div class="staff-ava"><?= bp_e($st['avatar'] ?: '💁‍♀️') ?></div>
              <?php endif; ?>
              <div style="flex:1;min-width:170px">
                <h3><?= bp_e($sName) ?></h3>
                <div class="rev-admin-meta">
                  <?= $st['owner'] ? '👑 Sahibə · ' : '' ?>
                  <?= $st['active'] ? 'Saytda görünür' : 'Saytda gizlidir' ?>
                </div>
              </div>
              <button class="btn" type="submit">Yadda saxla</button>
            </div>

            <div class="grid2">
              <div class="field">
                <label for="sexp<?= $i ?>">Təcrübə (məs. 10+)</label>
                <input type="text" id="sexp<?= $i ?>" name="exp" maxlength="10" value="<?= bp_e($st['exp']) ?>">
              </div>
              <div class="field">
                <label for="sbadge<?= $i ?>">Nişan (məs. TOP MASTER)</label>
                <input type="text" id="sbadge<?= $i ?>" name="badge" maxlength="24" value="<?= bp_e($st['badge']) ?>">
              </div>
            </div>

            <div class="staff-flags">
              <label><input type="checkbox" name="active" value="1" <?= $st['active'] ? 'checked' : '' ?>> Saytda göstər (bron seçimində də)</label>
              <label><input type="checkbox" name="owner" value="1" <?= $st['owner'] ? 'checked' : '' ?>> 👑 Sahibi / sahibəsi</label>
            </div>

            <div class="grid2">
              <div class="field">
                <label for="sphoto<?= $i ?>">Foto (JPG/PNG/WEBP, maks. 3 MB)</label>
                <input type="file" id="sphoto<?= $i ?>" name="photo" accept="image/jpeg,image/png,image/webp">
                <?php if (!empty($st['img'])): ?>
                  <label style="display:flex;align-items:center;gap:7px;margin-top:8px;font-size:13px">
                    <input type="checkbox" name="remove_photo" value="1" style="width:auto"> Mövcud fotonu sil
                  </label>
                <?php endif; ?>
              </div>
              <div class="field">
                <label>Status</label>
                <p class="hint" style="margin:0">
                  Ustanın adı bron və davamiyyət tarixçəsinə bağlıdır — dəyişdirilmir.
                </p>
              </div>
            </div>

            <h2 style="margin-top:16px">Vəzifə (4 dil)</h2>
            <div class="langs">
              <?php foreach (BEAUTY_LANGS as $l): ?>
                <div class="lang-box">
                  <div class="flag"><?= BEAUTY_LANG_LABELS[$l] ?></div>
                  <input type="text" name="role[<?= $l ?>]" maxlength="80" value="<?= bp_e($st['role'][$l] ?? '') ?>" aria-label="Vəzifə <?= $l ?>">
                </div>
              <?php endforeach; ?>
            </div>

            <h2 style="margin-top:16px">Bio (4 dil)</h2>
            <div class="langs">
              <?php foreach (BEAUTY_LANGS as $l): ?>
                <div class="lang-box">
                  <div class="flag"><?= BEAUTY_LANG_LABELS[$l] ?></div>
                  <textarea name="bio[<?= $l ?>]" rows="3" maxlength="400" aria-label="Bio <?= $l ?>"><?= bp_e($st['bio'][$l] ?? '') ?></textarea>
                </div>
              <?php endforeach; ?>
            </div>
          </form>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- REVIEWS -->
    <div class="pane" id="pane-reviews">
      <div class="card">
        <h2>Rəylər və reytinq</h2>
        <p class="sub">Rəy yalnız «tamamlandı» bronun kodu ilə yazılır. Yeni rəy əvvəlcə burada görünür — təsdiqlədikdən sonra saytda yayımlanır.</p>
        <div class="stats" style="margin-top:14px;margin-bottom:0">
          <div class="stat good"><b><?= $rSummary['count'] > 0 ? number_format((float)$rSummary['avg'], 1, '.', '') : '—' ?></b><span>Orta reytinq</span></div>
          <div class="stat"><b><?= count($reviewsPublic) ?></b><span>Təsdiqlənmiş</span></div>
          <div class="stat"><b><?= count($reviewsPending) ?></b><span>Təsdiq gözləyən</span></div>
          <div class="stat"><b><?= count($reviewsHidden) ?></b><span>Gizli</span></div>
          <div class="stat"><b><?= count($pendingComments) ?></b><span>Gözləyən fikir</span></div>
        </div>
      </div>

      <?php
      $renderReview = function (array $rv): void {
          $id     = (string)($rv['id'] ?? '');
          $rating = max(0, min(5, (int)($rv['rating'] ?? 0)));
          $stars  = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
          $status = (string)($rv['status'] ?? 'pending');
          $statusLabels = ['pending' => 'Gözləyir', 'approved' => 'Dərc edildi', 'hidden' => 'Gizli'];
          $date   = (string)($rv['date'] ?? '');
          ?>
          <div class="rev-admin">
            <div class="rev-admin-head">
              <div>
                <div class="rev-admin-name">
                  <?= bp_e((string)($rv['name'] ?? '')) ?>
                  <span class="rev-admin-meta">· <?= bp_e((string)($rv['code'] ?? '')) ?></span>
                  <span class="badge <?= $status === 'approved' ? 'confirmed' : ($status === 'hidden' ? 'cancelled' : 'pending') ?>"><?= bp_e($statusLabels[$status] ?? $status) ?></span>
                </div>
                <div class="rev-admin-meta">
                  <?= bp_e((string)($rv['service'] ?? '')) ?> · <?= bp_e((string)($rv['stylist'] ?? '')) ?>
                  <?php if ($date !== ''): ?> · <?= bp_e(date('d.m.Y', strtotime($date))) ?><?php endif; ?>
                </div>
              </div>
              <div class="stars-gold" aria-label="<?= $rating ?>/5"><?= $stars ?></div>
            </div>

            <p class="rev-admin-text"><?= nl2br(bp_e((string)($rv['text'] ?? ''))) ?></p>

            <?php if (!empty($rv['reply'])): ?>
              <div class="rev-reply"><b>Salon cavabı</b><?= nl2br(bp_e((string)$rv['reply'])) ?></div>
            <?php endif; ?>
            <?php foreach (br_public_comments($rv) as $cm): ?>
              <div class="rev-reply"><b>Ziyarətçi fikri · <?= bp_e((string)$cm['id']) ?></b><?= nl2br(bp_e((string)$cm['text'])) ?></div>
            <?php endforeach; ?>

            <div class="bk-actions">
              <?php if ($status !== 'approved'): ?>
                <form method="post">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="action" value="review_status">
                  <input type="hidden" name="id" value="<?= bp_e($id) ?>">
                  <input type="hidden" name="status" value="approved">
                  <button class="btn sm ok" type="submit">Təsdiqlə və dərc et</button>
                </form>
              <?php endif; ?>
              <?php if ($status !== 'hidden'): ?>
                <form method="post">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="action" value="review_status">
                  <input type="hidden" name="id" value="<?= bp_e($id) ?>">
                  <input type="hidden" name="status" value="hidden">
                  <button class="btn sm warn" type="submit">Gizlət</button>
                </form>
              <?php endif; ?>
              <?php if ($status === 'approved'): ?>
                <form method="post">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="action" value="review_status">
                  <input type="hidden" name="id" value="<?= bp_e($id) ?>">
                  <input type="hidden" name="status" value="pending">
                  <button class="btn sm mut" type="submit">Gözləməyə qaytar</button>
                </form>
              <?php endif; ?>
              <form method="post" onsubmit="return confirm('Rəy tamamilə silinsin?');">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="delete_review">
                <input type="hidden" name="id" value="<?= bp_e($id) ?>">
                <button class="btn sm danger" type="submit">Sil</button>
              </form>
            </div>

            <form method="post" class="rev-reply-form">
              <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="action" value="review_reply">
              <input type="hidden" name="id" value="<?= bp_e($id) ?>">
              <textarea name="reply" rows="2" maxlength="400" placeholder="Salon cavabı (istəyə bağlı)"><?= bp_e((string)($rv['reply'] ?? '')) ?></textarea>
              <button class="btn sm mut" type="submit">Cavabı saxla</button>
            </form>
          </div>
          <?php
      };
      ?>

      <div class="card">
        <h2>Təsdiq gözləyən (<?= count($reviewsPending) ?>)</h2>
        <?php if (!$reviewsPending): ?>
          <div class="empty">Təsdiq gözləyən rəy yoxdur. Müştəri rəy yazanda burada görünəcək.</div>
        <?php else: ?>
          <div class="rev-admin-list"><?php foreach ($reviewsPending as $rv) $renderReview($rv); ?></div>
        <?php endif; ?>
      </div>

      <div class="card">
        <h2>Rəylərə gözləyən fikirlər (<?= count($pendingComments) ?>)</h2>
        <?php if (!$pendingComments): ?>
          <div class="empty">Gözləyən fikir yoxdur. Ziyarətçi rəyə fikir yazanda burada görünəcək.</div>
        <?php else: ?>
          <div class="rev-admin-list">
            <?php foreach ($pendingComments as $cm): ?>
              <div class="rev-admin">
                <div class="rev-admin-head">
                  <div class="rev-admin-name">
                    <?= bp_e($cm['review_name']) ?>
                    <span class="rev-admin-meta">· <?= bp_e($cm['review_id']) ?> / <?= bp_e($cm['id']) ?></span>
                  </div>
                  <span class="badge pending">Gözləyir</span>
                </div>
                <p class="rev-admin-text"><?= nl2br(bp_e($cm['text'])) ?></p>
                <div class="bk-actions">
                  <form method="post">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="comment_status">
                    <input type="hidden" name="rid" value="<?= bp_e($cm['review_id']) ?>">
                    <input type="hidden" name="cid" value="<?= bp_e($cm['id']) ?>">
                    <input type="hidden" name="cstatus" value="approved">
                    <button class="btn sm ok" type="submit">Təsdiqlə və dərc et</button>
                  </form>
                  <form method="post">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="comment_status">
                    <input type="hidden" name="rid" value="<?= bp_e($cm['review_id']) ?>">
                    <input type="hidden" name="cid" value="<?= bp_e($cm['id']) ?>">
                    <input type="hidden" name="cstatus" value="hidden">
                    <button class="btn sm warn" type="submit">Gizlət</button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="card">
        <h2>Dərc olunmuş (<?= count($reviewsPublic) ?>)</h2>
        <?php if (!$reviewsPublic): ?>
          <div class="empty">Hələ dərc olunmuş rəy yoxdur.</div>
        <?php else: ?>
          <div class="rev-admin-list"><?php foreach ($reviewsPublic as $rv) $renderReview($rv); ?></div>
        <?php endif; ?>
      </div>

      <?php if ($reviewsHidden): ?>
        <div class="card">
          <h2>Gizli (<?= count($reviewsHidden) ?>)</h2>
          <div class="rev-admin-list"><?php foreach ($reviewsHidden as $rv) $renderReview($rv); ?></div>
        </div>
      <?php endif; ?>
    </div>

    <!-- MESSAGES (usta inbox-u) -->
    <div class="pane" id="pane-messages">
      <div class="card">
        <h2>Usta mesajları</h2>
        <p class="sub" style="margin-bottom:14px">Müştəri onlayn bron verəndə seçdiyi <b>qeydiyyatlı ustanın</b> inboxuna mesaj düşür. Cavabı burada qeyd edin; müştəriyə WhatsApp düyməsi göstərilmir.</p>
        <div class="stats">
          <div class="stat"><b><?= (int)$inboxCounts['all'] ?></b><span>Cəmi mesaj</span></div>
          <div class="stat"><b><?= (int)$inboxCounts['new'] ?></b><span>Yeni</span></div>
          <div class="stat"><b><?= (int)$inboxCounts['read'] ?></b><span>Oxundu</span></div>
          <div class="stat"><b><?= (int)$inboxCounts['replied'] ?></b><span>Cavablandı</span></div>
        </div>
        <?php if ($masterNames): ?>
        <form method="get" class="filter-row">
          <input type="hidden" name="tab" value="messages">
          <div class="field">
            <label for="imaster">Usta</label>
            <select id="imaster" name="imaster">
              <option value="">Hamısı</option>
              <?php foreach ($masterNames as $mn): ?>
                <option value="<?= bp_e($mn) ?>" <?= $inboxMaster === $mn ? 'selected' : '' ?>><?= bp_e($mn) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="btns" style="margin:0"><button class="btn sm" type="submit">Filtirlə</button></div>
        </form>
        <?php endif; ?>
      </div>

      <?php if (!$inboxItems): ?>
        <div class="card"><div class="empty">Hələ mesaj yoxdur. İlk onlayn bron yaradıldıqda burada görünəcək.</div></div>
      <?php else: ?>
        <div class="card">
          <h2>Mesajlar (<?= count($inboxItems) ?>)</h2>
          <div class="rev-admin-list">
            <?php foreach ($inboxItems as $m): ?>
              <?php
                $mStatus = (string)($m['status'] ?? 'new');
                $mLabel  = ['new' => 'Yeni', 'read' => 'Oxundu', 'replied' => 'Cavablandı'][$mStatus] ?? 'Yeni';
                $mClass  = 'ib-' . (in_array($mStatus, ['new', 'read', 'replied'], true) ? $mStatus : 'new');
              ?>
              <div class="rev-admin">
                <div class="rev-admin-head">
                  <div class="rev-admin-name">📩 <?= bp_e((string)$m['id']) ?> · <b><?= bp_e((string)$m['master']) ?></b></div>
                  <span class="ib-pill <?= $mClass ?>"><?= bp_e($mLabel) ?></span>
                </div>
                <div class="rev-admin-meta">Bron: <?= bp_e((string)$m['booking_code']) ?> · <?= bp_e((string)$m['date']) ?> <?= bp_e((string)$m['time']) ?> · <?= bp_e((string)$m['customer']) ?> · <?= bp_e((string)$m['phone']) ?></div>
                <div class="rev-admin-text">Xidmət: <?= bp_e((string)$m['service']) ?> · Qiymət: <?= (int)($m['price'] ?? 0) ?> AZN · Beh: <?= (int)($m['deposit'] ?? 0) ?> AZN</div>
                <?php if ((string)($m['note'] ?? '') !== ''): ?>
                  <div class="rev-admin-text">Müştəri qeydi: <?= bp_e((string)$m['note']) ?></div>
                <?php endif; ?>
                <?php if ((string)($m['reply'] ?? '') !== ''): ?>
                  <div class="rev-admin-text"><b>Cavab:</b> <?= bp_e((string)$m['reply']) ?></div>
                <?php endif; ?>
                <div class="bk-actions">
                  <form method="post">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="inbox_status">
                    <input type="hidden" name="id" value="<?= bp_e((string)$m['id']) ?>">
                    <input type="hidden" name="imaster" value="<?= bp_e($inboxMaster) ?>">
                    <input type="hidden" name="istatus" value="read">
                    <button class="btn sm mut" type="submit">Oxundu</button>
                  </form>
                  <form method="post" class="ib-reply">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="inbox_reply">
                    <input type="hidden" name="id" value="<?= bp_e((string)$m['id']) ?>">
                    <input type="hidden" name="imaster" value="<?= bp_e($inboxMaster) ?>">
                    <input type="text" name="reply" maxlength="500" placeholder="Ustaya cavab yazın..." aria-label="Cavab">
                    <button class="btn sm ok" type="submit">Cavablandır</button>
                  </form>
                  <form method="post">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="inbox_delete">
                    <input type="hidden" name="id" value="<?= bp_e((string)$m['id']) ?>">
                    <input type="hidden" name="imaster" value="<?= bp_e($inboxMaster) ?>">
                    <button class="btn sm mut" type="submit">Sil</button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- WHATSAPP (yalnız işçi: qəbul / administrator / salon sahibi) -->
    <div class="pane" id="pane-whatsapp">
      <div class="card">
        <h2>WhatsApp</h2>
        <p class="sub" style="margin-bottom:14px">Bu bölmə yalnız <b>qəbul</b>, <b>administrator</b> və <b>salon sahibi</b> üçündür. Müştəri tərəfində WhatsApp ilə bron düyməsi yoxdur — bron yalnız saytdakı «Növbə götür» formasından verilir və ustanın inboxuna mesaj kimi düşür.</p>
        <div class="wa-box">
          <div>
            <div class="rev-admin-meta">Salon WhatsApp nömrəsi</div>
            <div class="wa-num"><?= $waLink !== '' ? '+' . bp_e($waNumber) : 'Təyin edilməyib' ?></div>
          </div>
          <?php if ($waLink !== ''): ?>
            <a class="btn sm ok" href="<?= bp_e($waLink) ?>" target="_blank" rel="noopener">WhatsApp-da aç</a>
          <?php endif; ?>
        </div>
        <p class="hint" style="margin-top:14px">Nömrəni «Salon» tabından dəyişə bilərsiniz. Demo saytın footer-indəki WhatsApp keçidi qalır, lakin o, bron forması deyildir.</p>
      </div>
    </div>

    <!-- REPORT -->
    <div class="pane" id="pane-report">
      <div class="card">
        <h2>Gündəlik hesabat</h2>
        <form method="get" class="filter-row">
          <div class="field">
            <label for="frdate">Gün</label>
            <input type="date" id="frdate" name="rdate" value="<?= bp_e($rdate) ?>">
          </div>
          <div class="btns" style="margin:0"><button class="btn sm" type="submit">Hesabla</button></div>
        </form>

        <?php
          $bs = $report['by_status'];
          $confirmedCount = (int)$bs['confirmed'] + (int)$bs['completed'];
          $azn = fn($v): string => number_format((int)$v, 0, '', ' ') . ' AZN';
        ?>
        <div class="stats">
          <div class="stat"><b><?= (int)$report['total'] ?></b><span>Cəmi bron</span></div>
          <div class="stat good"><b><?= $confirmedCount ?></b><span>Təsdiqlənmiş</span></div>
          <div class="stat money"><b><?= bp_e($azn($report['revenue'])) ?></b><span>Gəlir (salon)</span></div>
          <div class="stat money"><b><?= bp_e($azn($report['deposits'])) ?></b><span>Behlər</span></div>
          <div class="stat"><b><?= (int)$bs['pending'] ?></b><span>Beh gözləyir</span></div>
          <div class="stat"><b><?= (int)$bs['no_show'] ?></b><span>Gəlmədi</span></div>
          <div class="stat"><b><?= (int)$bs['cancelled'] ?></b><span>Ləğv edildi</span></div>
        </div>

        <div class="table-wrap">
          <table class="bk">
            <thead>
              <tr><th>Usta</th><th>Bron</th><th>Təsdiq / tamam</th><th>Gəlir</th><th>Beh</th><th>Davamiyyət</th></tr>
            </thead>
            <tbody>
              <?php $sumCount = 0; $sumConf = 0; $sumRevenue = 0; $sumDeposits = 0; ?>
              <?php foreach ($report['by_stylist'] as $sName => $row): ?>
                <?php
                  $sumCount += (int)$row['count'];
                  $conf = (int)($row['statuses']['confirmed'] ?? 0) + (int)($row['statuses']['completed'] ?? 0);
                  $sumConf += $conf;
                  $sumRevenue += (int)$row['revenue'];
                  $sumDeposits += (int)$row['deposits'];
                  $rState = bb_attendance_state($attStore, $rdate, $sName);
                ?>
                <tr>
                  <td><?= bp_e($sName) ?></td>
                  <td><?= (int)$row['count'] ?></td>
                  <td><?= $conf ?></td>
                  <td><?= bp_e($azn($row['revenue'])) ?></td>
                  <td><?= bp_e($azn($row['deposits'])) ?></td>
                  <td><span class="att-pill <?= $rState === 'off' ? 'off' : 'work' ?>"><i></i><?= $rState === 'off' ? 'İşdə deyil' : 'İşdədir' ?></span></td>
                </tr>
              <?php endforeach; ?>
              <tr>
                <td><b>Salon cəmi</b></td>
                <td><b><?= $sumCount ?></b></td>
                <td><b><?= $sumConf ?></b></td>
                <td><b><?= bp_e($azn($sumRevenue)) ?></b></td>
                <td><b><?= bp_e($azn($sumDeposits)) ?></b></td>
                <td>—</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="hint" style="margin-top:12px">Gəlirə yalnız «Təsdiqləndi» və «Tamamlandı» bronlar daxildir. Behlər həmin bronların ilkin ödənişləridir.</p>
      </div>
    </div>

    <!-- STYLE CATALOGUE -->
    <div class="pane" id="pane-studio">
      <div class="card">
        <h2>Stil kataloqu — Virtual Stil Studiyası</h2>
        <p class="sub" style="margin-bottom:8px">Müştəri demo saytda öz şəklini yükləyir, buradaki kataloqdan stil və rəng seçir və nəticəni öz şəklində görür. Bəyənsə «Ustaya göndər» düyməsi ilə bron pəncərəsini açır.</p>
        <p class="sub">«Canlı nəticə» rejimləri (saç rəngi, makiyaj, qaş, dırnaq) müştərinin şəklində brauzerdə hesablanır — şəkil serverə getmir. «Nümunə» rejimi yalnız foto göstərir (saç düzümü kimi formalar üçün).</p>
      </div>

      <div class="card">
        <h2>Yeni stil əlavə et</h2>
        <form method="post" enctype="multipart/form-data" class="staff-card">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="action" value="save_style">

          <div class="grid2">
            <div class="field">
              <label for="ns-cat">Kateqoriya</label>
              <select id="ns-cat" name="cat" required>
                <?php foreach ($studioCats as $ck => $cc): ?>
                  <option value="<?= bp_e((string)$ck) ?>"><?= bp_e((string)($cc['icon'] ?? '')) ?> <?= bp_e((string)($cc['label']['az'] ?? $ck)) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <label for="ns-mode">Rejim</label>
              <select id="ns-mode" name="mode">
                <option value="sample">Nümunə foto (forma dəyişmir)</option>
                <option value="hair">Canlı — saç rəngi</option>
                <option value="gloss">Canlı — parlaqlıq / keratin</option>
                <option value="makeup">Canlı — makiyaj</option>
                <option value="brow">Canlı — qaş</option>
                <option value="nails">Canlı — dırnaq</option>
              </select>
            </div>
          </div>

          <div class="grid2">
            <div class="field">
              <label for="ns-naz">Ad — AZ</label>
              <input type="text" id="ns-naz" name="name[az]" maxlength="60" required>
            </div>
            <div class="field">
              <label for="ns-nen">Ad — EN</label>
              <input type="text" id="ns-nen" name="name[en]" maxlength="60">
            </div>
            <div class="field">
              <label for="ns-ntr">Ad — TR</label>
              <input type="text" id="ns-ntr" name="name[tr]" maxlength="60">
            </div>
            <div class="field">
              <label for="ns-nru">Ad — RU</label>
              <input type="text" id="ns-nru" name="name[ru]" maxlength="60">
            </div>
          </div>

          <div class="grid2">
            <div class="field">
              <label for="ns-daz">Təsvir — AZ</label>
              <input type="text" id="ns-daz" name="desc[az]" maxlength="220">
            </div>
            <div class="field">
              <label for="ns-den">Təsvir — EN</label>
              <input type="text" id="ns-den" name="desc[en]" maxlength="220">
            </div>
            <div class="field">
              <label for="ns-dtr">Təsvir — TR</label>
              <input type="text" id="ns-dtr" name="desc[tr]" maxlength="220">
            </div>
            <div class="field">
              <label for="ns-dru">Təsvir — RU</label>
              <input type="text" id="ns-dru" name="desc[ru]" maxlength="220">
            </div>
          </div>

          <div class="grid2">
            <div class="field">
              <label for="ns-svc">Bağlı xidmət</label>
              <select id="ns-svc" name="service_id">
                <?php foreach (($CFG['services'] ?? []) as $svc): ?>
                  <option value="<?= (int)$svc['id'] ?>"><?= bp_e((string)($svc['title']['az'] ?? $svc['id'])) ?> — <?= (int)$svc['price'] ?> AZN</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <label for="ns-img">Nümunə foto (JPG/PNG/WEBP, maks. 3 MB)</label>
              <input type="file" id="ns-img" name="img" accept="image/jpeg,image/png,image/webp">
            </div>
          </div>

          <div class="field">
            <label>Rəng seçimləri (müştəriyə göstərilir)</label>
            <div class="color-checks">
              <?php foreach ($studioPalette as $pk => $pc): ?>
                <label>
                  <input type="checkbox" name="colors[]" value="<?= bp_e((string)$pk) ?>">
                  <i style="background:<?= bp_e((string)$pc['hex']) ?>"></i>
                  <?= bp_e((string)($pc['name']['az'] ?? $pk)) ?>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <label class="staff-flags" style="margin-bottom:10px">
            <input type="checkbox" name="active" value="1" checked> Saytda göstər
          </label>

          <button class="btn" type="submit">Stili yadda saxla</button>
        </form>
      </div>

      <div class="card">
        <h2>Kataloq (<?= count($studioAll) ?> stil)</h2>
        <?php if (!$studioAll): ?>
          <p class="sub">Kataloq boşdur. Yuxarıdan yeni stil əlavə edin.</p>
        <?php endif; ?>
      </div>

      <div class="staff-list">
        <?php foreach ($studioAll as $i => $st): ?>
          <?php
            $stId    = (string)$st['id'];
            $stName  = (string)($st['name']['az'] ?? $stId);
            $stCat   = (string)($st['cat'] ?? '');
            $stCatLb = (string)($studioCats[$stCat]['label']['az'] ?? $stCat);
            $stMode  = (string)($st['mode'] ?? 'sample');
            $stModeLb = [
                'hair'   => 'Canlı · saç rəngi',
                'gloss'  => 'Canlı · parlaqlıq',
                'makeup' => 'Canlı · makiyaj',
                'brow'   => 'Canlı · qaş',
                'nails'  => 'Canlı · dırnaq',
                'sample' => 'Nümunə foto',
            ][$stMode] ?? $stMode;
            $stColors = is_array($st['colors'] ?? null) ? $st['colors'] : [];
            $stImg    = (string)($st['img_url'] ?? '');
          ?>
          <div class="staff-card">
            <div class="staff-head">
              <?php if ($stImg !== ''): ?>
                <img class="style-thumb" src="<?= bp_e($stImg) ?>" alt="<?= bp_e($stName) ?>">
              <?php else: ?>
                <div class="style-thumb style-thumb--empty">🖼️</div>
              <?php endif; ?>
              <div style="flex:1;min-width:180px">
                <h3><?= bp_e($stName) ?></h3>
                <div class="rev-admin-meta"><?= bp_e($stCatLb) ?> · <?= bp_e($stId) ?><?= !empty($st['custom']) ? ' · panel stilı' : '' ?></div>
                <div class="style-meta">
                  <span class="<?= $stMode === 'sample' ? '' : 'live' ?>"><?= bp_e($stModeLb) ?></span>
                  <span class="<?= !empty($st['active']) ? 'on' : 'off' ?>"><?= !empty($st['active']) ? 'Saytda' : 'Gizli' ?></span>
                  <?php if ($stColors): ?><span><?= count($stColors) ?> rəng</span><?php endif; ?>
                </div>
              </div>
            </div>

            <form method="post" enctype="multipart/form-data">
              <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="action" value="save_style">
              <input type="hidden" name="id" value="<?= bp_e($stId) ?>">
              <input type="hidden" name="cat" value="<?= bp_e($stCat) ?>">

              <div class="grid2">
                <div class="field">
                  <label for="sn-az<?= $i ?>">Ad — AZ</label>
                  <input type="text" id="sn-az<?= $i ?>" name="name[az]" maxlength="60" value="<?= bp_e((string)($st['name']['az'] ?? '')) ?>">
                </div>
                <div class="field">
                  <label for="sn-en<?= $i ?>">Ad — EN</label>
                  <input type="text" id="sn-en<?= $i ?>" name="name[en]" maxlength="60" value="<?= bp_e((string)($st['name']['en'] ?? '')) ?>">
                </div>
                <div class="field">
                  <label for="sn-tr<?= $i ?>">Ad — TR</label>
                  <input type="text" id="sn-tr<?= $i ?>" name="name[tr]" maxlength="60" value="<?= bp_e((string)($st['name']['tr'] ?? '')) ?>">
                </div>
                <div class="field">
                  <label for="sn-ru<?= $i ?>">Ad — RU</label>
                  <input type="text" id="sn-ru<?= $i ?>" name="name[ru]" maxlength="60" value="<?= bp_e((string)($st['name']['ru'] ?? '')) ?>">
                </div>
              </div>

              <div class="grid2">
                <div class="field">
                  <label for="sd-az<?= $i ?>">Təsvir — AZ</label>
                  <input type="text" id="sd-az<?= $i ?>" name="desc[az]" maxlength="220" value="<?= bp_e((string)($st['desc']['az'] ?? '')) ?>">
                </div>
                <div class="field">
                  <label for="sd-en<?= $i ?>">Təsvir — EN</label>
                  <input type="text" id="sd-en<?= $i ?>" name="desc[en]" maxlength="220" value="<?= bp_e((string)($st['desc']['en'] ?? '')) ?>">
                </div>
                <div class="field">
                  <label for="sd-tr<?= $i ?>">Təsvir — TR</label>
                  <input type="text" id="sd-tr<?= $i ?>" name="desc[tr]" maxlength="220" value="<?= bp_e((string)($st['desc']['tr'] ?? '')) ?>">
                </div>
                <div class="field">
                  <label for="sd-ru<?= $i ?>">Təsvir — RU</label>
                  <input type="text" id="sd-ru<?= $i ?>" name="desc[ru]" maxlength="220" value="<?= bp_e((string)($st['desc']['ru'] ?? '')) ?>">
                </div>
              </div>

              <div class="grid2">
                <div class="field">
                  <label for="ss<?= $i ?>">Bağlı xidmət</label>
                  <select id="ss<?= $i ?>" name="service_id">
                    <?php foreach (($CFG['services'] ?? []) as $svc): ?>
                      <option value="<?= (int)$svc['id'] ?>" <?= (int)$svc['id'] === (int)($st['service_id'] ?? 0) ? 'selected' : '' ?>><?= bp_e((string)($svc['title']['az'] ?? $svc['id'])) ?> — <?= (int)$svc['price'] ?> AZN</option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="field">
                  <label for="si<?= $i ?>">Nümunə foto</label>
                  <input type="file" id="si<?= $i ?>" name="img" accept="image/jpeg,image/png,image/webp">
                  <?php if ($stImg !== ''): ?>
                    <label style="display:flex;align-items:center;gap:7px;margin-top:8px;font-size:13px">
                      <input type="checkbox" name="delete_photo" value="1" style="width:auto"> Mövcud fotonu sil
                    </label>
                  <?php endif; ?>
                </div>
              </div>

              <div class="field">
                <label>Rəng seçimləri</label>
                <div class="color-checks">
                  <?php foreach ($studioPalette as $pk => $pc): ?>
                    <label>
                      <input type="checkbox" name="colors[]" value="<?= bp_e((string)$pk) ?>" <?= in_array((string)$pk, $stColors, true) ? 'checked' : '' ?>>
                      <i style="background:<?= bp_e((string)$pc['hex']) ?>"></i>
                      <?= bp_e((string)($pc['name']['az'] ?? $pk)) ?>
                    </label>
                  <?php endforeach; ?>
                </div>
              </div>

              <label class="staff-flags" style="margin-bottom:10px">
                <input type="checkbox" name="active" value="1" <?= !empty($st['active']) ? 'checked' : '' ?>> Saytda göstər
              </label>

              <button class="btn" type="submit">Yadda saxla</button>
            </form>

            <form method="post" onsubmit="return confirm('«<?= bp_e(addslashes($stName)) ?>» kataloqdan çıxarılsın?');" style="margin-top:10px">
              <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="action" value="delete_style">
              <input type="hidden" name="id" value="<?= bp_e($stId) ?>">
              <button class="btn sm danger" type="submit">Kataloqdan çıxar</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- SYSTEM -->
    <div class="pane" id="pane-system">
      <div class="card">
        <h2>Sistem</h2>
        <p class="sub">Dəyişikliklər <code>data/demo-beauty.json</code> faylında saxlanılır. Default dəyərlər <code>config/demo-beauty.php</code> faylındadır.</p>
        <p class="sub" style="margin-top:8px">Son yenilənmə: <?= is_file($jsonPath) ? bp_e(date('d.m.Y H:i', filemtime($jsonPath))) : '— (default)' ?></p>
        <div class="btns">
          <form method="post" onsubmit="return confirm('Bütün dəyişikliklər silinsin?');" style="margin:0">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="reset">
            <button class="btn danger" type="submit">Bütün dəyişiklikləri sıfırla</button>
          </form>
        </div>
      </div>
    </div>
  <?php endif; ?>

</div>
<script>
  document.querySelectorAll('.tab').forEach(function (t) {
    t.addEventListener('click', function () {
      document.querySelectorAll('.tab').forEach(function (x) { x.classList.toggle('active', x === t); });
      document.querySelectorAll('.pane').forEach(function (p) { p.classList.remove('active'); });
      var pane = document.getElementById('pane-' + t.dataset.pane);
      if (pane) pane.classList.add('active');
      try { localStorage.setItem('bp-tab', t.dataset.pane); } catch (e) {}
    });
  });
  document.querySelectorAll('[data-goto-tab]').forEach(function (a) {
    a.addEventListener('click', function (ev) {
      ev.preventDefault();
      var tab = document.querySelector('.tab[data-pane="' + a.dataset.gotoTab + '"]');
      if (tab) tab.click();
    });
  });
  try {
    var urlTab = new URLSearchParams(location.search).get('tab');
    var savedTab = urlTab || localStorage.getItem('bp-tab');
    if (savedTab) {
      var el = document.querySelector('.tab[data-pane="' + savedTab + '"]');
      if (el) el.click();
    }
  } catch (e) {}

  /* Qalereya limitləri: brauzer tez cavab verir, server yenə yoxlayır. */
  var mediaLimits = <?= json_encode($mediaLimits) ?>;
  document.querySelectorAll('[data-media-form]').forEach(function (form) {
    var input = form.querySelector('input[type=file]');
    var note = document.createElement('span');
    note.className = 'hint';
    input.insertAdjacentElement('afterend', note);
    var kind = form.dataset.mediaForm;
    var maxMb = kind === 'photo' ? mediaLimits.photo_mb : mediaLimits.video_mb;
    function baseHint(f) {
      if (!f) return 'Max ' + maxMb + ' MB' + (kind === 'video' ? ', ' + mediaLimits.video_sec + ' saniyə' : '') + '.';
      return (f.size / 1048576).toFixed(1) + ' MB' + (kind === 'video' ? ' · uzunluq yoxlanılır' : '');
    }
    input.addEventListener('change', function () {
      note.style.color = '';
      note.textContent = baseHint(input.files && input.files[0]);
    });
    note.textContent = baseHint(null);
    form.addEventListener('submit', function (e) {
      var f = input.files && input.files[0];
      if (!f) return;
      if (f.size > maxMb * 1048576) {
        e.preventDefault();
        note.style.color = '#f87171';
        note.textContent = 'Fayl çox böyük — max ' + maxMb + ' MB.';
        return;
      }
      if (kind !== 'video') return;
      e.preventDefault();
      var url = URL.createObjectURL(f);
      var probe = document.createElement('video');
      probe.preload = 'metadata';
      probe.onloadedmetadata = function () {
        URL.revokeObjectURL(url);
        if (isFinite(probe.duration) && probe.duration > mediaLimits.video_sec + 0.2) {
          note.style.color = '#f87171';
          note.textContent = 'Video ' + mediaLimits.video_sec + ' saniyədən uzundur (' + Math.round(probe.duration) + ' s).';
        } else {
          form.submit();
        }
      };
      probe.onerror = function () { URL.revokeObjectURL(url); form.submit(); };
      probe.src = url;
    });
  });
</script>
</body>
</html>
