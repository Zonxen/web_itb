<?php
// Mulai sesi (pastikan ini ada di setiap halaman yang memerlukan autentikasi)
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Alihkan pengguna ke halaman login jika belum login
    exit();
}

// Jika pengguna sudah login, Anda bisa menampilkan konten dashboard di sini
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Dashboard Mahasiswa Baru</title>
</head>
<body>
    <header>
        <h1>Dashboard Mahasiswa Baru</h1>
    </header>

    <section class="dashboard-content">
        <!-- Tampilkan informasi dan fungsionalitas dashboard di sini -->
        <p>Selamat datang, <?php echo $_SESSION["user_nama"]; ?>!</p>
        <a href="hasil_tes.php">Lihat Hasil Tes</a>
        <a href="daftar_ulang.php">Daftar Ulang</a>
        <!-- Tambahkan link/logout button di dalam halaman dashboard -->
        <a href="logout.php">Logout</a>

        <!-- Tambahkan elemen HTML lain sesuai kebutuhan -->
    </section>

    <footer>
        &copy; 2023 Aplikasi Pendaftaran Mahasiswa Baru
    </footer>
</body>
</html>
