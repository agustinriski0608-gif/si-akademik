# Acara 10 - Inheritance, Base Controller, Base Model, Repository Pattern

**Persiapan:** import `database/si_akademik.sql`.
**Buka:** `http://localhost/si-akademik/Acara 10/public/`   **Login:** `admin` / `admin123`

| No. modul | Di mana |
|---|---|
| 1. `BaseController` berisi `view()` dan `redirect()` | `app/Core/Controller.php` |
| 2. `MahasiswaController extends Controller` memakai method warisan | `app/Controllers/MahasiswaController.php` |
| 3. `MahasiswaRepository` menangani semua operasi database | `app/Repositories/MahasiswaRepository.php` |
| 4. Controller tidak menulis SQL, hanya memanggil repository | cari kata `SELECT` di folder Controllers: **tidak ada** |
| 5. Uji tampil, tambah, ubah, hapus | menu Mahasiswa |

Bonus: Prodi dan Mata Kuliah juga memakai pola yang sama (`ProdiRepository`, `MataKuliahRepository`),
dan `Model` dasar (`app/Core/Model.php`) diwarisi semua repository.

## Poin penjelasan
- **Inheritance:** `view()`, `redirect()`, `flash()` ditulis sekali di `Controller`, diwarisi semua controller (DRY).
- **Repository Pattern:** semua SQL di Repository; kalau database/struktur tabel berubah, cukup ubah Repository.
- Perbedaan dengan Acara 9: Repository sekarang `extends Model` (mendapat koneksi dari kelas induk), Controller `extends Controller`.
