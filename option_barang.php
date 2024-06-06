<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", '', "kampusmadu");

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Query SQL untuk mengambil data barang dari tabel "Barang"
$sql = "SELECT id_barang, nama_barang, harga_barang FROM barang";
$result = mysqli_query($koneksi, $sql);

// Buat array untuk menampung data barang
$data_barang = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data_barang[] = $row;
}

// Tutup koneksi
mysqli_close($koneksi);

// Kembalikan data barang sebagai JSON
echo json_encode($data_barang);
?>
