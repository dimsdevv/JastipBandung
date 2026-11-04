# SOFTWARE REQUIREMENTS SPECIFICATION (SRS)
## Sistem Informasi Operasional JastipBandung
*Standard Reference: IEEE Std 830-1998 Format Adaptif*

| Atribut Dokumen | Rincian |
| :--- | :--- |
| **Nama Sistem** | Sistem Operasional JastipBandung |
| **Versi** | 1.0.0 |
| **Status** | Final Spesifikasi |
| **Lingkungan Basis** | PHP Native (PDO MySQL) + HTML5 + Tailwind CSS + Vanilla JS |
| **Tanggal Terbit** | 4 November 2026 |

---

## 1. PENDAHULUAN (INTRODUCTION)

### 1.1 Tujuan Dokumen
Tujuan dari dokumen *Software Requirements Specification* (SRS) ini adalah menjabarkan seluruh kebutuhan fungsional dan non-fungsional dari **Sistem Informasi Operasional JastipBandung**. Dokumen ini menjadi acuan tunggal dalam perancangan arsitektur, basis data, implementasi kode program, serta pengujian sistem.

### 1.2 Konvensi Dokumen
Setiap kebutuhan fungsional diberi kode unik dengan format:
* `FR-[Kategori]-[Nomor]` (Functional Requirement)
* `NFR-[Kategori]-[Nomor]` (Non-Functional Requirement)
* Prioritas kebutuhan: `[Tinggi]` (Wajib MVP), `[Sedang]` (Penting), `[Rendah]` (Opsional).

### 1.3 Audiens yang Dituju
1. **Developer:** Sebagai panduan implementasi kode modular, query database, dan logika hak akses.
2. **Product Owner (Saya):** Sebagai tolak ukur verifikasi fitur yang selesai dikembangkan.
3. **Pengguna Internal (Bapak & Adik):** Sebagai acuan SOP teknis penggunaan aplikasi di lapangan.

---

## 2. DESKRIPSI KESELURUHAN (OVERALL DESCRIPTION)

### 2.1 Perspektif Produk
Sistem JastipBandung adalah aplikasi web terintegrasi yang beroperasi mandiri di lingkungan web server Apache (XAMPP). Sistem ini menjembatani transaksi antara pelanggan yang ingin menitip oleh-oleh/barang khas Bandung dengan tim operasional keluarga yang berbelanja langsung di toko fisik serta melakukan pengantaran mandiri tanpa kurir pihak ketiga.

### 2.2 Arsitektur Sistem Tingkat Tinggi
```
[Browser Client (Desktop/Mobile)]
              │
              ▼ (HTTP Request)
[Apache Web Server / PHP 8.x Runtime]
       ├─► [Routing & Session Guard (includes/auth_guard.php)]
       ├─► [Controllers / Views (views/admin, views/shopper, views/courier)]
       └─► [Database Layer (PDO MySQL / config/database.php)]
              │
              ▼
[MySQL Database Server (jastip_bandung)]
```

### 2.3 Karakteristik Pengguna
1. **Super Admin (Saya):** Menguasai penggunaan sistem web komputer dan HP, memiliki hak akses tertinggi ke semua tabel dan konfigurasi.
2. **Shopper (Bapak):** Mengoperasikan smartphone Android, membutuhkan navigasi ringkas, kontras warna jelas, dan tombol besar untuk keperluan di dalam toko.
3. **Packer & Courier (Adik):** Mengoperasikan smartphone, membutuhkan checklist interaktif dan integrasi klik tautan langsung ke WhatsApp pelanggan.
4. **Customer (Pelanggan):** Mengakses melalui browser ponsel atau laptop, membutuhkan pengalaman pesan yang intuitif dan pelacakan transparan tanpa registrasi yang rumit.

