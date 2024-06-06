<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

$searchTerm = isset($_GET['term']) ? $_GET['term'] : '';

if (empty($searchTerm)) {
    $sql = "SELECT id_barang, nama_barang FROM barang WHERE is_deleted = 0 LIMIT 50"; // Menampilkan 50 item pertama saat search kosong
} else {
    $sql = "SELECT id_barang, nama_barang FROM barang WHERE nama_barang LIKE '%$searchTerm%' AND is_deleted = 0 LIMIT 10";
}

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = ['id' => $row['id_barang'], 'text' => $row['nama_barang']];
    }
}

echo json_encode($data);
?>
