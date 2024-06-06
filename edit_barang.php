<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$message = '';
$message_type = '';

if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    $sql = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga_barang = $_POST['harga_barang'];
    $jumlah_stok = $_POST['jumlah_stok'];

    $sql = "UPDATE barang SET nama_barang='$nama_barang', harga_barang='$harga_barang', jumlah_stok='$jumlah_stok' WHERE id_barang='$id_barang'";

    if ($conn->query($sql) === TRUE) {
        $message = "Data barang berhasil diperbarui.";
        $message_type = "success";
        header('Location: edit_barang.php?id='.$id_barang.'&message='.urlencode($message).'&type='.$message_type);
        exit();
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        $message_type = "danger";
    }
}

if (isset($_GET['message']) && isset($_GET['type'])) {
    $message = $_GET['message'];
    $message_type = $_GET['type'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
            
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }

        function removeFormatRupiah(angka) {
            return angka.replace(/[^0-9]/g, '');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var hargaInput = document.getElementById('harga_barang');

            hargaInput.addEventListener('keyup', function(e) {
                hargaInput.value = formatRupiah(this.value, 'Rp ');
            });

            var form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                hargaInput.value = removeFormatRupiah(hargaInput.value);
            });
        });
    </script>
</head>
<body>
    <?php require("sidebar.php"); ?>
    <div class="container">
        <div class="content" id="content">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary-subtle">
                        Edit Barang
                    </div>
                    <div class="card-body">
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="edit_barang.php">
                            <input type="hidden" name="id_barang" value="<?php echo $row['id_barang']; ?>">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang:</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $row['nama_barang']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="harga_barang">Harga Barang:</label>
                                <input type="text" class="form-control" id="harga_barang" name="harga_barang" value="<?php echo number_format($row['harga_barang'], 0, ',', '.'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_stok">Jumlah Stok:</label>
                                <input type="number" class="form-control" id="jumlah_stok" name="jumlah_stok" value="<?php echo $row['jumlah_stok']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
