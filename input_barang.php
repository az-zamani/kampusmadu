<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
// Memanggil file koneksi.php untuk melakukan koneksi ke database
include 'koneksi.php';

// Mengambil data yang dikirimkan melalui metode POST dari formulir input_data.php
$nama_barang = $_POST['tnama'];
$harga_barang = $_POST['tharga'];
$jumlah_stok = $_POST['tjumlah'];

// Menyimpan data ke dalam tabel barang
$sql = "INSERT INTO barang (nama_barang, harga_barang, jumlah_stok) VALUES ('$nama_barang', '$harga_barang', '$jumlah_stok')";

if ($conn->query($sql) === TRUE) {
    // Data berhasil disimpan, kirimkan pesan sukses dalam format JSON
    $response = array("type" => "success", "message" => "Data berhasil disimpan");
} else {
    // Terjadi kesalahan, kirimkan pesan error dalam format JSON
    $response = array("type" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error);
}

// Menutup koneksi ke database
$conn->close();

// Menghasilkan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>