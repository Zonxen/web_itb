<?php
session_start();

// Koneksi ke database (Gantilah ini sesuai dengan informasi koneksi Anda)
$host = "localhost";
$username = "root";
$password = "";
$database = "pendaftaran_itb";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Cek apakah data login admin telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query untuk mencari admin berdasarkan email
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        // Admin dengan email yang sesuai ditemukan
        $admin = mysqli_fetch_assoc($result);

        // Periksa apakah kata sandi cocok (tanpa hashing)
        if ($password === $admin["password"]) {
            // Login sukses, tandai sebagai admin yang sudah login
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_id"] = $admin["id"];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Login gagal, tampilkan pesan kesalahan
            $login_error = "Email atau kata sandi salah.";
        }
    } else {
        // Login gagal, tampilkan pesan kesalahan
        $login_error = "Email atau kata sandi salah.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>
    <h2>Login Admin</h2>
    <?php if (isset($login_error)) { ?>
        <p style="color: red;"><?php echo $login_error; ?></p>
    <?php } ?>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
