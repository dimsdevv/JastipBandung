# DOKUMEN DESAIN PERANGKAT LUNAK (UML SPECIFICATIONS)
## Sistem Informasi Operasional JastipBandung
*Standard: Unified Modeling Language (UML 2.5) with Mermaid Diagram Support*

---

## 1. USE CASE DIAGRAM (DIAGRAM USE CASE)

### 1.1 Diagram Global Use Case Sistem

```mermaid
flowchart LR
    subgraph Aktor_Eksternal["Pelanggan"]
        C["👤 Customer"]
    end

    subgraph Aktor_Internal["Tim Operasional Keluarga"]
        B["🛍️ Bapak (Shopper Lapangan)"]
        A["📦 Adik (Packer & Courier)"]
        S["👑 Saya (Super Admin & Owner)"]
    end

    subgraph Sistem_Jastip["Batasan Sistem JastipBandung"]
        UC01["Eksplorasi Katalog & Cek Fee Jastip"]
        UC02["Form Request Titip Custom"]
        UC03["Checkout Pesanan & Pilih Metode Antar"]
        UC04["Lacak Status Pesanan Non-Resi"]
        UC05["Lihat Shopping List Terpadu per Toko"]
        UC06["Update Status Belanja (Dibeli/Habis)"]
        UC07["Checklist Sortir & Packing Pesanan"]
        UC08["Lihat Daftar Rute Pengantaran Pribadi"]
        UC09["Hubungi WA Pelanggan (1-Klik)"]
        UC10["Konfirmasi Paket Diserahkan/Diterima"]
        UC11["Kelola Master Data (Produk/Kategori/PO)"]
        UC12["Verifikasi Pembayaran & Setujui Order"]
        UC13["Tugaskan Kurir Internal (Bapak/Adik/Saya)"]
        UC14["Rekapitulasi Margin Fee & Laporan Keuangan"]
    end

    %% Relasi Customer
    C --> UC01
    C --> UC02
    C --> UC03
    C --> UC04

    %% Relasi Bapak (Shopper)
    B --> UC05
    B --> UC06
    B --> UC08
    B --> UC09
    B --> UC10

    %% Relasi Adik (Packer & Courier)
    A --> UC07
    A --> UC08
    A --> UC09
    A --> UC10

    %% Relasi Saya (Super Admin) - Akses Penuh
    S --> UC11
    S --> UC12
    S --> UC13
    S --> UC14
    S -.->|Dapat Mengambil Alih| UC05
    S -.->|Dapat Mengambil Alih| UC07
    S -.->|Dapat Mengambil Alih| UC08
```

---

## 2. ACTIVITY DIAGRAMS (DIAGRAM AKTIVITAS)

### 2.1 Activity 1: Alur Pemesanan & Verifikasi Pembayaran (Customer & Admin)

```mermaid
flowchart TD
    Start([Mulai]) --> PilihBarang[Customer memilih oleh-oleh dari katalog / input titipan custom]
    PilihBarang --> IsiForm[Isi data diri, nomor WA, alamat lengkap / titik temu COD]
    IsiForm --> PilihMetode[Pilih: Diantar ke Alamat atau Janjian COD]
    PilihMetode --> SubmitOrder[Klik Buat Pesanan]
    
    SubmitOrder --> GenerateKode[Sistem generate Order Code JB-YYYYMMDD-XXXX]
    GenerateKode --> StatusPending[Sistem set status: PENDING]
    StatusPending --> NotifWA[Customer transfer DP / Lunas dan upload bukti bayar]
    
    NotifWA --> AdminReview{Admin verifikasi mutasi pembayaran}
    AdminReview -->|Tidak Valid/Batal| CancelOrder[Admin ubah status: CANCELLED]
    CancelOrder --> SelesaiBatal([Selesai - Pesanan Dibatalkan])
    
    AdminReview -->|Valid| SetujuiOrder[Admin setujui: Ubah status menjadi CONFIRMED]
    SetujuiOrder --> MasukJadwal[Sistem otomatis memasukkan item ke Daftar Belanjaan Bapak]
    MasukJadwal --> SelesaiPesan([Lanjut ke Tahap Belanja])
```

