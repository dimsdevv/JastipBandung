<?php
/**
 * Konfigurasi Aplikasi & Konstanta Global
 * Proyek: JastipBandung
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Menentukan Base URL secara dinamis
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$basePath = preg_replace('#/(views|admin|shopper|courier|config).*$#', '', $scriptDir);
$baseUrl = rtrim($protocol . $host . $basePath, '/') . '/';

define('BASE_URL', $baseUrl);
define('APP_NAME', 'JastipBandung');
define('APP_TAGLINE', 'Oleh-Oleh & Titip Belanja Khas Bandung');
define('ADMIN_WA', '6281234567890'); // No WA Admin Utama untuk order/konfirmasi
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
