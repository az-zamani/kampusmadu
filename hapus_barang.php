<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Update data barang ke database untuk menandai sebagai dihapus
    $sql = "UPDATE barang SET is_deleted = 1 WHERE id_barang = '$id_barang'";

    if ($conn->query($sql) === TRUE) {
        $alert = "Data barang berhasil dihapus.";
        $alert_type = "success";
    } else {
        $alert = "Error: " . $conn->error;
        $alert_type = "danger";
    }

    $conn->close();
    header('Location: edit.php?alert=' . urlencode($alert) . '&alert_type=' . $alert_type);
    exit();
}
?>