---

### 2.2 Activity 2: Alur Belanja Konsolidasi di Toko Bandung (Bapak)

```mermaid
flowchart TD
    StartBelanja([Bapak Buka HP di Lapangan]) --> BukaDashboard[Buka Dashboard Shopper]
    BukaDashboard --> LihatToko[Lihat Daftar Belanjaan Terpadu per Toko]
    LihatToko --> MasukToko[Tiba di Toko fisik: Bolu Lembang / Kartika Sari / dll]
    
    MasukToko --> CekItem[Ambil item belanjaan fisik di rak toko]
    CekItem --> CekStok{Apakah stok barang tersedia?}
    
    CekStok -->|Habis| TandaiHabis[Klik tombol: HABIS]
    TandaiHabis --> ChatAlternatif[Admin/Bapak tawarkan varian alternatif ke Customer via WA]
    
    CekStok -->|Tersedia| MasukkanKeranjang[Masukkan ke keranjang fisik]
    MasukkanKeranjang --> CentangDibeli[Klik tombol: SUDAH DIBELI]
    
    CentangDibeli --> SemuaItem{Apakah semua item toko sudah terbeli?}
    SemuaItem -->|Belum| CekItem
    SemuaItem -->|Sudah| BayarKasir[Bayar di Kasir Toko & Simpan Struk]
    BayarKasir --> BawaKePosko[Bawa seluruh belanjaan ke Posko Rumah untuk disortir Adik]
    BawaKePosko --> SelesaiBelanja([Lanjut ke Tahap Packing])
```

---

### 2.3 Activity 3: Alur Sortir, Packing & Pengantaran Mandiri (Adik & Customer)

```mermaid
flowchart TD
    StartPacking([Barang Belanjaan Tiba di Posko]) --> AdikBukaPacking[Adik buka Checklist Packing di HP]
    AdikBukaPacking --> PilihCustomer[Pilih pesanan Customer A]
    
    PilihCustomer --> CeklisItem[Ceklis satu per satu barang pesanan fisik ke dalam dus/kantong]
    CeklisItem --> LengkapKah{Semua item customer sudah lengkap?}
    LengkapKah -->|Belum| TungguItem[Tunggu barang dari toko lain]
    
    LengkapKah -->|Lengkap| TandaiPacked[Adik klik tombol: SELESAI PACKING]
    TandaiPacked --> AdminAssign[Admin tugaskan pengantar: Bapak / Adik / Saya]
    
    AdminAssign --> KurirBukaRute[Pengantar yang ditugaskan membuka Rute Pengantaran]
    KurirBukaRute --> KlikMulaiAntar[Klik: MULAI ANTAR ➡️ Status: DELIVERING]
    KlikMulaiAntar --> HubungiCustomer[Klik tombol WA: Beritahu customer sedang meluncur]
    
    HubungiCustomer --> TibaLokasi[Tiba di rumah customer / titik temu COD]
    TibaLokasi --> SerahkanBarang[Serahkan pesanan fisik & terima sisa pelunasan jika COD]
    SerahkanBarang --> KonfirmasiSelesai[Klik tombol: PESANAN DITERIMA ➡️ Status: COMPLETED]
    KonfirmasiSelesai --> SelesaiPengantaran([Transaksi Sukses Selesai])
```

---

## 3. SEQUENCE DIAGRAMS (DIAGRAM URUTAN)

### 3.1 Sequence 1: Proses Checkout Pesanan oleh Customer