### 2.4 Batasan Desain & Implementasi
* **Tanpa Framework Berat:** Menggunakan PHP Native prosedural-modular terstruktur untuk memaksimalkan kecepatan eksekusi dan kemudahan pemeliharaan.
* **Tanpa Pihak Ketiga (No Third-Party Courier):** Tidak ada penghitungan ongkir dinamis via RajaOngkir / API kurir dan tidak ada generator nomor resi pengiriman.
* **Database Relasional:** Menggunakan MySQL InnoDB dengan *Foreign Key Constraints* untuk menjamin integritas referensial.

---

## 3. SPESIFIKASI KEBUTUHAN FUNGSIONAL (FUNCTIONAL REQUIREMENTS)

### 3.1 Modul Autentikasi & Otorisasi Pengguna (AUTH)

* **FR-AUTH-01 [Tinggi]: Login Multi-Peran**
  * *Input:* Username/No. Handphone, Password.
  * *Proses:* Sistem mencocokkan password terenkripsi (`password_verify` bcrypt), memeriksa status aktif akun, dan menyimpan session (`user_id`, `name`, `role`).
  * *Output:* Mengarahkan user ke dashboard sesuai role masing-masing:
    * `admin` ➡️ `views/admin/dashboard.php`
    * `shopper` ➡️ `views/shopper/dashboard.php`
    * `packer_courier` ➡️ `views/courier/dashboard.php`
    * `customer` ➡️ `index.php`

* **FR-AUTH-02 [Tinggi]: Middleware Role Guard**
  * *Proses:* Setiap view internal memanggil `require_role($allowedRoles)` dari `includes/auth_guard.php`. Jika role tidak cocok, sistem menolak akses dan me-redirect dengan pesan peringatan.

* **FR-AUTH-03 [Sedang]: Registrasi Pelanggan Mandiri**
  * *Input:* Nama Lengkap, Nomor WhatsApp, Username, Password.
  * *Proses:* Validasi keunikan username dan nomor WhatsApp, hashing password dengan algoritma bcrypt.

---

### 3.2 Modul Master Data & Katalog Produk (CATALOG)

* **FR-CAT-01 [Tinggi]: Manajemen Produk Jastip (Admin)**
  * *Input:* Kategori, Nama Produk, Nama Toko di Bandung, Harga Asli Toko, Fee Jastip, Foto, Deskripsi, Status Ketersediaan.
  * *Proses:* Menyimpan data ke tabel `products`. Perhitungan otomatis harga total jual = `base_price` + `jastip_fee`.
  * *Akses:* Super Admin.

* **FR-CAT-02 [Tinggi]: Penjelajahan Katalog Publik (Customer)**
  * *Tampilan:* Menampilkan grid produk dengan filter kategori, nama toko, breakdown harga asli + fee jastip transparan, dan tombol pesan langsung via WA/keranjang.

* **FR-CAT-03 [Tinggi]: Form Request Titip Barang Custom**
  * *Deskripsi:* Memungkinkan pelanggan meminta titip barang di luar katalog dengan mengisi: Nama Barang, Perkiraan Harga, Nama Toko/Lokasi di Bandung, dan Catatan Varian.

---

### 3.3 Modul Pemesanan & Checkout (ORDER)

* **FR-ORD-01 [Tinggi]: Pembuatan Pesanan (Checkout)**
  * *Input:* Item belanjaan, Jumlah (Qty), Catatan Khusus per Item, Nama Pemesan, No WhatsApp, Metode Pengantaran (`delivery_address` atau `cod_meeting_point`), Alamat Lengkap / Titik Temu, dan Patokan/Waktu Antar.
  * *Proses:* 
    1. Sistem men-generate `order_code` unik dengan format `JB-YYYYMMDD-XXXX`.
    2. Menghitung `total_item_price`, `total_jastip_fee`, `delivery_fee` internal, dan `total_amount`.
    3. Menyimpan ke tabel `orders` dan rincian item ke tabel `order_items` dalam satu *Database Transaction*.
    4. Mencatat log awal di tabel `order_logs` dengan status `pending`.

