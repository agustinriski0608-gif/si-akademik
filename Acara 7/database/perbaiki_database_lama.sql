-- ============================================================
--  KHUSUS kalau database si_akademik lama kamu SUDAH ada.
--  Menghapus kolom `prodi` (teks) sisa Acara 7 di tabel mahasiswa.
--  Kolom itu NOT NULL tanpa default, sehingga tombol "Simpan"
--  di form tambah mahasiswa error:
--     Field 'prodi' doesn't have a default value
--  Nama prodi sudah diambil lewat JOIN dengan tabel prodi (prodi_id).
-- ============================================================
USE `si_akademik`;
ALTER TABLE `mahasiswa` DROP COLUMN `prodi`;