```mermaid
sequenceDiagram
    autonumber
    actor C as Customer
    participant UI as Halaman Web (index.php)
    participant Ctrl as Order Handler (checkout.php)
    participant DB as MySQL Database (PDO)

    C->>UI: Pilih Produk & Klik "Buat Pesanan"
    UI->>C: Tampilkan Form Checkout & Pilihan Antar
    C->>UI: Isi Nama, WA, Alamat/COD, & Catatan
    C->>UI: Klik Submit Pesanan
    
    UI->>Ctrl: POST data pesanan (JSON/Form Data)
    activate Ctrl
    Ctrl->>Ctrl: Validasi kelengkapan data & format no. WA
    Ctrl->>Ctrl: Hitung Total Harga = Item + Fee Jastip + Ongkir Internal
    
    Ctrl->>DB: PDO::beginTransaction()
    Ctrl->>DB: INSERT INTO orders (order_code, user_id, total_amount, order_status='pending', ...)
    DB-->>Ctrl: Return order_id
    
    loop Setiap Item Pesanan
        Ctrl->>DB: INSERT INTO order_items (order_id, item_name, store_name, qty, price, fee, ...)
    end
    
    Ctrl->>DB: INSERT INTO order_logs (order_id, status='pending', notes='Pesanan dibuat')
    Ctrl->>DB: PDO::commit()
    deactivate Ctrl
    
    Ctrl-->>UI: Response Sukses (Kode Pesanan & Link WA Admin)
    UI-->>C: Tampilkan Layar Sukses & Panduan Transfer Pembayaran
```

---

### 3.2 Sequence 2: Update Item Belanja oleh Bapak (Shopper)

```mermaid
sequenceDiagram
    autonumber
    actor B as Bapak (Shopper)
    participant UI as Dashboard Belanja (shopper/dashboard.php)
    participant Ctrl as Item Status Controller
    participant DB as MySQL Database

    B->>UI: Buka Daftar Belanjaan Terpadu di Toko
    UI->>DB: SELECT store_name, item_name, SUM(quantity) FROM order_items WHERE item_status='pending' GROUP BY store_name, item_name
    DB-->>UI: Daftar rekap belanjaan toko
    UI-->>B: Tampilkan list belanjaan siap centang
    
    B->>UI: Klik centang "Sudah Dibeli" pada Item X
    UI->>Ctrl: POST /shopper/update_item.php (item_id, status='bought')
    activate Ctrl
    Ctrl->>DB: UPDATE order_items SET item_status='bought' WHERE id=item_id
    Ctrl->>DB: UPDATE orders SET order_status='shopping' WHERE id=order_id AND order_status='confirmed'
    Ctrl->>DB: INSERT INTO order_logs (order_id, status='shopping', notes='Barang sedang dibelanjakan di toko')
    Ctrl-->>UI: Status updated (HTTP 200 OK)
    deactivate Ctrl
    UI-->>B: Item berubah warna hijau (Tercoret/Selesai)
```

---

### 3.3 Sequence 3: Pengantaran Mandiri & Pelacakan Real-time (Adik & Customer)

```mermaid
sequenceDiagram
    autonumber
    actor A as Adik (Kurir Antar)
    participant UI_K as Dashboard Antar (courier/dashboard.php)
    participant WA as WhatsApp Web / App
    participant DB as MySQL Database
    actor C as Customer
    participant UI_C as Halaman Tracking (tracking.php)

    A->>UI_K: Klik tombol "Mulai Antar Rute Ini"
    UI_K->>DB: UPDATE orders SET order_status='delivering' WHERE id=order_id
    UI_K->>DB: INSERT INTO order_logs (order_id, status='delivering', notes='Paket sedang diantar oleh Adik')
    
    A->>UI_K: Klik tombol "Kirim Pesan WhatsApp ke Customer"
    UI_K->>WA: Buka link wa.me/{no_wa}?text=Halo%20Kak,%20pesanan%20sedang%20kami%20antar...
    WA-->>C: Pesan WA tiba di HP Customer
    
    C->>UI_C: Buka link tracking pesanan (tracking.php?code=JB-XXX)
    UI_C->>DB: SELECT * FROM orders JOIN order_logs WHERE order_code=...
    DB-->>UI_C: Data pesanan & status log
    UI_C-->>C: Tampilkan badge animasi: 🛵 "Sedang Diantar Menuju Lokasi Anda"
    
    A->>C: Tiba di rumah customer, serahkan paket fisik
    A->>UI_K: Klik tombol "Pesanan Diterima (Selesai)"
    UI_K->>DB: UPDATE orders SET order_status='completed' WHERE id=order_id
    UI_K->>DB: INSERT INTO order_logs (order_id, status='completed', notes='Paket diterima dengan baik')
    UI_K-->>A: Tampilan order berpindah ke tab "Riwayat Selesai"
```

