-- ============================================================
-- SKYWEB.AZ — Tam Verilənlər Bazası Strukturu
-- Versiya: 1.0 | Tarix: 2026
-- Kodlaşdırma: utf8mb4 (Azərbaycan dili + Emoji dəstəyi)
-- ============================================================

CREATE DATABASE IF NOT EXISTS skyweb_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE skyweb_db;

-- ============================================================
-- 1. USERS — Bütün istifadəçi tipləri
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid          CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()),
  fullname      VARCHAR(150) NOT NULL,
  email         VARCHAR(191) NOT NULL UNIQUE,
  phone         VARCHAR(50) NOT NULL DEFAULT '',
  password_hash VARCHAR(255) NOT NULL,
  role          ENUM('user','admin') NOT NULL DEFAULT 'user',
  avatar_url    VARCHAR(500) NULL,
  is_verified   TINYINT(1) UNSIGNED DEFAULT 0,
  is_active     TINYINT(1) UNSIGNED DEFAULT 1,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY idx_users_phone (phone)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. CV_TEMPLATES — CV Şablonları Kataloqu
-- ============================================================
CREATE TABLE IF NOT EXISTS cv_templates (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name         VARCHAR(150) NOT NULL,
  slug         VARCHAR(160) NOT NULL UNIQUE,
  preview_url  VARCHAR(500),
  thumbnail    VARCHAR(500),
  html_layout  LONGTEXT COMMENT 'Mustache/Twig template HTML',
  category     ENUM('classic','modern','creative','ats_friendly','executive') DEFAULT 'modern',
  color_scheme VARCHAR(50) DEFAULT 'dark-blue',
  price        DECIMAL(8,2) UNSIGNED DEFAULT 0.00,
  is_premium   TINYINT(1) DEFAULT 0,
  is_active    TINYINT(1) DEFAULT 1,
  downloads    INT UNSIGNED DEFAULT 0,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_category (category),
  INDEX idx_premium  (is_premium)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. CV_ORDERS — İstifadəçinin Hazırladığı CV-lər
-- ============================================================
CREATE TABLE IF NOT EXISTS cv_orders (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id      INT UNSIGNED NOT NULL,
  template_id  INT UNSIGNED NOT NULL,
  cv_data      JSON NOT NULL COMMENT 'Full CV content: personal, education, experience, skills',
  pdf_url      VARCHAR(500),
  status       ENUM('draft','paid','exported','deleted') DEFAULT 'draft',
  paid_at      TIMESTAMP NULL,
  exported_at  TIMESTAMP NULL,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id)     REFERENCES users(id)         ON DELETE CASCADE,
  FOREIGN KEY (template_id) REFERENCES cv_templates(id)  ON DELETE RESTRICT,
  INDEX idx_user_status (user_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. BUSINESS_ORDERS — Biznes/İaşə Sifarişləri
-- ============================================================
CREATE TABLE IF NOT EXISTS business_orders (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id     INT UNSIGNED,
  business_type ENUM('restaurant','beauty','clinic','gym','pharmacy','market','boutique','hospital','dental','fitness','other') DEFAULT 'other',
  service_type  ENUM('android_app','ios_app','web_site','smm_package','analytics','mini_game','all_in_one','custom') DEFAULT 'custom',
  contact_name  VARCHAR(150) NOT NULL,
  contact_phone VARCHAR(30) NOT NULL,
  contact_email VARCHAR(191),
  business_name VARCHAR(200),
  requirements  TEXT,
  budget        VARCHAR(100),
  status        ENUM('new','contacted','quoted','in_progress','delivered','cancelled') DEFAULT 'new',
  assigned_to   INT UNSIGNED REFERENCES users(id),
  priority      ENUM('low','normal','high','urgent') DEFAULT 'normal',
  notes         TEXT COMMENT 'Internal admin notes',
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_status   (status),
  INDEX idx_priority (priority)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 7. MINI_GAME_ORDERS — Oyun Sifarişləri
-- ============================================================
CREATE TABLE IF NOT EXISTS mini_game_orders (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id     INT UNSIGNED,
  game_type     ENUM('spin_wheel','quiz','slot','scratch','puzzle','memory','trivia','custom') DEFAULT 'custom',
  brand_name    VARCHAR(200),
  platform      SET('web','wap','both') DEFAULT 'both',
  description   TEXT,
  prize_type    VARCHAR(200) COMMENT 'Kupon, endirim, hədiyyə...',
  budget        VARCHAR(100),
  status        ENUM('new','quoted','approved','in_dev','testing','delivered') DEFAULT 'new',
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 8. PAYMENTS — Universal Ödəniş Cədvəli
-- ============================================================
CREATE TABLE IF NOT EXISTS payments (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id      INT UNSIGNED NOT NULL,
  reference_id INT UNSIGNED NOT NULL,
  ref_type     ENUM('cv','business','game','wallet_topup') NOT NULL,
  amount       DECIMAL(12,2) NOT NULL,
  currency     CHAR(3) DEFAULT 'AZN',
  commission   DECIMAL(10,2) DEFAULT 0.00 COMMENT 'Skyweb commission amount',
  method       ENUM('card','bank_transfer','cash','crypto','payriff','balance') DEFAULT 'card',
  status       ENUM('pending','paid','refunded','failed','cancelled') DEFAULT 'pending',
  transaction_id VARCHAR(200) COMMENT 'External payment gateway ID',
  paid_at      TIMESTAMP NULL,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
  INDEX idx_ref      (reference_id, ref_type),
  INDEX idx_status   (status),
  INDEX idx_user     (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 9. MESSAGES — İstifadəçilər arası mesajlaşma
-- ============================================================
CREATE TABLE IF NOT EXISTS messages (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  sender_id  INT UNSIGNED NOT NULL,
  receiver_id INT UNSIGNED NOT NULL,
  context_id  INT UNSIGNED COMMENT 'order_id',
  context_type ENUM('business','cv','game'),
  body       TEXT NOT NULL,
  is_read    TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sender_id)   REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_receiver (receiver_id, is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 10. REVIEWS — Rəylər və Reytinqlər
-- ============================================================
CREATE TABLE IF NOT EXISTS reviews (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  reviewer_id INT UNSIGNED NOT NULL,
  reviewee_id INT UNSIGNED NOT NULL,
  rating      TINYINT(1) UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
  comment     TEXT,
  created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (reviewee_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 11. PASSWORD_RESETS — Şifrə bərpa kodları
-- ============================================================
CREATE TABLE IF NOT EXISTS password_resets (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(150) NOT NULL,
  code VARCHAR(6) NOT NULL,
  expires_at TIMESTAMP NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SEED DATA: Demo Admin İstifadəçisi
-- ============================================================
INSERT INTO users (fullname, email, password_hash, role, is_verified, is_active)
VALUES ('Skyweb Admin', 'admin@skyweb.az', '$2y$12$placeholder_bcrypt_hash', 'admin', 1, 1);

-- Demo CV Şablonları
INSERT INTO cv_templates (name, slug, category, price, is_premium) VALUES
('Sky Modern',    'sky-modern',    'modern',       0.00, 0),
('Cloud Classic', 'cloud-classic', 'classic',      0.00, 0),
('Cyber ATS',     'cyber-ats',     'ats_friendly', 2.99, 1),
('Executive Pro', 'executive-pro', 'executive',    4.99, 1),
('Creative Wave', 'creative-wave', 'creative',     3.99, 1);
