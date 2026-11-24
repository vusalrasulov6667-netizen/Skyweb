<?php
/**
 * Create password_resets table in database
 */
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = db();
    $sql = "CREATE TABLE IF NOT EXISTS password_resets (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(150) NOT NULL,
      code VARCHAR(6) NOT NULL,
      expires_at TIMESTAMP NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      INDEX idx_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $pdo->exec($sql);
    echo "Table 'password_resets' created successfully or already exists.\n";
} catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}
