<?php
/**
 * SKYWEB.AZ — SECRETS TEMPLATE (SAFE TO COMMIT)
 * ---------------------------------------------------------------
 * Copy this file to config/secrets.php and replace the placeholders with
 * real values for your machine. config/secrets.php is listed in .gitignore
 * and must never be committed.
 */

// Database (MariaDB / MySQL)
if (!defined('SKY_SECRET_DB_HOST'))     define('SKY_SECRET_DB_HOST',     'localhost');
if (!defined('SKY_SECRET_DB_PORT'))     define('SKY_SECRET_DB_PORT',     '3306');
if (!defined('SKY_SECRET_DB_NAME'))     define('SKY_SECRET_DB_NAME',     'skyweb_db');
if (!defined('SKY_SECRET_DB_USER'))     define('SKY_SECRET_DB_USER',     'YOUR_DB_USER');
if (!defined('SKY_SECRET_DB_PASS'))     define('SKY_SECRET_DB_PASS',     'YOUR_DB_PASSWORD');
if (!defined('SKY_SECRET_DB_CHARSET'))  define('SKY_SECRET_DB_CHARSET',  'utf8mb4');

// Admin panel — generate a hash with:
//   php -r "echo password_hash('YOUR_PASSWORD', PASSWORD_DEFAULT);"
if (!defined('SKY_SECRET_ADMIN_USER'))  define('SKY_SECRET_ADMIN_USER',  'admin');
if (!defined('SKY_SECRET_ADMIN_HASH'))  define('SKY_SECRET_ADMIN_HASH',  'YOUR_BCRYPT_HASH');

// Panel passwords
if (!defined('SKY_SECRET_BEAUTY_PANEL_PASSWORD')) define('SKY_SECRET_BEAUTY_PANEL_PASSWORD', 'YOUR_BEAUTY_PANEL_PASSWORD');
if (!defined('SKY_SECRET_SKYBOT_ADMIN_PASSWORD')) define('SKY_SECRET_SKYBOT_ADMIN_PASSWORD', 'YOUR_SKYBOT_PASSWORD');
if (!defined('SKY_SECRET_CV_SALT'))              define('SKY_SECRET_CV_SALT',              'YOUR_RANDOM_SALT');

// Machine-specific tool paths (leave empty to auto-detect via PATH / PHP_BINDIR)
if (!defined('SKY_SECRET_PHP_CANDIDATES')) define('SKY_SECRET_PHP_CANDIDATES', []);
if (!defined('SKY_SECRET_FFMPEG_CANDIDATES')) define('SKY_SECRET_FFMPEG_CANDIDATES', []);

// Mail / external services (unused by default; reserved for future use)
if (!defined('SKY_SECRET_SMTP_HOST')) define('SKY_SECRET_SMTP_HOST', '');
if (!defined('SKY_SECRET_SMTP_PORT')) define('SKY_SECRET_SMTP_PORT', '');
if (!defined('SKY_SECRET_SMTP_USER')) define('SKY_SECRET_SMTP_USER', '');
if (!defined('SKY_SECRET_SMTP_PASS')) define('SKY_SECRET_SMTP_PASS', '');
if (!defined('SKY_SECRET_SMTP_FROM')) define('SKY_SECRET_SMTP_FROM', 'info@your-domain.example');
if (!defined('SKY_SECRET_API_KEY'))   define('SKY_SECRET_API_KEY',   '');
