# Acara 7 - Database, CREATE TABLE, dan Model Dasar

**Persiapan (sekali saja):** phpMyAdmin -> tab **Import** -> pilih `database/si_akademik.sql` -> Go.
**Buka:** `http://localhost/si-akademik/Acara 7/public/`   **Login:** `admin` / `admin123`

> Database lama sudah ada dan Simpan mahasiswa error `Field 'prodi' doesn't have a default value`?
> Jalankan `database/perbaiki_database_lama.sql` di phpMyAdmin (menghapus kolom `prodi` sisa).

## Yang ditunjukkan ke dosen
1. phpMyAdmin: database `si_akademik` dengan 3 tabel `prodi`, `mahasiswa`, `matakuliah` + data awal + relasi FOREIGN KEY.
2. `config/database.php` -> pengaturan koneksi.
3. `app/Core/Model.php` -> Model dasar (koneksi PDO).
4. `app/Models/MahasiswaModel.php` -> method `all()` (JOIN ke prodi).
5. Halaman `/mahasiswa` menampilkan data dari database.
6. **Tugas mandiri:** kolom `status` ENUM('aktif','cuti','lulus') default `aktif` (lihat tabel + kolom Status di halaman).

## Poin penjelasan
- Foreign key menjaga integritas: mahasiswa tidak bisa punya `prodi_id` yang tidak ada.
- `ON DELETE RESTRICT`: prodi yang masih dipakai tidak bisa dihapus.
