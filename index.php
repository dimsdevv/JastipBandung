<?php
/**
 * Landing Page & Katalog Produk
 * Proyek: JastipBandung
 */
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/helpers.php';

// Coba ambil produk dari database jika tabel sudah ada
$products = [];
$categories = [];
$dbConnected = false;

try {
    require_once __DIR__ . '/config/database.php';
    if (isset($pdo)) {
        $dbConnected = true;
        // Ambil kategori
        $catStmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
        $categories = $catStmt->fetchAll();

        // Ambil produk
        $prodStmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.is_available = 1 ORDER BY p.id ASC");
        $products = $prodStmt->fetchAll();
    }
} catch (Exception $e) {
    // Database belum diimport, gunakan fallback demo
    $dbConnected = false;
}

// Fallback jika belum import database
if (empty($products)) {
    $products = [
        [
            'id' => 1,
            'name' => 'Bolu Susu Lembang Original',
            'store_name' => 'Bolu Susu Lembang',
            'base_price' => 38000,
            'jastip_fee' => 10000,
            'description' => 'Bolu lembut dengan aroma susu khas Lembang rasa original keju gurih.',
            'category_name' => 'Kue & Pastry'
        ],
        [
            'id' => 2,
            'name' => 'Brownies Panggang Prima Rasa',
            'store_name' => 'Prima Rasa Bandung',
            'base_price' => 85000,
            'jastip_fee' => 15000,
            'description' => 'Brownies panggang legit renyah di luar lembut di dalam khas Bandung.',
            'category_name' => 'Kue & Pastry'
        ],
        [
            'id' => 3,
            'name' => 'Pisang Bollen Kartika Sari Keju',
            'store_name' => 'Kartika Sari',
            'base_price' => 75000,
            'jastip_fee' => 15000,
            'description' => 'Pastry legendaris isi pisang raja manis dan keju melimpah.',
            'category_name' => 'Kue & Pastry'
        ],
        [
            'id' => 4,
            'name' => 'Batagor Kingsley Kuah/Goreng (Isi 5)',
            'store_name' => 'Batagor Kingsley',
            'base_price' => 80000,
            'jastip_fee' => 15000,
            'description' => 'Batagor ikan tenggiri asli Bandung lengkap dengan bumbu kacang istimewa.',
            'category_name' => 'Camilan & Makanan Khas'
        ]
    ];
}

$pageTitle = APP_NAME . " - Titip Oleh-Oleh Bandung Asli";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-emerald-50/70 via-white to-slate-50 py-16 sm:py-24 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Floating Tag -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-6 border border-emerald-200 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Layanan Jastip Keluarga Terpercaya • Pengantaran Fleksibel
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight max-w-4xl mx-auto leading-tight">
            Kangen Oleh-Oleh Bandung? <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Biar Kami Belanjakan & Antar Langsung!</span>
        </h1>

        <p class="mt-6 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Dari Kartika Sari, Prima Rasa, hingga jajanan pasar favorit Anda. Dikelola mandiri oleh tim keluarga kami dengan pengantaran langsung tanpa kurir ekspedisi.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="#katalog" class="px-6 py-3.5 rounded-xl bg-emerald-600 text-white font-bold text-sm hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition flex items-center gap-2">
                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                Lihat Katalog Oleh-Oleh
            </a>
            <a href="#titip-custom" class="px-6 py-3.5 rounded-xl bg-white text-slate-800 border border-slate-300 font-bold text-sm hover:bg-slate-50 transition flex items-center gap-2 shadow-sm">
                <i data-lucide="sparkles" class="w-4 h-4 text-emerald-600"></i>
                Punya Titipan Khusus? Request Di Sini
            </a>
        </div>

        <!-- Trust Badges -->
        <div class="mt-12 pt-8 border-t border-slate-200/60 grid grid-cols-2 sm:grid-cols-3 gap-4 max-w-2xl mx-auto text-xs text-slate-600">
            <div class="flex items-center justify-center gap-2 font-medium">
                <i data-lucide="badge-check" class="w-4 h-4 text-emerald-600"></i>
                100% Asli dari Toko Resmi
            </div>
            <div class="flex items-center justify-center gap-2 font-medium">
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                Tanpa Resi • Antar Sendiri
            </div>
            <div class="col-span-2 sm:col-span-1 flex items-center justify-center gap-2 font-medium">
                <i data-lucide="heart-handshake" class="w-4 h-4 text-emerald-600"></i>
                Amanah Tim Keluarga
            </div>
        </div>
    </div>
</section>

