# Acara 4 - PHP Native View, Layout, dan Dasar OOP

**Buka:** `http://localhost/si-akademik/Acara 4/public/`  (tidak butuh database / login)

## Yang ditunjukkan ke dosen
1. Halaman tabel mahasiswa dengan Bootstrap (NIM, Nama, Prodi, **Angkatan**).
2. `app/Views/partials/` -> `header.php`, `navbar.php`, `footer.php` (dipakai ulang, edit satu file berlaku di semua halaman).
3. `app/Views/layouts/main.php` -> menyusun header + navbar + isi + footer.
4. `app/Models/Mahasiswa.php` -> class dengan property **private** + getter.
5. **Tugas mandiri:** method `getAngkatan()` mengambil 2 digit awal NIM (`2401001` -> `2024`).

## Poin penjelasan
- Partial + include: tidak copy-paste header ke banyak file.
- Property `private` hanya bisa dibaca lewat getter (enkapsulasi).
- `htmlspecialchars` di View mencegah XSS.
