# PRODUCT REQUIREMENT DOCUMENT (PRD)
## JastipBandung — Sistem Operasional Jasa Titip Keluarga Terpadu

| Dokumen | Deskripsi |
| :--- | :--- |
| **Nama Proyek** | JastipBandung |
| **Versi Dokumen** | 1.0.0 |
| **Tanggal Pembuatan** | 4 November 2026 |
| **Status** | Approved & Ready for Implementation |
| **Pemilik Produk** | Saya (Owner & Super Admin) |
| **Target Rilis** | MVP (Minimum Viable Product) |

---

## 1. Executive Summary & Latar Belakang

### 1.1 Latar Belakang
Kota Bandung terkenal dengan aneka kuliner legendaris (seperti Kartika Sari, Prima Rasa, Bolu Susu Lembang, Batagor Kingsley) serta fashion distro yang memiliki basis konsumen loyal di luar kota. Namun, banyak pelanggan enggan memesan melalui marketplace besar karena ongkir ekspedisi mahal, makanan mudah hancur/basi jika tertahan di gudang kurir ekspedisi, serta minimnya sentuhan personal dalam memilih barang titipan yang masih *fresh*.

Bisnis **JastipBandung** ini beroperasi secara mandiri oleh tim internal keluarga (3 orang: Saya, Bapak, dan Adik). Model operasionalnya menggunakan pendekatan **"Zero-Resi & Internal Direct Delivery"**, di mana barang dibelanjakan langsung di gerai resmi Bandung dan diantar secara fleksibel menggunakan kendaraan keluarga (antar langsung / COD / titik kumpul) tanpa perantara pihak ketiga.

### 1.2 Masalah yang Dihadapi (Problem Statements)
1. **Pencatatan Manual Rawan Tercecer:** Pesanan titipan yang masuk via chat WhatsApp sering kali tercecer varian rasanya atau lupa dibeli.
2. **Kekacauan Belanja di Toko:** Bapak di lapangan membutuhkan daftar belanjaan yang sudah terkonsolidasi (misal: total harus beli 10 box Bolu Susu Lembang) bukan membaca chat satu per satu pembeli.
3. **Salah Sortir & Packing:** Adik kesulitan membedakan belanjaan milik Customer A dan Customer B sebelum dibungkus.
4. **Kekhawatiran Pelanggan (Status Pesanan):** Karena tidak menggunakan nomor resi ekspedisi (JNE/J&T), pelanggan membutuhkan transparansi status barang mereka secara real-time.

### 1.3 Solusi yang Ditawarkan (Value Proposition)
Membangun web aplikasi operasional terpadu yang:
* Mengotomatisasi rekonsiliasi belanjaan ke dalam **Daftar Belanjaan Terpadu (*Consolidated Shopping List*)** untuk Bapak.
* Menyediakan **Checklist Packing Interaktif** untuk Adik sebelum barang diantar.
* Menyediakan **Tracking Status Real-time Non-Resi** bagi pelanggan (dari belanja, packing, meluncur antar, hingga diterima).
* Memberikan dashboard rekonsiliasi keuangan & fee jastip untuk Saya (Admin).

---

## 2. Profil Pengguna & Persona (Target Users)

Sistem dirancang khusus untuk 4 jenis aktor:

### 👤 Persona 1: Saya (Super Admin / Owner)
* **Karakteristik:** Mengoperasikan laptop/PC dan HP.
* **Tugas Pokok:** Manajemen katalog, verifikasi pembayaran, penugasan belanja/antar, laporan keuangan, dan fee jastip.
* **Tujuan Utama:** Mengetahui seluruh arus pesanan, memastikan tidak ada order yang macet, serta memantau margin keuntungan harian.

### 🛍️ Persona 2: Bapak (Shopper / Lapangan)
* **Karakteristik:** Menggunakan HP di lapangan (toko oleh-oleh, jalanan, parkiran). Memerlukan tampilan yang sangat sederhana, tombol besar, dan cepat dibuka.
* **Tugas Pokok:** Membeli barang di toko-toko Bandung dan mengantarkan pesanan rute jauh.
* **Tujuan Utama:** Melihat total barang yang harus dibeli per toko tanpa membuka banyak catatan. Langsung klik centang begitu barang masuk keranjang belanja fisik.

### 📦 Persona 3: Adik (Packer & Courier)
* **Karakteristik:** Menggunakan HP di rumah/posko sortir dan saat berkendara antar barang rute dekat.
* **Tugas Pokok:** Menyortir belanjaan per nama pembeli, membungkus paket rapi, dan mengantar langsung ke alamat pelanggan / titik COD.
* **Tujuan Utama:** Memastikan tidak ada barang tertukar atau tertinggal dalam paket, serta mudah menghubungi WhatsApp pelanggan saat sampai di lokasi.

### 🛒 Persona 4: Customer (Pelanggan Jastip)
* **Karakteristik:** Pecinta kuliner/barang Bandung, mengakses via browser HP.
* **Tugas Pokok:** Memilih barang di katalog atau request titip custom, menentukan alamat/titik COD, membayar, dan memantau pesanan.
* **Tujuan Utama:** Barang sampai dalam kondisi segar (*fresh*), harga transparan, dan tahu persis kapan barang sedang dibelanjakan serta diantar.

---

## 3. Cakupan Produk (Scope of Product)

