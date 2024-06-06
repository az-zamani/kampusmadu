<?php
// Informasi koneksi ke database
$host = 'localhost'; // Sesuaikan dengan host Anda
$user = 'kampusm3_admin_stok'; // Ganti dengan username MySQL Anda
$pass = '.(JwcVDc-b$s'; // Ganti dengan password MySQL Anda
$db_name = 'kampusm3_kampusmadu_stok'; // Ganti dengan nama database yang ingin Anda gunakan

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db_name);

// Memeriksa koneksi
// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>