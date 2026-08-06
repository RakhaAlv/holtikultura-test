````md
<p align="center">
  <img src="https://hortikultura.pertanian.go.id/wp-content/uploads/2023/09/logo-horti-copy.png" width="140" alt="Logo Direktorat Jenderal Hortikultura">
</p>

<h1 align="center">🌱 SIMERAH</h1>

<h3 align="center">
Sistem Informasi Monitoring dan Evaluasi Realisasi Hortikultura
</h3>

<p align="center">
Direktorat Jenderal Hortikultura<br>
Kementerian Pertanian Republik Indonesia
</p>

<p align="center">

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-Latest-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-Internal-success?style=for-the-badge)

</p>

---

<p align="center">
<b>SIMERAH</b> (Sistem Informasi Monitoring dan Evaluasi Realisasi Hortikultura) merupakan aplikasi berbasis web yang dikembangkan untuk mendukung proses monitoring, evaluasi, pengelolaan, dan pelaporan data bantuan komoditas hortikultura secara terintegrasi di lingkungan Direktorat Jenderal Hortikultura, Kementerian Pertanian Republik Indonesia.
</p>

---

# 📚 Daftar Isi

- [Tentang SIMERAH](#-tentang-simerah)
- [Tujuan Sistem](#-tujuan-sistem)
- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Modul Sistem](#-modul-sistem)
- [Keamanan Sistem](#-keamanan-sistem)
- [Struktur Folder](#-struktur-folder)
- [Tim Pengembang](#-tim-pengembang)
- [Lisensi](#-lisensi)

---

# 📖 Tentang SIMERAH

**SIMERAH (Sistem Informasi Monitoring dan Evaluasi Realisasi Hortikultura)** merupakan aplikasi berbasis web yang dikembangkan sebagai media monitoring dan evaluasi penyaluran bantuan komoditas hortikultura pada Direktorat Jenderal Hortikultura.

Sistem ini dirancang untuk membantu proses pengelolaan data target maupun realisasi bantuan sehingga seluruh data dapat dikelola secara terpusat, terdokumentasi dengan baik, serta mudah diakses oleh pengguna yang berwenang.

Melalui dashboard yang interaktif, pengguna dapat memantau perkembangan realisasi bantuan berdasarkan komoditas, wilayah, dan tahun. Selain itu, sistem juga menyediakan fasilitas pengelolaan data serta pembuatan laporan dalam format Microsoft Excel untuk mendukung proses administrasi dan pengambilan keputusan.

---

# 🎯 Tujuan Sistem

SIMERAH dikembangkan dengan tujuan untuk:

- Mendukung proses monitoring dan evaluasi realisasi bantuan hortikultura.
- Mempermudah pengelolaan data target dan realisasi secara terpusat.
- Menyediakan informasi capaian bantuan secara cepat dan akurat.
- Mempermudah penyusunan laporan monitoring.
- Meningkatkan transparansi serta akuntabilitas pengelolaan data.
- Mendukung pengambilan keputusan berbasis data.

---

# ✨ Fitur Utama

## 📊 Dashboard Monitoring

- Dashboard interaktif
- Summary Card setiap komoditas
- Monitoring target dan realisasi
- Persentase capaian bantuan
- Progress Bar
- Rekapitulasi data
- Statistik monitoring
- Filter berdasarkan tahun
- Filter berdasarkan provinsi
- Filter berdasarkan kabupaten

---

## 🎯 Manajemen Data Target

- Menambah data target
- Mengubah data target
- Menghapus data target
- Pencarian data
- Filter data
- Validasi data
- Pagination data

---

## 🌱 Manajemen Data Realisasi

- Menambah data realisasi
- Mengubah data realisasi
- Menghapus data realisasi
- Monitoring status bantuan
- Filter data
- Pencarian data
- Validasi data
- Pagination data

---

## 📤 Export Data

- Export Data Target ke Microsoft Excel (.xlsx)
- Export Data Realisasi ke Microsoft Excel (.xlsx)
- Export data berdasarkan filter tahun
- Export data berdasarkan wilayah
- Format laporan siap digunakan
- Laporan dapat diunduh secara langsung

---

## 👥 User Management

- Authentication Login
- Manajemen akun pengguna
- Role Based Access Control (RBAC)
- Pengelolaan hak akses pengguna

---

# 🛠️ Teknologi

| Kategori | Teknologi |
|----------|-----------|
| Backend | Laravel 13 |
| Bahasa Pemrograman | PHP 8.4 |
| Frontend | Blade Template |
| CSS Framework | Tailwind CSS |
| JavaScript | Vanilla JavaScript |
| Build Tool | Vite |
| Database | MySQL |
| Dependency Manager | Composer |
| Version Control | Git |

---

# 📦 Modul Sistem

- Dashboard Monitoring
- Dashboard Analytics
- Summary Card Komoditas
- Manajemen Target
- Manajemen Realisasi
- Export Excel
- User Management
- Authentication
- Authorization
- Filter Tahun
- Filter Provinsi
- Filter Kabupaten
- Progress Monitoring
- Rekapitulasi Data

---

# 🔒 Keamanan Sistem

SIMERAH menerapkan beberapa mekanisme keamanan untuk menjaga integritas dan kerahasiaan data, di antaranya:

- Authentication Login
- Role Based Access Control (RBAC)
- Laravel Middleware
- CSRF Protection
- Validasi Input
- Route Protection
- Password Hashing
- Session Management

---

# 📂 Struktur Folder

```text
app/
bootstrap/
config/
database/
public/
resources/
├── css/
├── js/
├── views/
routes/
storage/
tests/
vendor/
```

---

# 🚀 Fitur yang Akan Dikembangkan

- Import Data Excel
- Dashboard Grafik Interaktif
- Export PDF
- Notifikasi Pembaruan Data
- Riwayat Aktivitas Pengguna (Activity Log)
- Audit Trail
- Dashboard Statistik Nasional
- Grafik Perbandingan Target dan Realisasi
- Monitoring berdasarkan Direktorat
- Backup Database
- Dark Mode
- API Integration

---

# 👨‍💻 Tim Pengembang

| Nama | Peran |
|------|-------|
| **Rio Hotasy Parulian Simanjuntak** | Backend Developer |
| **Kevin Novantinno Hindiarto** | Frontend Developer & UI/UX Designer |
| **Rakha Aljiva Prabaswara** | Database Engineer |

---

# 📄 Lisensi

SIMERAH merupakan aplikasi yang dikembangkan untuk mendukung kegiatan monitoring dan evaluasi di lingkungan **Direktorat Jenderal Hortikultura, Kementerian Pertanian Republik Indonesia**.

Aplikasi ini bersifat **internal** dan digunakan sebagai sarana pengelolaan data bantuan komoditas hortikultura. Seluruh hak cipta dilindungi dan penggunaan di luar lingkungan instansi memerlukan izin dari pihak yang berwenang.

---

<div align="center">

# 🌱 SIMERAH

### Sistem Informasi Monitoring dan Evaluasi Realisasi Hortikultura

Direktorat Jenderal Hortikultura  
Kementerian Pertanian Republik Indonesia

**© 2026 Direktorat Jenderal Hortikultura. All Rights Reserved.**

</div>
````
