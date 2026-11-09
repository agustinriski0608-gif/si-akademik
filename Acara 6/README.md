# Acara 6 - Middleware, Auth Sederhana, dan Struktur Folder

**Buka:** `http://localhost/si-akademik/Acara 6/public/`  (tidak butuh database)
**Login:** `admin` / `admin123`

## Alur uji (sesuai modul)
1. Buka `/mahasiswa` **tanpa login** -> otomatis pindah ke `/login` + pesan "Silakan login terlebih dahulu".
2. Login salah -> pesan error. Login benar -> dashboard + alert **"Selamat datang, Admin"**.
3. Buka `/mahasiswa` -> tabel muncul.
4. Klik **Logout** -> kembali ke login + alert **"Anda telah logout"** (tugas mandiri flash message).

## File penting
- `app/Core/Middleware/AuthMiddleware.php` -> satpam: cek `$_SESSION['logged_in']`.
- `app/Core/Router.php` -> route boleh diberi middleware: `$router->get('/mahasiswa', [...], ['auth'])`.
- `routes/web.php` -> `/dashboard`, `/mahasiswa`, `/logout` dipasangi `['auth']`.
- `app/Controllers/AuthController.php` -> `loginForm`, `login`, `logout`.
- Struktur folder lengkap sesuai modul: `app/ config/ public/ routes/ storage/logs`.

## Poin penjelasan
- Middleware berada di antara request dan Controller.
- `session_regenerate_id(true)` setelah login mencegah session fixation.
- Password hardcode hanya sementara; nanti diganti database.