### 3.1 In-Scope (Fitur yang Dibangun)
* ✅ Katalog produk rekomendasi oleh-oleh Bandung (nama toko, harga asli, fee jastip transparan).
* ✅ Formulir "Titip Barang Custom" untuk barang yang belum terdaftar di katalog.
* ✅ Keranjang belanja & formulir pemesanan (pilihan: Diantar ke Alamat atau Titik Temu COD).
* ✅ Pelacakan status transparan 6 tahap tanpa memerlukan nomor resi ekspedisi.
* ✅ Integrasi aksi langsung ke WhatsApp (chat konfirmasi & chat saat kurir tiba).
* ✅ Dashboard Belanjaan Terpadu (*Consolidated Shopping List*) untuk Bapak.
* ✅ Dashboard Checklist Sortir & Packing untuk Adik.
* ✅ Penugasan kurir internal (Bisa ditugaskan ke Bapak, Adik, atau Saya).
* ✅ Rekapitulasi keuangan: total modal belanja, total fee jastip, dan kas masuk.

### 3.2 Out-of-Scope (Bukan Bagian dari Sistem)
* ❌ Integrasi API kurir ekspedisi pihak ketiga (JNE, J&T, SiCepat, dll).
* ❌ Pembuatan / input nomor resi pengiriman manual (karena diantar internal).
* ❌ Payment Gateway otomatis berbayar (Midtrans/Xendit) — pembayaran menggunakan transfer bank / e-wallet manual dengan upload bukti transfer demi efisiensi biaya awal.

---

## 4. Alur Kerja & Spesifikasi Fungsional Produk

### 4.1 Siklus Hidup Pesanan (Order Lifecycle)
```
[1. PENDING] ➡️ Pelanggan submit pesanan, menunggu konfirmasi Admin & transfer DP/Lunas.
     ⬇
[2. CONFIRMED] ➡️ Admin verifikasi pembayaran, pesanan masuk jadwal belanja.
     ⬇
[3. SHOPPING] ➡️ Otomatis masuk ke "Daftar Belanjaan Bapak", Bapak membelanjakan di toko.
     ⬇
[4. PACKED] ➡️ Barang tiba di posko, Adik melakukan checklist sortir dan membungkus pesanan.
     ⬇
[5. DELIVERING] ➡️ Tim yang ditugaskan (Bapak/Adik/Saya) membawa paket meluncur ke pelanggan.
     ⬇
[6. COMPLETED] ➡️ Paket diserahkan ke pelanggan, status dikonfirmasi selesai.
```

### 4.2 Matriks Hak Akses Modul Sistem

| Modul Fitur | Pelanggan | Bapak (Shopper) | Adik (Packer/Courier) | Saya (Admin) |
| :--- | :---: | :---: | :---: | :---: |
| Lihat Katalog & Request Titip | ✅ | ✅ | ✅ | ✅ |
| Checkout & Pantau Tracking | ✅ | ❌ | ❌ | ✅ |
| Shopping List Terpadu | ❌ | ✅ | ❌ | ✅ |
| Tandai Barang "Sudah Dibeli" | ❌ | ✅ | ❌ | ✅ |
| Checklist Sortir & Packing | ❌ | ❌ | ✅ | ✅ |
| Daftar Rute Antar & Buka WA Pelanggan | ❌ | ✅ (Rute Bapak) | ✅ (Rute Adik) | ✅ (Semua Rute) |
| Konfirmasi Paket Diterima | ❌ | ✅ | ✅ | ✅ |
| Kelola Produk & Kategori | ❌ | ❌ | ❌ | ✅ |
| Verifikasi Pembayaran | ❌ | ❌ | ❌ | ✅ |
| Rekap Keuangan & Margin Fee | ❌ | ❌ | ❌ | ✅ |

---

## 5. Kebutuhan Non-Fungsional (Non-Functional Requirements)

1. **Mobile-First Responsiveness:** Karena Bapak dan Adik akan menggunakan HP di perjalanan dan toko, antarmuka wajib ringan, tombol berjarak aman dari salah sentuh (*fat-finger friendly*), dan tidak lemot saat sinyal 4G lemah.
2. **Kinerja & Kecepatan:** Dibangun dengan **PHP Native Murni** dan **Tailwind CSS** tanpa beban framework berat, menjamin waktu render halaman di bawah 1 detik di localhost maupun hosting.
3. **Reliabilitas Data:** Menggunakan mekanisme transaksi database (PDO Transactions) agar jika terjadi kendala saat checkout, data item dan pesanan tidak menjadi *corrupt*.
4. **Kemudahan Operasional:** Tautan WhatsApp otomatis terisi teks dinamis (*pre-filled message*) untuk mempermudah komunikasi instan antar keluarga dan pelanggan.

---

## 6. Metrik Keberhasilan (KPI & Metrics)
* **Zero Missed Items:** 0% barang belanjaan yang tertinggal saat belanja di toko Bandung.
* **Packing Accuracy:** 100% pesanan terbungkus sesuai varian rasa dan jumlah pesanan customer.
* **Kecepatan Komunikasi:** Pelanggan mendapatkan update status pengantaran tanpa perlu bertanya berulang kali via WhatsApp.
* **Transparansi Margin:** Admin dapat melihat keuntungan bersih fee jastip harian secara otomatis dalam 1 kali klik.
