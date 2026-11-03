<?php
/**
 * Middleware Sederhana: Proteksi Hak Akses & Peran (Role Guard)
 * Proyek: JastipBandung
 */

require_once __DIR__ . '/../config/helpers.php';

/**
 * Pastikan pengguna sudah login dan memiliki salah satu dari peran yang diizinkan
 * @param array|string $allowedRoles Contoh: ['admin'] atau ['admin', 'shopper']
 */
function require_role($allowedRoles) {
    if (!is_array($allowedRoles)) {
        $allowedRoles = [$allowedRoles];
    }

    if (!auth_check()) {
        set_flash('warning', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        redirect('views/auth/login.php');
    }

    $currentRole = auth_role();
    if (!in_array($currentRole, $allowedRoles)) {
        set_flash('danger', 'Akses ditolak! Anda tidak memiliki izin untuk membuka halaman tersebut.');
        
        // Arahkan sesuai peran masing-masing
        if ($currentRole === 'admin') {
            redirect('views/admin/dashboard.php');
        } elseif ($currentRole === 'shopper') {
            redirect('views/shopper/dashboard.php');
        } elseif ($currentRole === 'packer_courier') {
            redirect('views/courier/dashboard.php');
        } else {
            redirect('index.php');
        }
    }
}
