# Acara 5 - Routing, .htaccess, Request dan Response

**Buka:** `http://localhost/si-akademik/Acara 5/public/`  (tidak butuh database / login)

## URL yang dicoba
| URL | Hasil |
|---|---|
| `/` | Beranda |
| `/mahasiswa` | Daftar mahasiswa |
| `/mahasiswa/create` | Form tambah |
| `/mahasiswa/7` | Detail (ID dari URL) |
| `/ngawur` | 404 |

## Poin penjelasan
- `public/.htaccess` mengarahkan semua URL yang bukan file asli ke `index.php` (URL bersih).
- `routes/web.php` = daftar route; `public/index.php` = router yang mencocokkan URL + method.
- Route dinamis `/mahasiswa/{angka}` memakai regular expression.
- Jika URL tidak cocok: `http_response_code(404)`.
