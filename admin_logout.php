<?php
session_start();

// Hapus sesi admin
if (isset($_SESSION["admin_logged_in"])) {
    unset($_SESSION["admin_logged_in"]);
    unset($_SESSION["admin_id"]);
}

// Redirect ke halaman login admin
header("Location: admin_login.php");
exit();
?>
