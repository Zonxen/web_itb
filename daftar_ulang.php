<?php
// Mulai sesi (pastikan ini ada di setiap halaman yang memerlukan autentikasi)
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Alihkan pengguna ke halaman login jika belum login
    exit();
}

// Tangani proses daftar ulang di sini
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses formulir daftar ulang jika data dikirimkan
    // Gantilah bagian ini dengan logika daftar ulang yang sesuai
    $hasil_daftar_ulang = "Daftar ulang berhasil!"; // Pesan sukses, Anda bisa menggantinya dengan pesan sesuai

    // Contoh: Simpan hasil daftar ulang ke database jika diperlukan
    // $user_id = $_SESSION["user_id"];
    // $query = "INSERT INTO daftar_ulang (user_id, tanggal) VALUES ($user_id, NOW())";
    // ...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Daftar Ulang Mahasiswa Baru</title>
</head>
<body>
    <header>
        <h1>Daftar Ulang Mahasiswa Baru</h1>
    </header>

    <section class="daftar-ulang-form">
        <h2>Formulir Daftar Ulang</h2>
        <?php if (isset($hasil_daftar_ulang)) : ?>
            <p><?php echo $hasil_daftar_ulang; ?></p>
        <?php else : ?>
            <form action="daftar_ulang.php" method="post">
                <!-- Tambahkan elemen-elemen formulir daftar ulang di sini -->
                <button type="submit">Daftar Ulang</button>
            </form>
        <?php endif; ?>
    </section>

    <footer>
        &copy; 2023 Aplikasi Pendaftaran Mahasiswa Baru
    </footer>
</body>
</html>
