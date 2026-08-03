<div align="center">

<img src="https://hortikultura.pertanian.go.id/wp-content/uploads/2023/09/logo-horti-copy.png">

# Sistem Informasi Pemantauan Komoditas Direktorat Jenderal Hortikultura

### Direktorat Jenderal Hortikultura  
### Kementerian Pertanian Republik Indonesia

![Laravel](https://img.shields.io/badge/Laravel-13-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4-blue?style=for-the-badge&logo=php)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-38BDF8?style=for-the-badge&logo=tailwindcss)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql)
![License](https://img.shields.io/badge/License-Internal-success?style=for-the-badge)

---

**Sistem Informasi berbasis web untuk mendukung proses monitoring, pengelolaan, dan pelaporan data komoditas hortikultura secara terintegrasi.**

</div>

---

# 📖 Deskripsi

Sistem Informasi Pemantauan Komoditas Direktorat Jenderal Hortikultura merupakan aplikasi berbasis web yang dikembangkan untuk membantu proses pengelolaan data komoditas hortikultura di lingkungan Direktorat Jenderal Hortikultura, Kementerian Pertanian Republik Indonesia.

Aplikasi ini memungkinkan pengguna untuk melakukan monitoring target dan realisasi bantuan komoditas hortikultura secara cepat, akurat, dan terpusat melalui dashboard interaktif.

---

# ✨ Fitur Utama

## 📊 Dashboard Monitoring

- Summary Card setiap komoditas
- Progress Target dan Realisasi
- Progress Bar
- Dashboard interaktif
- Filter data berdasarkan wilayah dan tahun

---

## 📂 Manajemen Data Target

- Menambah data target
- Mengubah data target
- Menghapus data target
- Filter data
- Pencarian data

---

## 🌱 Manajemen Data Realisasi

- Menambah data realisasi
- Mengubah data realisasi
- Menghapus data realisasi
- Status bantuan
- Monitoring realisasi

---

## 👥 User Management

- Manajemen akun pengguna
- Role Based Access Control (RBAC)
- Hak akses berdasarkan peran

---

# 🔐 Hak Akses Pengguna

| Role | Hak Akses |
|-------|-----------|
| **Super Admin** | Mengelola seluruh data, dashboard, target, realisasi, dan akun pengguna |
| **Admin Direktorat** | Mengelola data sesuai direktorat masing-masing |
| **User** | Melihat dashboard dan data tanpa hak mengubah |

---

# 🖥️ Teknologi

| Backend | Frontend | Database |
|----------|-----------|-----------|
| Laravel 13 | Blade Template | MySQL |
| PHP 8.4 | Tailwind CSS | |
| Composer | JavaScript | |
| | Vite | |

---

# 📁 Struktur Project

```
project/
│
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
├── storage/
├── tests/
├── .env
├── artisan
└── README.md
```

---

# 🚀 Instalasi

## Clone Repository

```bash
git clone https://github.com/username/repository.git
```

Masuk ke project

```bash
cd repository
```

Install dependency

```bash
composer install
```

Install frontend

```bash
npm install
```

Copy file environment

```bash
cp .env.example .env
```

Generate key

```bash
php artisan key:generate
```

Konfigurasi database pada file **.env**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hortikultura
DB_USERNAME=root
DB_PASSWORD=
```

Migrasi database

```bash
php artisan migrate
```

Jika menggunakan seeder

```bash
php artisan db:seed
```

Jalankan Vite

```bash
npm run dev
```

Jalankan Laravel

```bash
php artisan serve
```

Akses aplikasi melalui

```
http://127.0.0.1:8000
```

---

# 📈 Modul Sistem

- Dashboard Monitoring
- Summary Card Komoditas
- Manajemen Target
- Manajemen Realisasi
- User Management
- Authentication
- Authorization
- Dashboard Analytics
- Filter Data
- Progress Monitoring

---

# 📊 Dashboard

Dashboard menyediakan informasi berupa:

- Total Target
- Total Realisasi
- Persentase Progress
- Rekapitulasi Komoditas
- Monitoring Bantuan
- Filter Wilayah
- Filter Tahun

---

# 🔒 Keamanan Sistem

- Authentication Login
- Laravel Middleware
- CSRF Protection
- Validasi Input
- Role Based Access Control (RBAC)

---

# 📷 Tampilan Aplikasi

> Tambahkan screenshot aplikasi pada bagian ini.

### Dashboard

```
assets/dashboard.png
```

### Management Target

```
assets/target.png
```

### Management Realisasi

```
assets/realisasi.png
```

### User Management

```
assets/users.png
```

---

# 👨‍💻 Pengembang

**Sistem Informasi Pemantauan Komoditas Direktorat Jenderal Hortikultura**

Dikembangkan sebagai aplikasi berbasis Laravel untuk mendukung proses monitoring dan pengelolaan data komoditas hortikultura pada Direktorat Jenderal Hortikultura.

---

<div align="center">

**Direktorat Jenderal Hortikultura**  
**Kementerian Pertanian Republik Indonesia**

© 2026 All Rights Reserved.

</div>
