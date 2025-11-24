# Manajemen Data Karyawan

Aplikasi CRUD sederhana berbasis PHP yang terintegrasi dengan database MySQL Azure. Untuk pemenuhan tugas mandiri Mata Kuliah Komputasi Awan.

## Fitur

- Create, Read, Update, Delete data karyawan
- Tabel otomatis dengan nomor urut
- Status feedback setiap aksi CRUD
- Animasi gradient RGB background modern

## Struktur Tabel MySQL

CREATE TABLE karyawan (
id INT AUTO_INCREMENT PRIMARY KEY,
nama VARCHAR(100) NOT NULL,
jabatan VARCHAR(50) NOT NULL,
gaji DECIMAL(15,2) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

## Deployment ke Azure

1. Buat `Azure Database for MySQL Flexible Server` sesuai instruksi modul.
2. Update config ke setting Azure:
$host = "db-karyawan-[nama].mysql.database.azure.com";
$username = "isi sendiri";
$password = "isi sendiri";
$database = "db_karyawan";
3. Deploy repository ke Azure App Service via Deployment Center (connect GitHub).
4. Akses aplikasi pada URL:
https://web-karyawan-[nama].azurewebsites.net

## Kredit

- Developer: Mohamad Fikri Isfahani (1204230031)
- Stack: PHP, MySQL Azure, GitHub Actions, Azure App Service (Linux - Free F1)