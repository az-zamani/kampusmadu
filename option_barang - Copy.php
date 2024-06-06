<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "kampusm3_admin_stok", '.(JwcVDc-b$s', "kampusm3 _kampusmadu_stok");

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
