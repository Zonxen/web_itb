<?php
// Koneksi ke database (Gantilah ini sesuai dengan informasi koneksi Anda)
$host = "localhost";
$username = "root";
$password = "";
$database = "pendaftaran_itb";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data dari formulir login
$email = $_POST["email"];
$password = $_POST["password"];

// Query untuk mencari pengguna dengan email yang sesuai
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($result) == 1) {
    // Pengguna dengan email yang sesuai ditemukan
    $row = mysqli_fetch_assoc($result);
    $stored_password = $row["password"];

    // Verifikasi password
    if (password_verify($password, $stored_password)) {
        // Autentikasi berhasil, Anda bisa mengizinkan akses ke halaman lain
        session_start();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_nama"] = $row["nama"];
        header("Location: dashboard.php"); // Ganti dengan halaman utama Anda
        exit();
    } else {
        header("Location: login.html?error=password"); // Redirect dengan pesan kesalahan
        exit();
    }
} else {
    header("Location: login.html?error=email"); // Redirect dengan pesan kesalahan
    exit();
}

// Tutup koneksi ke database
mysqli_close($koneksi);
?>
