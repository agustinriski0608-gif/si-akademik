# SI Akademik - BKPM Workshop Sistem Informasi Web Server

Satu folder per acara, masing-masing proyek lengkap yang bisa dijalankan sendiri.

| Folder | Isi | Database |
|---|---|---|
| `Acara 1-3 (sudah disetor)` | file lama Acara 1-3 | - |
| `Acara 4` | View, layout, class Mahasiswa | tidak |
| `Acara 5` | Routing + .htaccess | tidak |
| `Acara 6` | Middleware + login | tidak |
| `Acara 7` | Database + Model dasar | **ya** |
| `Acara 8` | PDO + CRUD lengkap | **ya** |
| `Acara 9` | Dependency Injection + getter/setter | **ya** |
| `Acara 10` | Inheritance + Repository Pattern | **ya** |

## Cara menjalankan
1. Taruh folder `si-akademik` di `C:\xampp\htdocs\`.
2. Buka **XAMPP Control Panel** -> **Start** Apache dan **MySQL**.
3. (Acara 7-10) buka `http://localhost/phpmyadmin` -> **Import** -> `Acara 7/database/si_akademik.sql`.
   - Database lama sudah ada & tambah mahasiswa error `Field 'prodi'...`? Import `perbaiki_database_lama.sql`.
4. Buka `http://localhost/si-akademik/Acara 8/public/` (ganti angka sesuai acara). Login: `admin` / `admin123`.

Nama folder boleh berubah/ditaruh di mana saja: semua URL dibuat otomatis (`url()` di `app/helpers.php`).

## Kalau error
- **"No connection could be made because the target machine actively refused it"** -> MySQL belum menyala. Start MySQL di XAMPP.
- **Halaman 404 untuk semua URL** -> `mod_rewrite` / `AllowOverride All` belum aktif di Apache (httpd.conf), atau `.htaccess` di `public/` hilang.
- **"Database bermasalah"** di aplikasi -> database `si_akademik` belum di-import. Detail error ada di `storage/logs/app.log`.
