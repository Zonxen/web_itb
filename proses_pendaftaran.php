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

// Tentukan aturan penomoran nomor_induk, misalnya dengan mengambil tahun masuk dan nomor urut terbaru
$tahun_masuk = date("Y"); // Ambil tahun saat ini sebagai tahun masuk
$query_get_last_nomor_induk = "SELECT MAX(nomor_induk) AS last_nomor_induk FROM users WHERE nomor_induk LIKE '$tahun_masuk%'";
$result_get_last_nomor_induk = mysqli_query($koneksi, $query_get_last_nomor_induk);
$row = mysqli_fetch_assoc($result_get_last_nomor_induk);
$last_nomor_induk = $row["last_nomor_induk"];

if ($last_nomor_induk) {
    // Jika ada nomor_induk sebelumnya untuk tahun ini, tambahkan 1
    $last_nomor_induk_number = intval(substr($last_nomor_induk, -5)); // Ambil nomor urut dari nomor_induk terakhir
    $new_nomor_induk_number = $last_nomor_induk_number + 1;
} else {
    // Jika belum ada nomor_induk untuk tahun ini, mulai dari nomor 1
    $new_nomor_induk_number = 1;
}

// Format nomor_induk sesuai dengan aturan yang telah ditetapkan
$new_nomor_induk = $tahun_masuk . "-" . str_pad($new_nomor_induk_number, 5, "0", STR_PAD_LEFT);

// Query untuk memasukkan data pengguna baru ke database
$query = "INSERT INTO users (nama, email, password, nomor_induk) VALUES ('$nama', '$email', '$hashed_password', '$new_nomor_induk')";

if (mysqli_query($koneksi, $query)) {
    echo "Pendaftaran berhasil! Nomor Induk Anda adalah: $new_nomor_induk. Silakan login <a href='login.html'>di sini</a>.";
} else {
    echo "Pendaftaran gagal: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
?>
