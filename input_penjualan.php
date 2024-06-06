<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
// Memanggil file koneksi.php untuk melakukan koneksi ke database
include 'koneksi.php';

// Mengambil data yang dikirimkan melalui metode POST dari formulir input
$id_barang = $_POST['tbarang'];
$jumlah_terjual = $_POST['tjumlah'];
$harga_total = $_POST['harga_hidden'];
// $harga_hidden = $_POST['harga_hidden'];
$tanggal_jual = date("Y-m-d"); // Menggunakan tanggal sistem
$keterangan = $_POST['tketerangan'];

// Periksa apakah stok mencukupi sebelum melakukan penyimpanan
$sql_check_stok = "SELECT jumlah_stok FROM barang WHERE id_barang = '$id_barang'";
$result_stok = $conn->query($sql_check_stok);
if ($result_stok->num_rows > 0) {
    $row_stok = $result_stok->fetch_assoc();
    $stok_saat_ini = $row_stok['jumlah_stok'];
    if ($jumlah_terjual > $stok_saat_ini) {
        // Stok tidak mencukupi, kirimkan pesan JSON
        $response = array("type" => "error", "message" => "Stok tidak mencukupi");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit; // Hentikan eksekusi lebih lanjut
    }
} else {
    // Barang tidak ditemukan, kirimkan pesan JSON
    $response = array("type" => "error", "message" => "Barang tidak ditemukan");
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Hentikan eksekusi lebih lanjut
}

// Mulai transaksi
$conn->begin_transaction();

try {
    // Query untuk memasukkan data penjualan ke tabel penjualan
    $sql_insert = "INSERT INTO penjualan (id_barang, jumlah_barang_terjual, harga_total, tanggal_penjualan, keterangan) 
                   VALUES ('$id_barang', '$jumlah_terjual', '$harga_total', '$tanggal_jual', '$keterangan')";
    if (!$conn->query($sql_insert)) {
        throw new Exception("Error: " . $sql_insert . "<br>" . $conn->error);
    }

    // Query untuk mengurangi stok barang di tabel barang
    $sql_update = "UPDATE barang SET jumlah_stok = jumlah_stok - $jumlah_terjual WHERE id_barang = '$id_barang'";
    if (!$conn->query($sql_update)) {
        throw new Exception("Error: " . $sql_update . "<br>" . $conn->error);
    }

    // Jika semua query berhasil, commit transaksi
    $conn->commit();

    // Data berhasil disimpan, kirimkan pesan sukses dalam format JSON
    $response = array("type" => "success", "message" => "Data berhasil disimpan dan stok telah diperbarui");
} catch (Exception $e) {
    // Jika terjadi kesalahan, rollback transaksi
    $conn->rollback();

    // Kirimkan pesan error dalam format JSON
    $response = array("type" => "error", "message" => $e->getMessage());
}

// Menutup koneksi ke database
$conn->close();

// Menghasilkan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
