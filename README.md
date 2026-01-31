# Sistem Informasi Perpustakaan – Laravel 12

## 👤 Profil Pengembang
Perkenalkan, saya **Ade Irma Hamdani**  
NIM **1323084**  
Program Studi **Sistem Informasi Industri Otomotif (SIIO)**  
Politeknik STMI Jakarta  

Melalui project ini, saya mengajukan diri untuk **magang di Astra Otoparts** pada posisi **IT**.

---

## 📌 Deskripsi Project
Project ini merupakan implementasi aplikasi **Sistem Informasi Perpustakaan** yang dikembangkan berdasarkan desain database dari soal berikut:

🔗 https://dbdiagram.io/d/Soal-CRUD-67ca4bcd263d6cf9a0853a9b

Aplikasi ini dibangun sebagai latihan penerapan:
- relasi database
- autentikasi & otorisasi user
- pengelolaan data berbasis role
- proses bisnis peminjaman buku

---

## 🛠️ Teknologi yang Digunakan
- PHP **8.2.12**
- Composer **2.8.11**
- Laravel **12**
- MySQL

---

## 👥 Role & Hak Akses
Aplikasi memiliki **3 role pengguna**:

### 1. Admin
- Mengelola data user
- Mengelola data buku dan kategori
- Melihat seluruh data peminjaman

### 2. Librarian
- Mengelola data buku dan kategori
- Mengelola data peminjaman
- Melihat riwayat peminjaman **yang terkait dengan dirinya saja**

### 3. Member
- Melihat data buku dan kategori
- Melihat data peminjaman **miliknya sendiri**
- Tidak memiliki hak untuk mengelola data

---

## 📚 Manajemen Buku & Kategori
- Satu buku dapat memiliki **lebih dari satu kategori**
- Relasi buku dan kategori diatur melalui tabel transaksi **book_category**
- Kategori buku dapat ditambahkan dan diubah saat proses input atau edit data buku

---

## 🔐 Autentikasi
Aplikasi menggunakan autentikasi sederhana berbasis **Laravel Fortify**, dengan menyesuaikan struktur tabel `users` sesuai dengan soal yang diberikan.

Pada proses peminjaman:
- `librarian_id` terdeteksi otomatis melalui autentikasi Laravel
- Tidak perlu input manual dari user

---

## 🌱 Seeder
Seeder telah disediakan untuk:
- Data User
- Data Kategori  

Seeder ini digunakan sebagai data awal (inisiasi) aplikasi.

---

## ⚙️ Cara Install & Menjalankan Aplikasi

### 1. Clone repository
git clone https://github.com/Irmaaadani/aop-Iibrary-irma.git

### 2. Install dependency PHP (Composer)
composer install

### 2. Install dependency PHP (Composer)
composer install

### 3. Install dependency frontend
npm install

### 4. Konfigurasi environment
cp .env.example .env
php artisan key:generate

### 5. sesuaikan konfigurasi database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan
DB_USERNAME=root
DB_PASSWORD=

### 6. Migrasi dan seeder database
php artisan migrate --seed

### 7. Menjalankan backend
php artisan serve

### 8. Menjalankan frontend
npm run dev