<!-- Cara Kerja Alur Jastip (Tanpa Resi) -->
<section id="cara-kerja" class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Alur Sederhana</h2>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Bagaimana Cara Jastip di Sini?</h3>
            <p class="text-slate-500 text-sm mt-2">Tidak perlu repot mengecek nomor resi ekspedisi. Kami antar langsung dengan rute terkoordinasi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 relative group hover:border-emerald-300 hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-lg mb-4 shadow-md shadow-emerald-200">
                    1
                </div>
                <h4 class="font-bold text-slate-900 text-base mb-2">Pilih / Request Titipan</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pilih barang dari katalog atau ajukan request khusus (nama barang, toko, dan foto referensi). Tentukan titik antar / COD.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 relative group hover:border-emerald-300 hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-lg mb-4 shadow-md shadow-emerald-200">
                    2
                </div>
                <h4 class="font-bold text-slate-900 text-base mb-2">Tim Belanja di Bandung</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Bapak dan tim kami langsung menuju gerai resmi di Bandung untuk membelikan barang pesanan yang masih segar (*fresh*).
                </p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 relative group hover:border-emerald-300 hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-lg mb-4 shadow-md shadow-emerald-200">
                    3
                </div>
                <h4 class="font-bold text-slate-900 text-base mb-2">Dipacking & Diantar Langsung</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pesanan dipacking rapi oleh Adik dan diantar langsung ke alamat atau titik temu Anda dengan komunikasi ramah via WhatsApp.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Katalog Produk Populer -->
<section id="katalog" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <h2 class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Katalog Rekomendasi</h2>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Oleh-Oleh Favorit Bandung</h3>
                <p class="text-slate-500 text-sm mt-1">Harga barang asli toko + fee jastip transparan.</p>
            </div>
            
            <a href="https://wa.me/<?= ADMIN_WA ?>?text=Halo%20Admin%20JastipBandung,%20saya%20mau%20titip%20oleh-oleh" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-100 transition shadow-sm">
                <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600"></i>
                Tanya Ketersediaan Toko
            </a>
        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($products as $item): ?>
                <?php $totalItemPrice = $item['base_price'] + $item['jastip_fee']; ?>
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between">
                    <div>
                        <!-- Store Badge Header -->
                        <div class="p-4 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between text-xs">
                            <span class="inline-flex items-center gap-1 font-semibold text-emerald-700">
                                <i data-lucide="store" class="w-3.5 h-3.5"></i>
                                <?= htmlspecialchars($item['store_name']) ?>
                            </span>
                            <span class="text-[11px] text-slate-400 font-medium">
                                <?= htmlspecialchars($item['category_name'] ?? 'Kue') ?>
                            </span>
                        </div>

                        <!-- Info Card -->
                        <div class="p-5">
                            <h4 class="font-bold text-slate-900 text-base leading-snug hover:text-emerald-600 transition">
                                <?= htmlspecialchars($item['name']) ?>
                            </h4>
                            <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                <?= htmlspecialchars($item['description'] ?? 'Produk segar langsung dari Bandung.') ?>
                            </p>

                            <!-- Breakdown Harga -->
                            <div class="mt-4 pt-4 border-t border-slate-100 space-y-1 text-xs">
                                <div class="flex justify-between text-slate-500">
                                    <span>Harga Asli:</span>
                                    <span><?= format_rupiah($item['base_price']) ?></span>
                                </div>
                                <div class="flex justify-between text-slate-500">
                                    <span>Fee Jastip:</span>
                                    <span class="text-emerald-600 font-semibold">+ <?= format_rupiah($item['jastip_fee']) ?></span>
                                </div>
                                <div class="flex justify-between text-slate-900 font-extrabold text-sm pt-1 border-t border-dashed border-slate-200">
                                    <span>Total:</span>
                                    <span class="text-emerald-700"><?= format_rupiah($totalItemPrice) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="p-5 pt-0">
                        <a href="https://wa.me/<?= ADMIN_WA ?>?text=Halo%20Admin,%20saya%20mau%20titip%20pesan%20*<?= urlencode($item['name']) ?>*%20dari%20*<?= urlencode($item['store_name']) ?>*." target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-emerald-50 text-emerald-700 font-bold text-xs hover:bg-emerald-600 hover:text-white transition flex items-center justify-center gap-1.5 border border-emerald-200">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            Titip Beli Barang Ini
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Form Titip Barang Custom -->
<section id="titip-custom" class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-8 sm:p-12 text-white shadow-xl">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-semibold mb-4 backdrop-blur-sm">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    Request Barang Bebas
                </span>
                <h3 class="text-3xl font-extrabold tracking-tight">Mau Titip Barang Lain yang Tidak Ada di Katalog?</h3>
                <p class="mt-3 text-sm text-emerald-100 leading-relaxed">
                    Punya langganan kue basah, distro clothing, obat, atau jajanan pasar khusus di sudut kota Bandung? Tuliskan saja, Bapak & tim kami siap carikan ke tokonya langsung!
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="https://wa.me/<?= ADMIN_WA ?>?text=Halo%20Admin%20JastipBandung,%20saya%20mau%20request%20titip%20barang%20khusus:" target="_blank" class="px-6 py-3.5 rounded-xl bg-white text-emerald-800 font-bold text-sm hover:bg-emerald-50 shadow-md transition flex items-center gap-2">
                        <i data-lucide="message-square" class="w-4 h-4 text-emerald-600"></i>
                        Chat Request Titip via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