* **FR-ORD-02 [Tinggi]: Verifikasi Pembayaran & Konfirmasi Pesanan (Admin)**
  * *Proses:* Admin memeriksa mutasi rekening/e-wallet, mengubah status pembayaran menjadi `paid_dp` atau `paid_full`, dan mengubah status pesanan dari `pending` menjadi `confirmed`.

---

### 3.4 Modul Belanja Lapangan / Shopper (Bapak)

* **FR-SHOP-01 [Tinggi]: Konsolidasi Daftar Belanjaan Terpadu (*Consolidated Shopping List*)**
  * *Kebutuhan Inti:* Sistem mengelompokkan semua pesanan berstatus `confirmed` atau `shopping` berdasarkan **Nama Toko** dan **Nama Item**.
  * *Contoh Tampilan Bapak di HP:*
    * 🏬 **Toko: Bolu Susu Lembang**
      * [ ] Bolu Susu Lembang Original Keju — **Total: 8 Box** *(Detail: 3 box Customer Budi, 5 box Customer Siti)*
    * 🏬 **Toko: Kartika Sari Dago**
      * [ ] Pisang Bollen Keju Spesial — **Total: 4 Box**
  * *Benefit:* Bapak tidak perlu membuka pesanan satu per satu di kasir toko. Cukup membeli sesuai angka total yang tertera.

* **FR-SHOP-02 [Tinggi]: Update Status Belanja Per Item**
  * *Aksi:* Tombol satu sentuhan untuk mengubah status item:
    * `bought` (Sudah Dibeli)
    * `out_of_stock` (Stok Habis di Toko)
    * `substituted` (Diganti varian lain atas persetujuan pembeli)

---

### 3.5 Modul Sortir & Packing (Adik)

* **FR-PACK-01 [Tinggi]: Checklist Packing Per Customer**
  * *Kebutuhan Inti:* Ketika barang belanjaan tiba di posko, Adik membuka daftar pesanan per pelanggan.
  * *Fitur:* Menampilkan checklist item pesanan milik pelanggan tertentu. Setiap barang dimasukkan ke kantong/dus, Adik mencentang item tersebut.
  * *Validasi:* Tombol `Selesai Packing & Siap Antar` hanya aktif jika seluruh item yang dibeli sudah tercentang lengkap.
  * *Output:* Mengubah status pesanan menjadi `packed`.

---

### 3.6 Modul Pengantaran Internal Tanpa Resi (DELIVERY)

* **FR-DELV-01 [Tinggi]: Penugasan Kurir Internal (Dispatching)**
  * *Aktor:* Admin memilih pengantar dari dropdown: `Bapak`, `Adik`, atau `Saya`.
  * *Proses:* Memperbarui kolom `assigned_courier_id` pada tabel `orders`.

* **FR-DELV-02 [Tinggi]: Daftar Tugas Antar Kurir (Delivery Route List)**
  * *Kebutuhan Inti:* Menampilkan pesanan berstatus `packed` atau `delivering` yang ditugaskan ke kurir tersebut.
  * *Informasi yang Ditampilkan:*
    * Nama Customer & Alamat Antar / Titik Temu COD.
    * Tombol 🟢 **Hubungi Pelanggan:** Membuka WhatsApp secara instan dengan pesan dinamis: *"Halo Kak [Nama], pesanan jastip Anda dari [Toko] sedang kami antarkan..."*.
    * Tombol 🚀 **Mulai Antar:** Mengubah status menjadi `delivering`.
    * Tombol ✅ **Pesanan Diterima:** Mengubah status menjadi `completed`.

---

### 3.7 Modul Tracking Real-Time untuk Customer (TRACKING)

