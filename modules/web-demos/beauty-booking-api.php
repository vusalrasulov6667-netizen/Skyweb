<?php
/**
 * Sky Beauty — onlayn bron endpoint-i (public).
 * ------------------------------------------------------------------
 * POST (JSON və ya form):
 *   token, service_id, stylist, date (YYYY-MM-DD), time (HH:MM),
 *   name, phone, note, lang
 *
 * Cavab (JSON):
 *   {ok:true, code, date, time, stylist, service, price, deposit, status,
 *    card_number, card_holder, visit_no}
 *   {ok:false, error:"...lokalizə edilmiş mesaj..."}
 *
 * Qoruma: sessiya tokeni (CSRF), sessiya üzrə dəqiqəlik limit,
 * server tərəfində bütün sahələrin yenidən yoxlanması.
 */
declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/beauty-bookings.php';
require_once __DIR__ . '/../../config/beauty-inbox.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

function api_json(int $http, array $payload): void {
    http_response_code($http);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST');
    api_json(405, ['ok' => false, 'error' => 'Method not allowed']);
}

$raw  = (string)file_get_contents('php://input');
$in   = json_decode($raw, true);
if (!is_array($in)) $in = $_POST;
if (!is_array($in)) $in = [];

$lang = (string)($in['lang'] ?? 'az');
if (!in_array($lang, ['az', 'en', 'tr', 'ru'], true)) $lang = 'az';

/* ── Sessiya tokeni ── */
$token = (string)($in['token'] ?? '');
$sess  = (string)($_SESSION['beauty_book_token'] ?? '');
if ($sess === '' || $token === '' || !hash_equals($sess, $token)) {
    api_json(403, ['ok' => false, 'error' => bb_msg('save_failed', $lang)]);
}

/* ── Sadə limit: sessiya üzrə 10 dəqiqədə maksimum 6 bron ── */
$now  = time();
$log  = $_SESSION['beauty_book_log'] ?? [];
if (!is_array($log)) $log = [];
$log  = array_values(array_filter($log, fn($ts) => is_numeric($ts) && $ts > $now - 600));
if (count($log) >= 6) {
    api_json(429, ['ok' => false, 'error' => bb_msg('rate', $lang)]);
}

$cfg = bb_effective_config();
$res = bb_create_booking($in, $cfg, $cfg['_booking']);

if (empty($res['ok'])) {
    api_json(422, ['ok' => false, 'error' => (string)($res['error'] ?? bb_msg('save_failed', $lang))]);
}

$log[] = $now;
$_SESSION['beauty_book_log'] = $log;

$b = $res['booking'];
$s = $res['settings'];

/* ── Seçilmiş qeydiyyatlı ustanın inboxuna mesaj ── */
$inbox = bi_add([
    'master'       => (string)$b['stylist'],
    'booking_code' => (string)$b['code'],
    'customer'     => (string)$b['customer'],
    'phone'        => (string)$b['phone'],
    'service'      => (string)$b['service'],
    'date'         => (string)$b['date'],
    'time'         => (string)$b['time'],
    'note'         => (string)$b['note'],
    'price'        => (int)$b['price'],
    'deposit'      => (int)$b['deposit'],
]);

api_json(200, [
    'ok'          => true,
    'code'        => $b['code'],
    'date'        => $b['date'],
    'time'        => $b['time'],
    'stylist'     => $b['stylist'],
    'service'     => $b['service'],
    'service_id'  => $b['service_id'],
    'price'       => $b['price'],
    'deposit'     => $b['deposit'],
    'status'      => $b['status'],
    'visit_no'    => $b['visit_no'],
    'inbox_id'    => (string)($inbox['id'] ?? ''),
    'inbox_ok'    => !empty($inbox['ok']),
    'card_number' => (string)($s['card_number'] ?? ''),
    'card_holder' => (string)($s['card_holder'] ?? ''),
]);
