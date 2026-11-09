<!DOCTYPE html>
<html>
<head>
    <title>SI Akademik</title>
</head>
<body>
    <h2>Selamat datang di SI Akademik</h2>
    
    <h3>Form Pencarian (Metode GET)</h3>
    <!-- Form action mengarah ke proses.php dengan metode GET -->
    <form action="proses.php" method="GET">
        <label>Cari Mahasiswa:</label>
        <input type="text" name="keyword">
        <button type="submit">Cari</button>
    </form>

    <hr>

    <h3>Form Login (Metode POST)</h3>
    <!-- Form action mengarah ke login.php dengan metode POST -->
    <form action="login.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username">
        <label>Password:</label>
        <input type="password" name="password">
        <button type="submit">Login</button>
    </form>
</body>
</html>