* **FR-TRK-01 [Tinggi]: Lacak Pesanan Tanpa Resi**
  * *Input:* Kode Pesanan (contoh: `JB-20261103-001`) atau nomor WhatsApp.
  * *Tampilan:* Stepper progres visual interaktif 6 tahap:
    1. ⏳ Menunggu Konfirmasi & Pembayaran
    2. 📝 Pesanan Dikonfirmasi & Dijadwalkan Belanja
    3. 🛒 Barang Sedang Dibelanjakan di Bandung
    4. 📦 Selesai Dipacking & Siap Diantar
    5. 🛵 Sedang Diantar oleh Tim Jastip ([Nama Pengantar]) Menuju Lokasi Anda
    6. ✅ Pesanan Telah Diterima (Selesai)
  * *Riwayat Log:* Menampilkan riwayat waktu perubahan status dari tabel `order_logs`.

---

### 3.8 Modul Laporan & Rekapitulasi Finansial (Admin)

* **FR-FIN-01 [Tinggi]: Ringkasan Arus Kas & Keuntungan Jastip**
  * *Kalkulasi:*
    * Total Modal Belanja = `SUM(base_price * quantity)` untuk item yang terbeli.
    * Total Pendapatan Fee Jastip = `SUM(jastip_fee * quantity)`.
    * Total Ongkir Antar Mandiri = `SUM(delivery_fee)`.
    * Laba Bersih Operasional = Total Pendapatan Fee + Ongkir Mandiri.
  * *Filter:* Berdasarkan tanggal belanja atau nomor batch Open PO.

---

## 4. KEBUTUHAN ANTARMUKA EKSTERNAL (EXTERNAL INTERFACES)

### 4.1 User Interface (UI)
* Menggunakan **Tailwind CSS** dengan palet warna hijau emerald (`#059669`) untuk memberikan kesan segar, ramah, dan amanah.
* Desain responsif (*Fluid Grid*) yang dioptimalkan untuk ukuran layar ponsel Android 360px hingga layar desktop 1920px.

### 4.2 Software & Database Interface
* Web Server: Apache 2.4+ (XAMPP).
* Bahasa Pemrograman: PHP versi 8.0 ke atas.
* Database: MySQL versi 5.7+ / MariaDB 10.4+.
* Driver Database: PHP Data Objects (PDO MySQL).

### 4.3 Communications Interface (WhatsApp Direct Handshake)
* Menggunakan skema URL WhatsApp API resmi (`https://wa.me/{nomor}?text={pesan_terenkripsi_url}`) tanpa ketergantungan pada vendor bot berbayar pihak ketiga.

---

## 5. KEBUTUHAN NON-FUNGSIONAL (NON-FUNCTIONAL REQUIREMENTS)

### 5.1 NFR-SEC: Keamanan (Security)
* **NFR-SEC-01:** Seluruh input pengguna dibersihkan dari potensi XSS menggunakan `htmlspecialchars()`.
* **NFR-SEC-02:** Seluruh query database interaktif wajib menggunakan *PDO Prepared Statements* dengan parameter binding untuk mencegah SQL Injection 100%.
* **NFR-SEC-03:** Password akun disimpan dalam bentuk hash satu arah menggunakan algoritma `PASSWORD_BCRYPT`.

### 5.2 NFR-PERF: Performa & Efisiensi
* **NFR-PERF-01:** Halaman harus memiliki waktu respon server (*Time to First Byte - TTFB*) kurang dari 200 ms pada lingkungan lokal/server standar.
* **NFR-PERF-02:** Asset CSS menggunakan Tailwind CDN Play / minified CSS dengan ukuran transfer data yang sangat hemat kuota internet ponsel tim lapangan.

### 5.3 NFR-REL: Reliabilitas & Integritas Data
* **NFR-REL-01:** Transaksi multi-tabel pada saat checkout pesanan dilindungi dengan `PDO::beginTransaction()`, `commit()`, dan `rollBack()` untuk mencegah adanya data pesanan gantung jika terjadi kegagalan sistem.
