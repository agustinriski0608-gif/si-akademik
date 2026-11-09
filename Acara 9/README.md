# Acara 9 - OOP MVC Lanjutan: Object Composition, Dependency Injection, Getter/Setter

**Persiapan:** import `database/si_akademik.sql`.
**Buka:** `http://localhost/si-akademik/Acara 9/public/`   **Login:** `admin` / `admin123`

Fitur sama dengan Acara 8 (tambah, ubah, tampil, hapus tetap jalan setelah refactoring), tetapi susunan kodenya berubah:

| No. modul | Di mana |
|---|---|
| 1. Class `Database` pengelola koneksi PDO | `app/Core/Database.php` |
| 2. `MahasiswaRepository` menerima `Database` lewat constructor | `app/Repositories/MahasiswaRepository.php` |
| 3. `MahasiswaController` menerima `MahasiswaRepository` lewat constructor | `app/Controllers/MahasiswaController.php` |
| 4. Atribut `Mahasiswa` private + getter/setter | `app/Models/Mahasiswa.php` |
| 5. Validasi di setter (nama tidak kosong, NIM angka) | `setNama()`, `setNim()` |
| 6. Uji tambah/ubah/tampil/hapus | menu Mahasiswa |

## Uji validasi setter
- NIM `ABC12` -> "NIM harus berupa angka."
- Nama kosong (spasi saja) -> "Nama mahasiswa tidak boleh kosong."

## Poin penjelasan
- **Object Composition:** Controller *memiliki* Repository, Repository *memiliki* Database ("has-a").
- **Dependency Injection:** object tidak membuat dependency sendiri (`new PDO` dihilangkan); dependency diberikan dari luar lewat constructor. `app/Core/Container.php` membuatnya otomatis dari type-hint.
- Hasilnya lebih fleksibel dan testable (Database bisa diganti objek tiruan saat testing).
