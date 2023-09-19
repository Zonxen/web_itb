<?php
// Mulai sesi (pastikan ini ada di setiap halaman yang memerlukan autentikasi)
session_start();

// Hancurkan sesi pengguna (mengakhiri sesi)
session_destroy();

// Alihkan pengguna ke halaman login atau halaman lain yang sesuai
header("Location: login.html"); // Ganti dengan halaman login atau halaman lain yang sesuai
exit();
?>
