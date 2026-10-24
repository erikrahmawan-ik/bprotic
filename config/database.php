<?php
// config/database.php
// Konfigurasi koneksi MySQL Laragon

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_bprotic_toko";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>