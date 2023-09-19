<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Hasil Tes</title>
</head>
<body>
    <header>
        <h1>Hasil Tes Calon Mahasiswa Baru</h1>
    </header>

    <section class="result">
        <?php
        // Simpan data pengguna yang masuk (Anda harus mengatur ini sesuai dengan metode otentikasi Anda)
        $user_id = 1; // Contoh ID pengguna yang masuk

        // Koneksi ke database (Gantilah ini sesuai dengan informasi koneksi Anda)
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "pendaftaran_itb";

        $koneksi = mysqli_connect($host, $username, $password, $database);

        if (!$koneksi) {
            die("Koneksi database gagal: " . mysqli_connect_error());
        }

        // Query untuk mengambil hasil tes pengguna
        $query = "SELECT skor, lulus_test FROM test_results WHERE user_id = $user_id";
        $hasil = mysqli_query($koneksi, $query);

        if (!$hasil) {
            die("Query gagal: " . mysqli_error($koneksi));
        }

        if (mysqli_num_rows($hasil) > 0) {
            $row = mysqli_fetch_assoc($hasil);
            $skor = $row["skor"];
            $lulus = $row["lulus_test"];

            echo "<h2>Skor Anda: $skor</h2>";

            if ($lulus) {
                echo "<p>Selamat, Anda lulus tes!</p>";
            } else {
                echo "<p>Maaf, Anda tidak lulus tes.</p>";
            }
        } else {
            echo "<p>Anda belum mengikuti tes.</p>";
        }

        // Tutup koneksi ke database
        mysqli_close($koneksi);
        ?>
        <a href="index.html">Kembali ke Halaman Utama</a>
    </section>

    <footer>
        &copy; 2023 Aplikasi Pendaftaran Mahasiswa Baru
    </footer>
</body>
</html>
