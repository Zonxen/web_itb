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

// Ambil data dari formulir pendaftaran
$nama = $_POST["nama"];
$email = $_POST["email"];
$password = $_POST["password"];

// Hash password sebelum menyimpannya ke database (gunakan teknik keamanan yang lebih kuat dalam produksi)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query untuk memasukkan data pengguna baru ke database
$query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$hashed_password')";

if (mysqli_query($koneksi, $query)) {
    echo "Pendaftaran berhasil! Silakan login <a href='login.html'>di sini</a>.";
} else {
    echo "Pendaftaran gagal: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
?>
