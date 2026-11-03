<?php
/**
 * Footer Global
 * Proyek: JastipBandung
 */
?>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 mt-20 border-t border-slate-800 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Info Bisnis -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold">
                            JB
                        </div>
                        <span class="text-white font-bold text-lg">Jastip<span class="text-emerald-500">Bandung</span></span>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                        Layanan jasa titip oleh-oleh dan produk khas Bandung yang dikelola dengan amanah oleh tim keluarga. Belanja langsung di toko resmi Bandung, pengantaran mandiri yang fleksibel dan terjamin keasliannya.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-slate-300">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                        <span>Tanpa Pihak Ketiga • Pengantaran Langsung oleh Tim Internal</span>
                    </div>
                </div>

                <!-- Toko Partner Populer -->
                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-3">Toko Populer Bandung</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#" class="hover:text-white transition">Kartika Sari</a></li>
                        <li><a href="#" class="hover:text-white transition">Prima Rasa</a></li>
                        <li><a href="#" class="hover:text-white transition">Bolu Susu Lembang</a></li>
                        <li><a href="#" class="hover:text-white transition">Batagor Kingsley</a></li>
                        <li><a href="#" class="hover:text-white transition">Brownies Amanda</a></li>
                    </ul>
                </div>

                <!-- Kontak Tim Keluarga -->
                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-3">Kontak Langsung</h4>
                    <ul class="space-y-2 text-xs">
                        <li class="flex items-center gap-2">
                            <i data-lucide="phone" class="w-4 h-4 text-emerald-400"></i>
                            <a href="https://wa.me/<?= ADMIN_WA ?>" target="_blank" class="hover:text-white transition">+<?= ADMIN_WA ?> (WhatsApp)</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-emerald-400"></i>
                            <span>Bandung, Jawa Barat</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 mt-8 border-t border-slate-800 text-center text-xs text-slate-500">
                <p>&copy; <?= date('Y') ?> JastipBandung. Dibangun dengan cinta untuk kemudahan belanja oleh-oleh Bandung.</p>
            </div>
        </div>
    </footer>

    <!-- Init Lucide Icons & Simple Interactions -->
    <script>
        lucide.createIcons();

        // Mobile Menu Toggle
        const menuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
</body>
</html>
