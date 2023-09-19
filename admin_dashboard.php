<?php
session_start();

// Periksa apakah admin sudah login, jika tidak, alihkan ke halaman login admin
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Koneksi ke database (Gantilah ini sesuai dengan informasi koneksi Anda)
$host = "localhost";
$username = "root";
$password = "";
$database = "pendaftaran_itb";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Fungsi untuk mengambil daftar pengguna
function getDaftarPengguna($koneksi) {
    $query = "SELECT * FROM users";
    $result = mysqli_query($koneksi, $query);
    $daftar_pengguna = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $daftar_pengguna[] = $row;
    }

    return $daftar_pengguna;
}

// Fungsi untuk menambahkan pengguna baru
function tambahUser($koneksi, $nama, $email, $password) {
    $query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')";
    $result = mysqli_query($koneksi, $query);
    return $result;
}

// Fungsi untuk menghapus pengguna berdasarkan ID
function hapusUser($koneksi, $user_id) {
    $query = "DELETE FROM users WHERE id = $user_id";
    $result = mysqli_query($koneksi, $query);
    return $result;
}

// Proses penambahan pengguna jika data telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah_user"])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash password (opsional, sesuaikan dengan kebutuhan)
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Panggil fungsi untuk menambahkan pengguna baru
    $result = tambahUser($koneksi, $nama, $email, $password);

    if ($result) {
        $pesan_sukses = "Pengguna baru berhasil ditambahkan.";
    } else {
        $pesan_gagal = "Gagal menambahkan pengguna baru.";
    }
}

// Proses penghapusan pengguna jika ID pengguna dihapus dikirimkan
if (isset($_GET["hapus_user"])) {
    $user_id = $_GET["hapus_user"];

    // Panggil fungsi untuk menghapus pengguna
    $result = hapusUser($koneksi, $user_id);

    if ($result) {
        $pesan_sukses = "Pengguna berhasil dihapus.";
    } else {
        $pesan_gagal = "Gagal menghapus pengguna.";
    }
}

// Ambil daftar pengguna
$daftar_pengguna = getDaftarPengguna($koneksi);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 0;
        background-color: #f4f4f4;
    }

    h2 {
        color: #333;
    }

    h3 {
        margin-top: 20px;
        color: #333;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    button {
        background-color: #007BFF;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
    }

    button:hover {
        background-color: #0056b3;
    }

    a {
        text-decoration: none;
        color: #007BFF;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>
    <h2>Selamat datang, Admin!</h2>

    <!-- Form untuk menambahkan pengguna baru -->
    <h3>Tambah Pengguna Baru</h3>
    <?php if (isset($pesan_sukses)) { ?>
        <p style="color: green;"><?php echo $pesan_sukses; ?></p>
    <?php } ?>
    <?php if (isset($pesan_gagal)) { ?>
        <p style="color: red;"><?php echo $pesan_gagal; ?></p>
    <?php } ?>
    <form method="post" action="">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit" name="tambah_user">Tambah Pengguna</button>
    </form>

    <!-- Daftar Pengguna -->
    <h3>Daftar Pengguna</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($daftar_pengguna as $pengguna) { ?>
            <tr>
                <td><?php echo $pengguna["id"]; ?></td>
                <td><?php echo $pengguna["nama"]; ?></td>
                <td><?php echo $pengguna["email"]; ?></td>
                <td><a href="admin_dashboard.php?hapus_user=<?php echo $pengguna["id"]; ?>">Hapus</a></td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <a href="admin_logout.php">Logout</a>
</body>
</html>
