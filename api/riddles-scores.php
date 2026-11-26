<?php
/**
 * SKYWEB.AZ — Brend Tapmacaları leaderboard.
 *
 * GET  ?action=top  -> { top: [...], me: {...}|null }
 * POST action=save   -> saves the player's best score (requires login + CSRF).
 *
 * Storage: data/riddle-scores.json (file-based, LOCK_EX, best score per user).
 */
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

define('RIDDLE_SCORES_FILE', dirname(__DIR__) . '/data/riddle-scores.json');

function riddle_scores_default(): array {
    return ['updated_at' => '', 'users' => []];
}

function riddle_scores_load(): array {
    $file = RIDDLE_SCORES_FILE;
    if (!is_file($file)) return riddle_scores_default();
    $raw = @file_get_contents($file);
    if ($raw === false) return riddle_scores_default();
    $data = json_decode($raw, true);
    if (!is_array($data) || !isset($data['users']) || !is_array($data['users'])) {
        return riddle_scores_default();
    }
    if (!isset($data['updated_at'])) $data['updated_at'] = '';
    return $data;
}

function riddle_scores_save(array $data): bool {
    $dir = dirname(RIDDLE_SCORES_FILE);
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) return false;
    $data['updated_at'] = date('c');
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;

    $fp = @fopen(RIDDLE_SCORES_FILE, 'c');
    if ($fp === false) return false;
    if (!flock($fp, LOCK_EX)) { fclose($fp); return false; }
    rewind($fp);
    $written = fwrite($fp, $json);
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return $written !== false;
}

function riddle_clean_name($value): string {
    $name = trim(strip_tags((string) $value));
    $name = preg_replace('/\s+/u', ' ', $name) ?: '';
    if (function_exists('mb_substr')) return mb_substr($name, 0, 24, 'UTF-8');
    return substr($name, 0, 48);
}

function riddle_leaderboard(array $data, $viewerId = 0): array {
    $users = [];
    foreach ($data['users'] as $id => $row) {
        if (!is_array($row)) continue;
        $score = max(0, (int) ($row['score'] ?? 0));
        $users[] = [
            'user_id' => (int) $id,
            'name' => riddle_clean_name($row['name'] ?? ''),
            'score' => $score,
        ];
    }
    usort($users, static function (array $a, array $b): int {
        if ($a['score'] === $b['score']) return strcmp($a['name'], $b['name']);
        return $b['score'] <=> $a['score'];
    });

    $top = [];
    foreach (array_slice($users, 0, 10) as $i => $row) {
        $row['rank'] = $i + 1;
        $row['is_me'] = $viewerId > 0 && $row['user_id'] === (int) $viewerId;
        $top[] = $row;
    }

    $me = null;
    if ($viewerId > 0) {
        foreach ($users as $i => $row) {
            if ($row['user_id'] === (int) $viewerId) {
                $me = $row;
                $me['rank'] = $i + 1;
                break;
            }
        }
    }
    return ['top' => $top, 'me' => $me];
}

$body = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = (string) file_get_contents('php://input');
    $body = json_decode($raw, true);
}
$action = $_GET['action'] ?? (is_array($body) && isset($body['action']) ? $body['action'] : 'top');
$viewerId = isLoggedIn() ? (int) ($_SESSION['user_id'] ?? 0) : 0;

if ($action === 'save') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok' => false, 'error' => 'method']);
        exit;
    }
    if (!$viewerId) {
        http_response_code(401);
        echo json_encode(['ok' => false, 'error' => 'login_required']);
        exit;
    }
    $token = (string) ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    if ($token === '' || !csrf_verify($token)) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'csrf']);
        exit;
    }

    $score = is_array($body) ? (int) ($body['score'] ?? 0) : 0;
    $score = min(1000000, max(0, $score));

    $data = riddle_scores_load();
    $user = currentUser() ?: [];
    $name = riddle_clean_name($user['fullname'] ?? ('Oyunçu #' . $viewerId));
    if ($name === '') $name = 'Oyunçu #' . $viewerId;

    $key = (string) $viewerId;
    $old = isset($data['users'][$key]) && is_array($data['users'][$key])
        ? (int) ($data['users'][$key]['score'] ?? 0)
        : 0;
    if ($score > $old) {
        $data['users'][$key] = [
            'name' => $name,
            'score' => $score,
            'updated_at' => date('c'),
        ];
        if (!riddle_scores_save($data)) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => 'storage']);
            exit;
        }
    }

    echo json_encode(['ok' => true] + riddle_leaderboard($data, $viewerId), JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode(riddle_leaderboard(riddle_scores_load(), $viewerId), JSON_UNESCAPED_UNICODE);
