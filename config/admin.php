<?php
/**
 * SKYWEB.AZ — Admin Panel autentifikasiyası
 * ---------------------------------------------------------------
 * Admin panel `/admin/` yalnız bu giriş ilə açılır:
 *   İstifadəçi adı : config/secrets.php → SKY_SECRET_ADMIN_USER
 *   Şifrə          : config/secrets.php → SKY_SECRET_ADMIN_HASH (bcrypt hash)
 *
 * Şifrə dəyişdirildikdə hash `data/admin_auth.json` faylına yazılır və
 * bu fayldakı default hash-dən üstün tutulur.
 *
 * DB əsaslı admin (users.role = 'admin') sessiyası da qəbul olunur —
 * `auth/login-process.php` ilə daxil olan real adminlər üçün.
 */

if (is_file(__DIR__ . '/secrets.php')) {
    require_once __DIR__ . '/secrets.php';
}

if (!defined('SKY_ADMIN_USER')) {
    define('SKY_ADMIN_USER', defined('SKY_SECRET_ADMIN_USER') ? SKY_SECRET_ADMIN_USER : 'admin');
}

if (!defined('SKY_ADMIN_DEFAULT_HASH')) {
    define('SKY_ADMIN_DEFAULT_HASH', defined('SKY_SECRET_ADMIN_HASH') ? SKY_SECRET_ADMIN_HASH : '');
}

if (!defined('SKY_ADMIN_AUTH_FILE')) {
    define('SKY_ADMIN_AUTH_FILE', dirname(__DIR__) . '/data/admin_auth.json');
}

// Sessiya açarları
if (!defined('SKY_ADMIN_SESSION_KEY')) {
    define('SKY_ADMIN_SESSION_KEY', 'sky_admin_auth');
}

/** Aktiv şifrə hash-i (dəyişdirilibsə fayldan) */
function sky_admin_password_hash(): string {
    if (is_file(SKY_ADMIN_AUTH_FILE)) {
        $raw = @file_get_contents(SKY_ADMIN_AUTH_FILE);
        if ($raw !== false && $raw !== '') {
            $j = json_decode($raw, true);
            if (is_array($j) && !empty($j['hash']) && is_string($j['hash'])) {
                return $j['hash'];
            }
        }
    }
    return SKY_ADMIN_DEFAULT_HASH;
}

/** Yeni şifrə hash-ini saxlayır */
function sky_admin_set_password(string $plain): bool {
    $dir = dirname(SKY_ADMIN_AUTH_FILE);
    if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
        return false;
    }

    $json = json_encode(
        ['hash' => password_hash($plain, PASSWORD_DEFAULT), 'updated_at' => date('c')],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
    );
    if ($json === false) {
        return false;
    }

    return @file_put_contents(SKY_ADMIN_AUTH_FILE, $json, LOCK_EX) !== false;
}

/** Admin sessiyası aktivdir? */
function sky_admin_is_logged_in(): bool {
    // 1) DB əsaslı admin (əgər sessiya varsa)
    if (($_SESSION['user']['role'] ?? '') === 'admin') {
        return true;
    }

    // 2) Panel öz sessiyası
    $auth = $_SESSION[SKY_ADMIN_SESSION_KEY] ?? null;
    if (!is_array($auth) || empty($auth['ok'])) {
        return false;
    }

    // 12 saatlik idle timeout (sessiya faylı 1 gün saxlanılır)
    $last = (int) ($auth['last_seen'] ?? 0);
    if ($last > 0 && (time() - $last) > 43200) {
        unset($_SESSION[SKY_ADMIN_SESSION_KEY]);
        return false;
    }

    return true;
}

/** Şifrəni yoxlayır */
function sky_admin_verify_password(string $plain): bool {
    if ($plain === '') {
        return false;
    }
    return password_verify($plain, sky_admin_password_hash());
}

/** Admin sessiyasını qurur */
function sky_admin_login_session(): void {
    if (function_exists('session_regenerate_id')) {
        @session_regenerate_id(true);
    }
    $_SESSION[SKY_ADMIN_SESSION_KEY] = [
        'ok'        => true,
        'since'     => time(),
        'last_seen' => time(),
        'ua'        => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 120),
    ];
    unset($_SESSION['sky_admin_fails'], $_SESSION['sky_admin_lock_until']);
}

/** Sessiyanı bağlayır (yalnız panel sessiyası) */
function sky_admin_logout(): void {
    unset($_SESSION[SKY_ADMIN_SESSION_KEY]);
}

/** Sessiyanın son aktivliyini yeniləyir */
function sky_admin_touch(): void {
    if (!empty($_SESSION[SKY_ADMIN_SESSION_KEY]['ok'])) {
        $_SESSION[SKY_ADMIN_SESSION_KEY]['last_seen'] = time();
    }
}

/** Brute-force qoruması: 5 uğursuz cəhddən sonra 10 dəqiqə blok */
function sky_admin_is_locked(): bool {
    $until = (int) ($_SESSION['sky_admin_lock_until'] ?? 0);
    return $until > time();
}

function sky_admin_lock_seconds_left(): int {
    $until = (int) ($_SESSION['sky_admin_lock_until'] ?? 0);
    return max(0, $until - time());
}

function sky_admin_register_failure(): void {
    $fails = (int) ($_SESSION['sky_admin_fails'] ?? 0) + 1;
    $_SESSION['sky_admin_fails'] = $fails;
    if ($fails >= 5) {
        $_SESSION['sky_admin_lock_until'] = time() + 600;
        $_SESSION['sky_admin_fails'] = 0;
    }
}

function sky_admin_clear_failures(): void {
    unset($_SESSION['sky_admin_fails'], $_SESSION['sky_admin_lock_until']);
}
