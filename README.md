# 🏢 SI-PINJAM (Sistem Peminjaman Fasilitas Kampus)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Laragon](https://img.shields.io/badge/Laragon-0F172A?style=for-the-badge&logo=laragon&logoColor=white)

**SI-PINJAM** adalah sebuah sistem informasi berbasis web yang dirancang untuk mendigitalisasi dan mempermudah proses peminjaman fasilitas ruang dan gedung di lingkungan Universitas Pembangunan Nasional "Veteran" Jawa Timur (UPNVJT).

Sistem ini hadir dengan antarmuka _Dark Mode_ yang modern, elegan, dan _user-friendly_, serta dilengkapi dengan algoritma validasi cerdas untuk mencegah terjadinya bentrok jadwal peminjaman.

---

## ✨ Fitur Unggulan

Sistem ini memiliki manajemen Hak Akses (Multi-Role) yang komprehensif, dibagi menjadi 4 peran pengguna:

### 👨‍🎓 Panel Mahasiswa (Pengguna)

- **Pencarian Fasilitas Real-Time:** Melihat ketersediaan fasilitas melalui kalender interaktif. Tanggal yang penuh atau diblokir akan ditandai secara otomatis beserta alasan spesifiknya.
- **Pengajuan Anti-Bentrok:** Form peminjaman terintegrasi dengan _Validasi Sistem_ di sisi _backend_. Sistem akan otomatis menolak pengajuan jika fasilitas pada tanggal tersebut sudah dipesan atau diblokir.
- **Riwayat & Status Pengajuan:** Memantau status peminjaman secara transparan (Pending, Disetujui, Ditolak).

### 👨‍💻 Panel Administrator

- **Kelola Data Fasilitas (CRUD):** Menambah, mengedit, dan menghapus data fasilitas kampus beserta foto dan kapasitasnya.
- **Manajemen Blokir Jadwal Lanjutan:** Fitur _bulk-action_ untuk memblokir rentang tanggal tertentu (misal: untuk renovasi atau hari libur). Dilengkapi algoritma pemampat data tanggal yang cerdas untuk tampilan _pop-up_ yang rapi.
- **Persetujuan (Approve/Reject):** Meninjau dan memvalidasi setiap pengajuan dari mahasiswa.

### 👨‍🏫 2. Panel Dosen
* Memiliki dasbor khusus untuk sivitas akademika pengajar.
* Mengajukan peminjaman fasilitas untuk keperluan akademik, kuliah pengganti, atau seminar.

### 👨‍🎓 3. Panel Mahasiswa
* **Pengajuan Anti-Bentrok:** Mengajukan peminjaman (misal: untuk kegiatan BEM/HIMA) dengan sistem validasi otomatis yang mencegah tanggal bentrok.
* **Riwayat Interaktif:** Memantau status pengajuan secara *real-time*.

### 🤝 4. Panel Eksternal (Umum)
* Pintu masuk bagi pihak luar kampus (masyarakat umum, instansi, atau perusahaan) yang ingin menyewa fasilitas kampus (misal: GSG untuk pernikahan atau acara umum).

---

## 💻 Tech Stack

Aplikasi ini dibangun menggunakan berbagai teknologi modern dan fungsional, antara lain:

**Frontend:**

- HTML5 & CSS3
- [Tailwind CSS](https://tailwindcss.com/) (Framework untuk _styling_ antarmuka)
- Vanilla JavaScript (Untuk manipulasi DOM interaktif)
- [SweetAlert2](https://sweetalert2.github.io/) (Untuk _pop-up alert_ dan modal dinamis yang elegan)
- FontAwesome 6 (Untuk ikon)

**Backend & Database:**

- [Laravel](https://laravel.com/) (PHP Framework)
- MySQL / MariaDB
- [Laragon](https://laragon.org/) (Local Development Environment)
- Carbon (Ekstensi PHP untuk manipulasi rentang waktu dan kalender)

---

## 🚀 Panduan Instalasi (Local Development)

Jika Anda ingin menjalankan _project_ ini di komputer lokal, pastikan Anda sudah menginstal [Composer](https://getcomposer.org/), [Node.js](https://nodejs.org/), dan **Laragon**.

1. **Clone Repository**
   Buka terminal, lalu jalankan perintah ini:

    ```bash
    git clone [https://github.com/IhsannulF/Project-SI-pinjam-UPNVJT.git](https://github.com/IhsannulF/Project-SI-pinjam-UPNVJT.git)
    cd Project-SI-pinjam-UPNVJT

    Install package PHP dan Node.js yang dibutuhkan:
    composer install
    npm install

    Buka aplikasi Laragon dan klik Start All (pastikan Apache dan MySQL berjalan).
    Buka Database Manager (seperti HeidiSQL bawaan Laragon atau phpMyAdmin) dan buat database baru, misalnya dengan nama sipinjam_db.

    Konfigurasi Environment
    ```

Copy file .env.example dan ubah namanya menjadi .env.

Buka file .env dan sesuaikan koneksi database Anda:

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

Generate application key:
php artisan key:generate

Migrasi Database
Buat struktur tabel ke dalam database Anda:
php artisan migrate

Jalankan Aplikasi :
Terminal 1 (Menjalankan server Laravel): php artisan serve
Terminal 2 (Men-compile Tailwind CSS): npm run dev
