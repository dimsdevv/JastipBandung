-- ========================================================
-- SISTEM JASTIP BANDUNG (Internal Family Delivery Workflow)
-- Database Schema: jastip_bandung
-- ========================================================

CREATE DATABASE IF NOT EXISTS `jastip_bandung` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `jastip_bandung`;

-- 1. TABEL PENGGUNA (USERS)
-- Role: admin (Saya), shopper (Bapak), packer_courier (Adik), customer (Pelanggan)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL UNIQUE,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'shopper', 'packer_courier', 'customer') NOT NULL DEFAULT 'customer',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. TABEL KATEGORI PRODUK (CATEGORIES)
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `icon` VARCHAR(50) DEFAULT 'box',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. TABEL PRODUK JASTIP (PRODUCTS)
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NULL,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(160) NOT NULL UNIQUE,
    `store_name` VARCHAR(100) NOT NULL COMMENT 'Nama Toko di Bandung: Kartika Sari, Prima Rasa, dll',
    `base_price` DECIMAL(12, 2) NOT NULL DEFAULT 0.00 COMMENT 'Harga asli toko',
    `jastip_fee` DECIMAL(12, 2) NOT NULL DEFAULT 0.00 COMMENT 'Fee jasa titip per produk',
    `image` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `is_available` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4. TABEL PESANAN (ORDERS)
-- Sistem Non-Resi (Pengantaran Fleksibel Internal: Bapak / Adik / Saya)
CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_code` VARCHAR(30) NOT NULL UNIQUE COMMENT 'Format: JB-YYYYMMDD-XXXX',
    `user_id` INT NULL COMMENT 'ID Customer jika terdaftar',
    `customer_name` VARCHAR(100) NOT NULL,
    `customer_phone` VARCHAR(20) NOT NULL,
    `delivery_method` ENUM('delivery_address', 'cod_meeting_point') NOT NULL DEFAULT 'delivery_address',
    `delivery_address` TEXT NOT NULL COMMENT 'Alamat lengkap atau deskripsi titik kumpul COD',
    `delivery_notes` TEXT NULL COMMENT 'Patokan lokasi atau jam pengantaran yang diinginkan',
    `total_item_price` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    `total_jastip_fee` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    `delivery_fee` DECIMAL(12, 2) NOT NULL DEFAULT 0.00 COMMENT 'Ongkir antar internal jika ada',
    `total_amount` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    `payment_status` ENUM('pending', 'paid_dp', 'paid_full', 'cancelled') NOT NULL DEFAULT 'pending',
    `payment_proof` VARCHAR(255) NULL,
    `order_status` ENUM('pending', 'confirmed', 'shopping', 'packed', 'delivering', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    `assigned_courier_id` INT NULL COMMENT 'User ID internal yang mengantar (Bapak/Adik/Saya)',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`assigned_courier_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 5. TABEL ITEM PESANAN (ORDER_ITEMS)
CREATE TABLE IF NOT EXISTS `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NULL COMMENT 'Null jika pesanan request barang khusus',
    `item_name` VARCHAR(150) NOT NULL,
    `store_name` VARCHAR(100) NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `price_per_item` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    `jastip_fee_per_item` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    `notes` TEXT NULL COMMENT 'Catatan varian, rasa, atau instruksi khusus dari customer',
    `item_status` ENUM('pending', 'bought', 'out_of_stock', 'substituted') NOT NULL DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 6. TABEL LOG RIWAYAT STATUS PESANAN (ORDER_LOGS)
CREATE TABLE IF NOT EXISTS `order_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `notes` VARCHAR(255) NULL,
    `created_by` INT NULL COMMENT 'User ID internal yang mengupdate status',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ========================================================
-- DATA SEED AWAL (DEFAULT ACCOUNTS & CATEGORIES)
-- Password default: password123 (Hash bcrypt)
-- ========================================================

-- Akun 3 Orang Tim Operasional & 1 Contoh Pelanggan
INSERT INTO `users` (`name`, `phone`, `username`, `password`, `role`) VALUES
('Super Admin (Saya)', '081234567890', 'admin', '$2y$10$4B9Yl9E8q4J6f4uU.40.4O2d4U4lK9aB1Z6w.M1n8J6.2n0V9Xm9G', 'admin'),
('Bapak (Shopper Lapangan)', '081234567891', 'bapak', '$2y$10$4B9Yl9E8q4J6f4uU.40.4O2d4U4lK9aB1Z6w.M1n8J6.2n0V9Xm9G', 'shopper'),
('Adik (Packing & Delivery)', '081234567892', 'adik', '$2y$10$4B9Yl9E8q4J6f4uU.40.4O2d4U4lK9aB1Z6w.M1n8J6.2n0V9Xm9G', 'packer_courier'),
('Budi (Customer)', '081234567893', 'customer', '$2y$10$4B9Yl9E8q4J6f4uU.40.4O2d4U4lK9aB1Z6w.M1n8J6.2n0V9Xm9G', 'customer')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Kategori Populer Jastip Bandung
INSERT INTO `categories` (`name`, `slug`, `icon`) VALUES
('Kue & Pastry', 'kue-pastry', 'cake'),
('Camilan & Makanan Khas', 'camilan-khas', 'cookie'),
('Kopi & Minuman', 'kopi-minuman', 'coffee'),
('Fashion & Distro', 'fashion-distro', 'shirt'),
('Titip Custom Khusus', 'titip-custom', 'sparkles')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Contoh Produk Populer Awal
INSERT INTO `products` (`category_id`, `name`, `slug`, `store_name`, `base_price`, `jastip_fee`, `description`) VALUES
(1, 'Bolu Susu Lembang Original', 'bolu-susu-lembang-original', 'Bolu Susu Lembang', 38000.00, 10000.00, 'Bolu lembut dengan aroma susu khas Lembang rasa original keju.'),
(1, 'Brownies Panggang Prima Rasa', 'brownies-panggang-prima-rasa', 'Prima Rasa Bandung', 85000.00, 15000.00, 'Brownies panggang renyah di luar lembut di dalam.'),
(1, 'Pisang Bollen Kartika Sari Keju', 'pisang-bollen-kartika-sari-keju', 'Kartika Sari', 75000.00, 15000.00, 'Pastry bollen isi pisang dan keju gurih khas Kartika Sari.'),
(2, 'Batagor Kingsley Kuah/Goreng (Isi 5)', 'batagor-kingsley-isi-5', 'Batagor Kingsley', 80000.00, 15000.00, 'Batagor ikan tenggiri legendaris Bandung lengkap dengan bumbu kacang.')
ON DUPLICATE KEY UPDATE `name`=`name`;
