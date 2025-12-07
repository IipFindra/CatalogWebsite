-- SQL Schema for Catalogue Database
-- Database: catalogue_db

-- Disable foreign key checks for dropping tables
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `product_images`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `contacts`;
SET FOREIGN_KEY_CHECKS = 1;

-- Categories Table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT,
  `parent_id` INT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_slug` (`slug`),
  KEY `idx_parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products Table
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `short_description` VARCHAR(512),
  `description` TEXT,
  `price` DECIMAL(10,2) NOT NULL,
  `sku` VARCHAR(100) UNIQUE,
  `status` VARCHAR(50) DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category_id`),
  KEY `idx_slug` (`slug`),
  KEY `idx_status` (`status`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Product Images Table
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `image_url` VARCHAR(1024) NOT NULL,
  `alt_text` VARCHAR(255),
  `is_primary` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_product` (`product_id`),
  KEY `idx_primary` (`is_primary`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contacts Table
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255),
  `message` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(50) DEFAULT 'new',
  `ip_address` VARCHAR(45),
  `user_agent` VARCHAR(255),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories Data (From Screenshot)
INSERT INTO `categories` (`id`, `name`, `slug`, `description`) VALUES
(2, 'Alat Tulis & Perlengkapan', 'alat-tulis-perlengkapan', 'Kategori alat tulis dan perlengkapan sekolah/kantor');

-- Products Data (From Screenshot)
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `short_description`, `description`, `price`, `status`, `created_at`, `updated_at`) VALUES
(12, 2, 'Correction Tape Warna Pastel', 'correction-tape-warna-pastel', 'Correction tape warna pastel', NULL, 7000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(13, 2, 'Bolpoin Karakter Lucu', 'bolpoin-karakter-lucu', 'Bolpoin karakter lucu', NULL, 5000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(14, 2, 'Map Folder Dokumen A4', 'map-folder-dokumen-a4', 'Folder dokumen ukuran A4', NULL, 20000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(15, 2, 'Set 12 Highlighter Warna Pastel', 'set-12-highlighter-warna-pastel', 'Set 12 highlighter pastel', NULL, 15000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(16, 2, 'Notebook Karakter A5', 'notebook-karakter-a5', 'Notebook ukuran A5 dengan karakter lucu', NULL, 5000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(17, 2, 'Set 6 Sticky Notes Karakter Lucu', 'set-6-sticky-notes-karakter-lucu', 'Sticky notes karakter lucu isi 6', NULL, 7000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(18, 2, 'Paper Clips Warna Pastel', 'paper-clips-warna-pastel', 'Klip kertas warna pastel', NULL, 5000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(19, 2, 'Set 4 Penggaris Bening', 'set-4-penggaris-bening', 'Set 4 penggaris bening', NULL, 20000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(20, 2, 'Stapler Mini', 'stapler-mini', 'Stapler ukuran mini', NULL, 10000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25'),
(21, 2, 'Gunting Warna Pastel Aesthetic', 'gunting-warna-pastel-aesthetic', 'Gunting warna pastel aesthetic', NULL, 7000.00, 'published', '2025-12-06 09:24:25', '2025-12-06 09:24:25');

-- Product Images Data (From Screenshot)
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`) VALUES
(2, 12, 'uploads/products/tape.jpeg', 1),
(3, 13, 'uploads/products/bolpoin.jpeg', 1),
(4, 14, 'uploads/products/mapfolder.jpeg', 1),
(7, 15, 'uploads/products/highlighter.jpeg', 1),
(8, 16, 'uploads/products/notebook.jpeg', 1),
(9, 17, 'uploads/products/stickynotes.jpeg', 1),
(10, 18, 'uploads/products/paperclips.jpeg', 1),
(11, 19, 'uploads/products/penggaris.jpeg', 1),
(12, 20, 'uploads/products/staplermini.jpeg', 1),
(13, 21, 'uploads/products/gunting.jpeg', 1);
