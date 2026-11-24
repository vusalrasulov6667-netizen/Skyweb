<?php
/**
 * Create users table in database
 */
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = db();
    $sql = "CREATE TABLE IF NOT EXISTS users (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      uuid CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
      fullname VARCHAR(150) NOT NULL,
      email VARCHAR(191) NOT NULL,
      phone VARCHAR(50) NOT NULL DEFAULT '',
      password_hash VARCHAR(255) NOT NULL,
      role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
      avatar_url VARCHAR(500) NULL,
      is_verified TINYINT(1) UNSIGNED DEFAULT 0,
      is_active TINYINT(1) UNSIGNED DEFAULT 1,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      UNIQUE KEY idx_users_email (email),
      UNIQUE KEY idx_users_phone (phone)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $pdo->exec($sql);
    echo "Table 'users' created successfully or already exists.\n";
} catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}
