# Acara 8 - PDO, Prepared Statement, Relasi, dan CRUD Lengkap

**Persiapan:** import `database/si_akademik.sql` (lihat README Acara 7).
**Buka:** `http://localhost/si-akademik/Acara 8/public/`   **Login:** `admin` / `admin123`

## Yang ditunjukkan ke dosen
1. `app/Core/Database.php` -> **singleton** PDO (satu koneksi untuk seluruh aplikasi).
2. CRUD lengkap 3 resource: **Mahasiswa, Program Studi, Mata Kuliah** (tambah, ubah, hapus, tampil).
3. Semua query memakai **prepared statement** (`:nama`, bukan menggabung string).
4. Daftar mahasiswa memakai **JOIN** (menampilkan nama prodi, bukan angka ID).
5. **Konfirmasi JavaScript** sebelum hapus.
6. **Tugas mandiri:** kolom pencarian (nama atau NIM) dengan `LIKE` + prepared statement.
7. Mencoba hapus prodi yang masih dipakai -> ditolak dengan pesan (foreign key).
8. NIM kembar ditolak dengan pesan, form tidak kosong lagi setelah gagal.

## Demo SQL Injection (bagian "Studi Kasus" modul)
Isi kolom pencarian dengan `' OR '1'='1` -> **tidak ada data bocor**, karena input dianggap data biasa.

## Poin penjelasan
- Prepared statement memisahkan query dan data.
- Singleton: constructor `private`, objek dibuat sekali lewat `getInstance()`.
