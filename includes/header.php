<?php
/**
 * Header & Navbar Global
 * Proyek: JastipBandung (HTML5 + Tailwind CSS + Lucide Icons)
 */
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/helpers.php';

$user = auth_user();
$flash = get_flash();
$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? APP_NAME . ' - ' . APP_TAGLINE) ?></title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Play CDN for Development) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#effaf6',
                            100: '#d7f3e8',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="flex flex-col min-h-full text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Top Info Bar -->
    <div class="bg-emerald-700 text-white text-xs py-1.5 px-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <span class="flex items-center gap-1.5">
                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                Jastip Bandung Asli • Pengantaran Fleksibel Langsung oleh Tim Keluarga
            </span>
            <a href="https://wa.me/<?= ADMIN_WA ?>" target="_blank" class="hover:underline flex items-center gap-1">
                <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                WA Admin: +<?= ADMIN_WA ?>
            </a>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="<?= BASE_URL ?>" class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white shadow-md shadow-emerald-200 font-bold text-xl">
                            JB
                        </div>
                        <div>
                            <span class="text-lg font-extrabold text-slate-900 tracking-tight">Jastip<span class="text-emerald-600">Bandung</span></span>
                            <span class="block text-[10px] text-slate-500 -mt-1 font-medium">Keluarga Amanah</span>
                        </div>
                    </a>

                    <!-- Desktop Nav Links -->
                    <div class="hidden md:flex items-center gap-1 ml-8">
                        <a href="<?= BASE_URL ?>" class="px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:text-emerald-600 hover:bg-slate-100 transition">
                            Beranda
                        </a>
                        <a href="<?= BASE_URL ?>#katalog" class="px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:text-emerald-600 hover:bg-slate-100 transition">
                            Katalog Oleh-Oleh
                        </a>
                        <a href="<?= BASE_URL ?>#titip-custom" class="px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:text-emerald-600 hover:bg-slate-100 transition">
                            Titip Barang Custom
                        </a>
                        <a href="<?= BASE_URL ?>#cara-kerja" class="px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:text-emerald-600 hover:bg-slate-100 transition">
                            Alur Pengantaran
                        </a>
                    </div>
                </div>

                <!-- Right Side Actions / Role Badges -->
                <div class="flex items-center gap-3">
                    <?php if ($user): ?>
                        <!-- User Role Badge -->
                        <div class="hidden sm:flex flex-col text-right">
                            <span class="text-xs font-semibold text-slate-800"><?= htmlspecialchars($user['name']) ?></span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">
                                <?php
                                    $roleLabels = [
                                        'admin' => '👑 Super Admin',
                                        'shopper' => '🛍️ Tim Belanja (Bapak)',
                                        'packer_courier' => '📦 Tim Antar (Adik)',
                                        'customer' => '🛒 Pelanggan'
                                    ];
                                    echo $roleLabels[$user['role']] ?? $user['role'];
                                ?>
                            </span>
                        </div>

                        <!-- Dashboard Shortcut based on Role -->
                        <?php if ($user['role'] === 'admin'): ?>
                            <a href="<?= BASE_URL ?>views/admin/dashboard.php" class="px-3 py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold hover:bg-slate-800 flex items-center gap-1.5 shadow-sm">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                <span class="hidden md:inline">Dashboard Admin</span>
                            </a>
                        <?php elseif ($user['role'] === 'shopper'): ?>
                            <a href="<?= BASE_URL ?>views/shopper/dashboard.php" class="px-3 py-2 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 flex items-center gap-1.5 shadow-sm">
                                <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                <span>Daftar Belanjaan</span>
                            </a>
                        <?php elseif ($user['role'] === 'packer_courier'): ?>
                            <a href="<?= BASE_URL ?>views/courier/dashboard.php" class="px-3 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 flex items-center gap-1.5 shadow-sm">
                                <i data-lucide="package-check" class="w-4 h-4"></i>
                                <span>Daftar Packing & Antar</span>
                            </a>
                        <?php endif; ?>

                        <a href="<?= BASE_URL ?>views/auth/logout.php" title="Keluar" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>views/auth/login.php" class="px-4 py-2 text-sm font-semibold text-emerald-700 hover:text-emerald-800 hover:bg-emerald-50 rounded-lg transition">
                            Masuk
                        </a>
                        <a href="<?= BASE_URL ?>views/auth/register.php" class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm shadow-emerald-200">
                            Daftar Akun
                        </a>
                    <?php endif; ?>

                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" type="button" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-4 space-y-1">
            <a href="<?= BASE_URL ?>" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-100">Beranda</a>
            <a href="<?= BASE_URL ?>#katalog" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-100">Katalog Oleh-Oleh</a>
            <a href="<?= BASE_URL ?>#titip-custom" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-100">Titip Barang Custom</a>
            <a href="<?= BASE_URL ?>#cara-kerja" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-100">Alur Pengantaran</a>
        </div>
    </nav>

    <!-- Flash Notification Banner -->
    <?php if ($flash): ?>
        <?php
            $alertMap = [
                'success' => 'bg-emerald-50 border-emerald-300 text-emerald-800',
                'danger'  => 'bg-rose-50 border-rose-300 text-rose-800',
                'warning' => 'bg-amber-50 border-amber-300 text-amber-800',
                'info'    => 'bg-blue-50 border-blue-300 text-blue-800',
            ];
            $alertClass = $alertMap[$flash['type']] ?? $alertMap['info'];
        ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="p-4 rounded-xl border <?= $alertClass ?> flex items-center justify-between text-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span><?= htmlspecialchars($flash['message']) ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-700">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content Container -->
    <main class="flex-1">