---

## 4. ENTITY RELATIONSHIP DIAGRAM (ERD & CLASS SPECIFICATION)

```mermaid
erDiagram
    USERS ||--o{ ORDERS : "places (as customer)"
    USERS ||--o{ ORDERS : "delivers (as courier)"
    CATEGORIES ||--o{ PRODUCTS : "categorizes"
    PRODUCTS ||--o{ ORDER_ITEMS : "references"
    ORDERS ||--|{ ORDER_ITEMS : "contains"
    ORDERS ||--|{ ORDER_LOGS : "records"

    USERS {
        int id PK
        string name
        string phone UK
        string username UK
        string password
        enum role "admin, shopper, packer_courier, customer"
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    CATEGORIES {
        int id PK
        string name
        string slug UK
        string icon
        timestamp created_at
    }

    PRODUCTS {
        int id PK
        int category_id FK
        string name
        string slug UK
        string store_name
        decimal base_price
        decimal jastip_fee
        string image
        text description
        boolean is_available
        timestamp created_at
        timestamp updated_at
    }

    ORDERS {
        int id PK
        string order_code UK
        int user_id FK
        string customer_name
        string customer_phone
        enum delivery_method "delivery_address, cod_meeting_point"
        text delivery_address
        text delivery_notes
        decimal total_item_price
        decimal total_jastip_fee
        decimal delivery_fee
        decimal total_amount
        enum payment_status "pending, paid_dp, paid_full, cancelled"
        string payment_proof
        enum order_status "pending, confirmed, shopping, packed, delivering, completed, cancelled"
        int assigned_courier_id FK
        timestamp created_at
        timestamp updated_at
    }

    ORDER_ITEMS {
        int id PK
        int order_id FK
        int product_id FK
        string item_name
        string store_name
        int quantity
        decimal price_per_item
        decimal jastip_fee_per_item
        text notes
        enum item_status "pending, bought, out_of_stock, substituted"
        timestamp created_at
    }

    ORDER_LOGS {
        int id PK
        int order_id FK
        string status
        string notes
        int created_by FK
        timestamp created_at
    }
```

---

## 5. STATE MACHINE DIAGRAM (STATUS PESANAN NON-RESI)

```mermaid
stateDiagram-v2
    [*] --> Pending : Customer Checkout Pesanan

    Pending --> Confirmed : Admin Verifikasi Pembayaran (DP/Lunas)
    Pending --> Cancelled : Pembayaran Ditolak / Dibatalkan Customer

    Confirmed --> Shopping : Bapak Mulai Belanja Item di Toko
    Shopping --> Packed : Seluruh Belanjaan Tiba & Selesai Dipacking Adik
    
    Packed --> Delivering : Kurir (Bapak/Adik/Saya) Mulai Berangkat Antar
    Delivering --> Completed : Paket Diserahkan ke Customer (Selesai)

    Confirmed --> Cancelled : Barang Toko Habis Total / Dibatalkan
    Shopping --> Cancelled : Seluruh Toko Tutup / Force Majeure

    Completed --> [*]
    Cancelled --> [*]
```
