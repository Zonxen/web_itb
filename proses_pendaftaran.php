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

// Fungsi untuk menghasilkan nomor_induk unik
function generateNomorInduk($koneksi) {
    // Ambil tahun masuk terbaru
    $tahun_masuk = date("Y");

    // Ambil nomor_induk terakhir untuk tahun ini
    $query = "SELECT MAX(nomor_induk) AS last_nomor_induk FROM users WHERE nomor_induk LIKE '$tahun_masuk%'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    $last_nomor_induk = $row["last_nomor_induk"];

    // Jika belum ada nomor_induk untuk tahun ini, mulai dari nomor 1
    if (!$last_nomor_induk) {
        $new_nomor_induk = $tahun_masuk . "-00001";
    } else {
        // Ambil nomor urut dari nomor_induk terakhir dan tambahkan 1
        $last_nomor_urut = intval(substr($last_nomor_induk, -5));
        $new_nomor_urut = $last_nomor_urut + 1;

        // Format nomor_induk sesuai aturan (misalnya, menggunakan 5 digit)
        $new_nomor_induk = $tahun_masuk . "-" . str_pad($new_nomor_urut, 5, "0", STR_PAD_LEFT);
    }

    return $new_nomor_induk;
}

// Fungsi untuk menghasilkan nomor tes unik
function generateNomorTes($koneksi) {
    // Ambil nomor tes terakhir yang digunakan
    $query = "SELECT MAX(nomor_test) AS last_nomor_test FROM users";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    $last_nomor_test = $row["last_nomor_test"];

    // Jika belum ada nomor tes, mulai dari nomor 1, jika tidak tambahkan 1
    if ($last_nomor_test === null) {
        $new_nomor_test = 1;
    } else {
        $new_nomor_test = $last_nomor_test + 1;
    }

    return $new_nomor_test;
}



// Proses pendaftaran pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nama"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash password sebelum menyimpannya ke database (gunakan teknik keamanan yang lebih kuat dalam produksi)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate nomor_induk secara otomatis
    $new_nomor_induk = generateNomorInduk($koneksi);
    $new_nomor_test = generateNomorTes($koneksi);

    // Query untuk memasukkan data pengguna baru ke database
    $query = "INSERT INTO users (nama, email, password, nomor_induk, nomor_test) VALUES ('$nama', '$email', '$hashed_password', '$new_nomor_induk', '$new_nomor_test')";

    if (mysqli_query($koneksi, $query)) {
        echo "Pendaftaran berhasil! Nomor Induk Anda adalah: $new_nomor_induk. Silakan login <a href='login.html'>di sini</a>.";
        echo "Pendaftaran berhasil! Nomor Test Anda adalah: $new_nomor_test. Silakan login <a href='login.html'>di sini</a>.";
    } else {
        echo "Pendaftaran gagal: " . mysqli_error($koneksi);
    }
}

// Tutup koneksi ke database
mysqli_close($koneksi);
?>
