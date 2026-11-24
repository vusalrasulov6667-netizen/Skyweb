<?php
/**
 * Setup Database
 */
if (is_file(__DIR__ . '/../config/secrets.php')) {
    require_once __DIR__ . '/../config/secrets.php';
}

$host = defined('SKY_SECRET_DB_HOST') ? SKY_SECRET_DB_HOST : 'localhost';
$port = defined('SKY_SECRET_DB_PORT') ? SKY_SECRET_DB_PORT : '3306';
$user = defined('SKY_SECRET_DB_USER') ? SKY_SECRET_DB_USER : 'root';
$pass = defined('SKY_SECRET_DB_PASS') ? SKY_SECRET_DB_PASS : '';

try {
    // Connect without selecting DB
    $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Create DB
    $pdo->exec("CREATE DATABASE IF NOT EXISTS skyweb_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "Database 'skyweb_db' created or already exists.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
