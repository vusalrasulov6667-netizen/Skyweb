<?php
/**
 * SKYWEB.AZ — Global Konfiqurasiya
 */

// Lokal sekretlər (git-ə daxil olmur). Fayl yoxdursa, aşağıdakı təhlükəsiz
// defaultlar istifadə olunur — sayt işləməyə davam edir.
if (is_file(__DIR__ . '/secrets.php')) {
    require_once __DIR__ . '/secrets.php';
}

// Sayt URL (trailing slash olmadan)
// Host dinamikdir: sayt həm `localhost`, həm `127.0.0.1`, həm də LAN IP (məs. 192.168.x.x)
// ünvanı ilə açılanda linklər, CSS/JS və redirect-lər həmin ünvana uyğun qurulur.
$skyScheme = 'http';
if ((!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
    || strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https') {
    $skyScheme = 'https';
}

$skyHost = preg_replace('/[^A-Za-z0-9\.\-:\[\]]/', '', (string) ($_SERVER['HTTP_HOST'] ?? ''));
if ($skyHost === '' || $skyHost === null) {
    $skyHost = 'localhost';
}

// Layihənin veb kökü (məs. /sky) — DOCUMENT_ROOT ilə fayl sistemindən hesablanır.
$skyBasePath = '/sky';
$skyDocRoot  = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
$skyAppRoot  = realpath(dirname(__DIR__));
if ($skyDocRoot && $skyAppRoot && stripos($skyAppRoot, $skyDocRoot) === 0) {
    $skyBasePath = '/' . trim(str_replace('\\', '/', substr($skyAppRoot, strlen($skyDocRoot))), '/');
    if ($skyBasePath === '/') {
        $skyBasePath = '';
    }
}

define('SITE_URL', $skyScheme . '://' . $skyHost . $skyBasePath);
define('SITE_NAME',     'Skyweb.az');
define('SITE_TAGLINE',  'Rəqəmsal Gələcəyin Ekosistemi');
define('SITE_EMAIL',    'info@skyweb.az');
define('SITE_PHONE',    '+994 55 000 00 00');

// Platforma keçidləri ("Skyweb Hər Cihazda Yanınızda!" bloku + footer)
// Tətbiqlər mağazada dərc olunduqdan sonra PLAY / APPLE ünvanlarını
// real listing linkləri ilə əvəz etmək kifayətdir.
define('SKY_LINK_WAP',   'https://skyweb.az/wap');
define('SKY_LINK_WEB',   'https://skyweb.az/app');
define('SKY_LINK_PLAY',  'https://play.google.com/store/apps');
define('SKY_LINK_APPLE', 'https://www.apple.com/app-store/');

// Versiya
define('APP_VERSION',   '1.0.0');
define('APP_ENV',       'development'); // 'production'

// Komisiya faizi (Freelance iş)
define('COMMISSION_PCT', 15.0);

// Yüklənmə limitləri
define('MAX_UPLOAD_MB',  10);

// Session konfiqurasiyası
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
// PHP defolt olaraq sessiya faylını 24 dəqiqə (1440 san) sonra silir —
// admin panelə girəndən yarım saat sonra footer-dəki idarəetmə düymələri
// yoxa çıxırdı. İndi sessiya 1 gün saxlanılır.
ini_set('session.gc_maxlifetime', '86400');
ini_set('session.cookie_lifetime', '86400');
ini_set('session.cookie_samesite', 'Lax');
session_start();

// Xəta bildirimi (dev mode)
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Zaman zonası
date_default_timezone_set('Asia/Baku');

// Köməkçi funksiyalar
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function redirect(string $path): void {
    header('Location: ' . SITE_URL . '/' . ltrim($path, '/'));
    exit;
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function currentUser(): ?array {
    return $_SESSION['user'] ?? null;
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_verify(string $token): bool {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

// Multi-Language (i18n) Engine
require_once __DIR__ . '/lang.php';

