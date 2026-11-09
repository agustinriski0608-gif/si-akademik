<?php
// Mengecek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h1>Deteksi Metode: POST</h1>";
    echo "<p>Halaman ini diakses menggunakan metode POST. Data dikirim secara tersembunyi.</p>";
} 
// Mengecek apakah request method adalah GET
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "<h1>Deteksi Metode: GET</h1>";
    echo "<p>Halaman ini diakses menggunakan metode GET. Data biasanya terlihat di URL.</p>";
}
?>