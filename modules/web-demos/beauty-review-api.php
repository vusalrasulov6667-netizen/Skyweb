<?php
/**
 * Sky Beauty — müştəri rəyi endpoint-i (public).
 * ------------------------------------------------------------------
 * POST (JSON və ya form):
 *   action=review (default): token, code (SB-XXXX), rating (1–5), text, lang
 *   action=comment:          token, id (RV-XXXX), text, lang
 *
 * Cavab:
 *   {ok:true, id, code, rating, status:"pending"}
 *   {ok:true, id, status:"pending"}  // fikir
 *   {ok:false, error:"...lokalizə edilmiş mesaj..."}
 *
 * Qoruma: sessiya tokeni (CSRF), sessiya üzrə 10 dəqiqədə maks. 4 rəy,
 * rəy yalnız «tamamlandı» bronuna bağlanır, hər bron üçün bir rəy.
 */
declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/beauty-bookings.php';
require_once __DIR__ . '/../../config/beauty-reviews.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

function rv_json(int $http, array $payload): void {
    http_response_code($http);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST');
    rv_json(405, ['ok' => false, 'error' => 'Method not allowed']);
}

$raw = (string)file_get_contents('php://input');
$in  = json_decode($raw, true);
if (!is_array($in)) $in = $_POST;
if (!is_array($in)) $in = [];

$lang = (string)($in['lang'] ?? 'az');
if (!in_array($lang, ['az', 'en', 'tr', 'ru'], true)) $lang = 'az';

$token = (string)($in['token'] ?? '');
$sess  = (string)($_SESSION['beauty_review_token'] ?? '');
if ($sess === '' || $token === '' || !hash_equals($sess, $token)) {
    rv_json(403, ['ok' => false, 'error' => br_msg('save_failed', $lang)]);
}

$now = time();
$log = $_SESSION['beauty_review_log'] ?? [];
if (!is_array($log)) $log = [];
$log = array_values(array_filter($log, fn($ts) => is_numeric($ts) && $ts > $now - 600));
if (count($log) >= 4) {
    rv_json(429, ['ok' => false, 'error' => br_msg('rate', $lang)]);
}

$action = (string)($in['action'] ?? 'review');
$text   = (string)($in['text'] ?? '');

if ($action === 'comment') {
    $res = br_add_comment((string)($in['id'] ?? ''), $text, $lang);
    if (empty($res['ok'])) {
        rv_json(422, ['ok' => false, 'error' => (string)($res['error'] ?? br_msg('save_failed', $lang))]);
    }
    $log[] = $now;
    $_SESSION['beauty_review_log'] = $log;
    $cm = $res['comment'];
    rv_json(200, [
        'ok'     => true,
        'action' => 'comment',
        'id'     => $cm['id'],
        'status' => $cm['status'],
    ]);
}

$res = br_add([
    'code'   => (string)($in['code'] ?? ''),
    'rating' => (int)($in['rating'] ?? 0),
    'text'   => $text,
    'lang'   => $lang,
]);

if (empty($res['ok'])) {
    rv_json(422, ['ok' => false, 'error' => (string)($res['error'] ?? br_msg('save_failed', $lang))]);
}

$log[] = $now;
$_SESSION['beauty_review_log'] = $log;

$r = $res['review'];
rv_json(200, [
    'ok'     => true,
    'id'     => $r['id'],
    'code'   => $r['code'],
    'rating' => $r['rating'],
    'status' => $r['status'],
]);
