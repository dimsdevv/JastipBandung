<?php
/**
 * Kumpulan Fungsi Pembantu (Helper Utilities)
 * Proyek: JastipBandung
 */

require_once __DIR__ . '/app.php';

/**
 * Format angka ke format Rupiah (contoh: Rp 50.000)
 */
function format_rupiah($number) {
    return 'Rp ' . number_format((float)$number, 0, ',', '.');
}

/**
 * Format tanggal Indonesia
 */
function format_tanggal_indo($dateStr) {
    if (!$dateStr) return '-';
    $bulanIndo = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $timestamp = strtotime($dateStr);
    $tgl = date('d', $timestamp);
    $bln = (int)date('m', $timestamp);
    $thn = date('Y', $timestamp);
    $jam = date('H:i', $timestamp);
    return "{$tgl} {$bulanIndo[$bln]} {$thn}, {$jam} WIB";
}

/**
 * Cek apakah user sedang login
 */
function auth_check() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Ambil data user yang sedang login
 */
function auth_user() {
    if (!auth_check()) return null;
    return [
        'id'       => $_SESSION['user_id'] ?? null,
        'name'     => $_SESSION['user_name'] ?? 'User',
        'role'     => $_SESSION['user_role'] ?? 'customer',
        'username' => $_SESSION['user_username'] ?? '',
        'phone'    => $_SESSION['user_phone'] ?? ''
    ];
}

/**
 * Ambil role user login
 */
function auth_role() {
    return $_SESSION['user_role'] ?? 'guest';
}

/**
 * Redirect ke URL tertentu
 */
function redirect($path) {
    $url = (strpos($path, 'http') === 0) ? $path : BASE_URL . ltrim($path, '/');
    header("Location: {$url}");
    exit;
}

/**
 * Set flash message (success, error, info)
 */
function set_flash($type, $message) {
    $_SESSION['flash'] = [
        'type'    => $type, // 'success', 'danger', 'warning', 'info'
        'message' => $message
    ];
}

/**
 * Ambil & bersihkan flash message
 */
function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Render Badge Status Pesanan (Tailwind CSS)
 */
function render_status_badge($status) {
    $map = [
        'pending'    => ['bg' => 'bg-amber-100 text-amber-800 border-amber-300', 'label' => '⏳ Menunggu Konfirmasi'],
        'confirmed'  => ['bg' => 'bg-blue-100 text-blue-800 border-blue-300', 'label' => '📝 Dijadwalkan Belanja'],
        'shopping'   => ['bg' => 'bg-purple-100 text-purple-800 border-purple-300', 'label' => '🛒 Sedang Dibelanjakan'],
        'packed'     => ['bg' => 'bg-indigo-100 text-indigo-800 border-indigo-300', 'label' => '📦 Siap Diantar'],
        'delivering' => ['bg' => 'bg-orange-100 text-orange-800 border-orange-300', 'label' => '🛵 Sedang Diantar'],
        'completed'  => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-300', 'label' => '✅ Selesai'],
        'cancelled'  => ['bg' => 'bg-rose-100 text-rose-800 border-rose-300', 'label' => '❌ Dibatalkan'],
    ];

    $cfg = $map[$status] ?? ['bg' => 'bg-slate-100 text-slate-800 border-slate-300', 'label' => ucfirst($status)];
    return "<span class=\"inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {$cfg['bg']}\">{$cfg['label']}</span>";
}
