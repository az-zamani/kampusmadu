<?php

// Informasi koneksi ke database
$host = 'localhost'; // Sesuaikan dengan host Anda
$user = 'root'; // Ganti dengan username MySQL Anda
$pass = ''; // Ganti dengan password MySQL Anda
$db_name = 'kampusmadu'; // Ganti dengan nama database yang ingin Anda gunakan

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db_name);

// Memeriksa koneksi
// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>