<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <title>Daftar Barang</title>
    <style>
        body {
            display: flex;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .main-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            overflow-x: auto;
        }

        .card {
            margin-top: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <?php require("sidebar.php"); ?>
    <div class="main-container">
        <div class="content" id="content">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary-subtle text-center">
                        Daftar Barang
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Daftar Barang</h5>
                        <?php if(isset($_GET['alert'])): ?>
                            <div class="alert alert-<?php echo $_GET['alert_type']; ?> alert-dismissible fade show" role="alert">
                                <?php echo $_GET['alert']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table id="barangTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Harga Barang</th>
                                        <th>Jumlah Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'koneksi.php';

                                    $sql = "SELECT id_barang, nama_barang, harga_barang, jumlah_stok FROM barang WHERE is_deleted = 0";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["nama_barang"] . "</td>";
                                            echo "<td>Rp " . number_format($row["harga_barang"], 0, ',', '.') . "</td>";
                                            echo "<td>" . $row["jumlah_stok"] . "</td>";
                                            echo "<td>
                                                    <a href='edit_barang.php?id=" . $row["id_barang"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                                    <a href='hapus_barang.php?id=" . $row["id_barang"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus barang ini?\")'>Hapus</a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                                    }

                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $('#barangTable').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                pageLength: 10
            });
        });
    </script>
</body>
</html>
