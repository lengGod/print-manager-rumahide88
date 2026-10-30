<div align="center">

#  Manager - Sistem Manajemen Percetakan Rumah Ide 88

**Solusi modern dan efisien untuk mengelola alur kerja bisnis percetakan Anda dari pesanan hingga laporan.**

</div>

---

**Rumah Ide 88** adalah aplikasi web yang dirancang khusus untuk membantu bisnis percetakan mendigitalkan dan mengoptimalkan operasi mereka. Dengan antarmuka yang bersih dan intuitif, aplikasi ini memudahkan pengelolaan pesanan, pelanggan, stok bahan, dan pemantauan kinerja bisnis melalui laporan yang komprehensif.

## ✨ Fitur Utama

-   **🎨 Manajemen Desain**: Unggah, setujui, dan tolak file desain langsung dari detail pesanan.
-   **📦 Manajemen Stok Bahan**: Lacak ketersediaan bahan baku dan catat penggunaannya untuk setiap produksi.
-   **📈 Laporan Komprehensif**: Dapatkan wawasan tentang kinerja bisnis dengan laporan pesanan, pelanggan, produksi, dan keuntungan.
-   **👤 Manajemen Pengguna & Peran**: Sistem otentikasi dengan peran yang dapat disesuaikan (misalnya, Admin, Desainer, Operator Cetak).
-   **📊 Dasbor Analitik**: Dasbor utama yang menyediakan ringkasan visual dari metrik bisnis utama.
-   **🛍️ Manajemen Pesanan**: Alur kerja pesanan yang lengkap, mulai dari pembuatan, pembaruan status produksi, hingga pembuatan faktur.
-   **👥 Manajemen Pelanggan**: Kelola data pelanggan dan lihat riwayat pesanan mereka dengan mudah.
-   **🧩 Manajemen Produk**: Atur produk, kategori, dan jenis produk dengan spesifikasi yang dapat disesuaikan.


## 🛠️ Tumpukan Teknologi

-   **Backend**: PHP 8.2, Laravel 12
-   **Frontend**: Tailwind CSS 4, Alpine.js, Vite
-   **Database**: Dapat dikonfigurasi (default MySQL/MariaDB, dengan dukungan untuk PostgreSQL, SQLite)
-   **PDF Generation**: `barryvdh/laravel-dompdf` untuk pembuatan faktur.
-   **Manajemen Peran**: `spatie/laravel-permission`


## 🚀 Instalasi & Penyiapan

Ikuti langkah-langkah ini untuk menjalankan aplikasi secara lokal.

### Prasyarat

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Database (misalnya, MySQL, MariaDB)

### Langkah-langkah

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/username/RumahIde88.git
    cd RumahIde88
    ```

2.  **Instal Dependensi**
    Jalankan perintah ini untuk menginstal semua dependensi PHP dan JS.
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan**
    Salin file `.env.example` dan konfigurasikan koneksi database Anda.
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan perbarui variabel berikut:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=rumah_ide_88
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Hasilkan Kunci Aplikasi & Migrasi Database**
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```
    Perintah `--seed` akan mengisi database dengan data sampel (jika seeder dikonfigurasi).

5.  **Kompilasi Aset Frontend**
    ```bash
    npm run build
    ```

6.  **Jalankan Server Pengembangan**
    ```bash
    php artisan serve
    ```
    Aplikasi sekarang akan dapat diakses di `http://127.0.0.1:8000`.

## 🤝 Berkontribusi

Kontribusi sangat diterima! Silakan _fork_ repositori ini, buat _branch_ fitur baru, dan kirimkan _pull request_.

1.  **Fork** repositori.
2.  Buat branch fitur baru (`git checkout -b fitur/NamaFiturAnda`).
3.  _Commit_ perubahan Anda (`git commit -m 'Menambahkan fitur baru'`).
4.  _Push_ ke branch (`git push origin fitur/NamaFiturAnda`).
5.  Buka _Pull Request_.

---

Dibuat dengan ❤️ untuk menyederhanakan manajemen percetakan.
