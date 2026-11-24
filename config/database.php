<?php
/**
 * SKYWEB.AZ — Verilənlər Bazası Konfiqurasyonu
 * PDO bağlantısı + xəta idarəetməsi
 */

// Real dəyərlər git-ə daxil olmayan config/secrets.php faylından gəlir.
if (is_file(__DIR__ . '/secrets.php')) {
    require_once __DIR__ . '/secrets.php';
}

if (!defined('DB_HOST'))     define('DB_HOST',     defined('SKY_SECRET_DB_HOST')    ? SKY_SECRET_DB_HOST    : 'localhost');
if (!defined('DB_PORT'))     define('DB_PORT',     defined('SKY_SECRET_DB_PORT')    ? SKY_SECRET_DB_PORT    : '3306');
if (!defined('DB_NAME'))     define('DB_NAME',     defined('SKY_SECRET_DB_NAME')    ? SKY_SECRET_DB_NAME    : 'skyweb_db');
if (!defined('DB_USER'))     define('DB_USER',     defined('SKY_SECRET_DB_USER')    ? SKY_SECRET_DB_USER    : 'root');
if (!defined('DB_PASS'))     define('DB_PASS',     defined('SKY_SECRET_DB_PASS')    ? SKY_SECRET_DB_PASS    : '');
if (!defined('DB_CHARSET'))  define('DB_CHARSET',  defined('SKY_SECRET_DB_CHARSET') ? SKY_SECRET_DB_CHARSET : 'utf8mb4');

/**
 * Tək PDO instansiyası qaytarır (Singleton)
 */
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            DB_HOST, DB_PORT, DB_NAME, DB_CHARSET
        );
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // Production-da log-a yaz, istifadəçiyə ümumi mesaj göstər
            error_log('[Skyweb DB Error] ' . $e->getMessage());

            /* API / AJAX sorğuları JSON gözləyir — onlara JSON qaytarırıq.
               Adi brauzer səhifələri isə oxunaqlı mesaj görür (əvvəl raw JSON çıxırdı). */
            $path     = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
            $isAjax   = strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest';
            $accepts  = strpos(strtolower((string) ($_SERVER['HTTP_ACCEPT'] ?? '')), 'application/json') !== false;
            $isApi    = strpos($path, '/api/') !== false;

            http_response_code(503);

            if ($isAjax || $accepts || $isApi) {
                header('Content-Type: application/json; charset=utf-8');
                die(json_encode(['error' => 'Database service unavailable.']));
            }

            header('Content-Type: text/html; charset=utf-8');

            /* Layihə kökü: /sky/auth/login-process.php → /sky */
            $base = rtrim(str_replace('\\', '/', dirname(dirname($path))), '/');
            if ($base === '' || $base === '.') {
                $base = '';
            }

            die('<!DOCTYPE html><html lang="az"><head><meta charset="utf-8">'
                . '<meta name="viewport" content="width=device-width, initial-scale=1">'
                . '<title>Hesab sistemi hazırda əlçatmazdır — Skyweb.az</title>'
                . '<style>'
                . 'body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;'
                . 'background:#050b18;color:#e6f1ff;font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;padding:1.5rem}'
                . '.box{max-width:560px;background:rgba(255,255,255,.03);border:1px solid rgba(0,229,255,.25);'
                . 'border-radius:16px;padding:2rem;box-shadow:0 20px 60px rgba(0,0,0,.5)}'
                . 'h1{margin:0 0 .6rem;font-size:1.35rem;color:#00e5ff}'
                . 'p{margin:.5rem 0;line-height:1.65;font-size:.95rem;color:#9fb3c8}'
                . '.btns{display:flex;gap:.6rem;flex-wrap:wrap;margin-top:1.4rem}'
                . 'a{display:inline-block;padding:.6rem 1.1rem;border-radius:9px;text-decoration:none;'
                . 'font-size:.9rem;font-weight:600;border:1px solid rgba(0,229,255,.45);color:#00e5ff}'
                . 'a.primary{background:linear-gradient(135deg,#00e5ff,#0284c7);color:#03121f;border:none}'
                . '</style></head><body><div class="box">'
                . '<h1>Hesab sistemi hazırda əlçatmazdır</h1>'
                . '<p>Saytın istifadəçi hesabları (qeydiyyat / «Daxil ol») verilənlər bazasına bağlıdır və '
                . 'baza hazırda qurulmayıb. Buna görə bu forma ilə giriş mümkün deyil.</p>'
                . '<p><strong style="color:#e6f1ff">Admin panelinə giriş</strong> ayrıdır və bazaya ehtiyac duymur: '
                . '<code style="color:#7dd3fc">/admin/</code></p>'
                . '<p style="font-size:.85rem;color:#64748b">User accounts are unavailable while the database is not set up. '
                . 'The admin panel at <code>/admin/</code> works independently.</p>'
                . '<div class="btns"><a class="primary" href="' . htmlspecialchars($base, ENT_QUOTES) . '/admin/">Admin panelinə keç</a>'
                . '<a href="' . htmlspecialchars($base, ENT_QUOTES) . '/index.php">Ana səhifə</a></div>'
                . '</div></body></html>');
        }
    }
    return $pdo;
}
