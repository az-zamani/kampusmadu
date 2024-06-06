<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<?php
// Memanggil file koneksi.php untuk melakukan koneksi ke database
include 'koneksi.php';

// Fungsi untuk memformat angka ke dalam format Rupiah
function formatRupiah($angka){
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Inisialisasi variabel filter
$filter_nama_barang = '';
$filter_tanggal_penjualan = '';

// Cek apakah form filter telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai filter
    $filter_nama_barang = $_POST['nama_barang'];
    // $filter_tanggal_penjualan = $_POST['tanggal_penjualan'];

    // Buat kondisi filter
    $filter_condition = '';
    if (!empty($filter_nama_barang)) {
        $filter_condition .= " AND barang.nama_barang = '$filter_nama_barang'";
    }
    if (!empty($filter_tanggal_penjualan)) {
        $filter_condition .= " AND penjualan.tanggal_penjualan = '$filter_tanggal_penjualan'";
    }

// Inisialisasi variabel filter
$filter_tanggal_awal = '';
$filter_tanggal_akhir = '';

// Cek apakah form filter telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai filter
    $filter_nama_barang = $_POST['nama_barang'];
    $filter_tanggal_awal = $_POST['tanggal_awal'];
    $filter_tanggal_akhir = $_POST['tanggal_akhir'];

    // Buat kondisi filter
    $filter_condition = '';
    if (!empty($filter_nama_barang)) {
        $filter_condition .= " AND barang.nama_barang = '$filter_nama_barang'";
    }
    if (!empty($filter_tanggal_awal)) {
        $filter_condition .= " AND penjualan.tanggal_penjualan >= '$filter_tanggal_awal'";
    }
    if (!empty($filter_tanggal_akhir)) {
        $filter_condition .= " AND penjualan.tanggal_penjualan <= '$filter_tanggal_akhir'";
    }

    // Query untuk mengambil data dari tabel penjualan dengan filter dan mengelompokkan berdasarkan nama_barang dan tanggal_penjualan
    $sql = "SELECT 
                penjualan.tanggal_penjualan, 
                barang.nama_barang, 
                SUM(penjualan.jumlah_barang_terjual) AS total_jumlah,
                SUM(penjualan.harga_total) AS total_harga
            FROM 
                penjualan 
            JOIN 
                barang ON penjualan.id_barang = barang.id_barang
            WHERE 1 $filter_condition
            GROUP BY 
                penjualan.tanggal_penjualan, 
                barang.nama_barang";
}

} else {
    // Query untuk mengambil data dari tabel penjualan tanpa filter dan mengelompokkan berdasarkan nama_barang dan tanggal_penjualan
    $sql = "SELECT 
                penjualan.tanggal_penjualan, 
                barang.nama_barang, 
                SUM(penjualan.jumlah_barang_terjual) AS total_jumlah,
                SUM(penjualan.harga_total) AS total_harga
            FROM 
                penjualan 
            JOIN 
                barang ON penjualan.id_barang = barang.id_barang
            GROUP BY 
                penjualan.tanggal_penjualan, 
                barang.nama_barang";
}

// Eksekusi query SQL
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Rekap Penjualan</title>
</head>
<body>
    <div class="wrapper">
        <?php require("sidebar.php"); ?>
        <div class="col-md-9 mx-auto">
            <div class="content" id="content">
                <div class="card">
                    <div class="card-header bg-primary-subtle">
                        Rekap Penjualan
                    </div>
                    <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="row mb-3">
                                <!-- Kolom filter nama barang -->
                                <div class="col">
                                    <label for="nama_barang" class="form-label">Nama Barang:</label>
                                    <select class="form-select" id="nama_barang" name="nama_barang">
                                        <option value="">Pilih Nama Barang...</option>
                                        <?php
                                        // Tampilkan opsi dropdown nama barang
                                        $sql_nama_barang = "SELECT DISTINCT nama_barang FROM barang WHERE is_deleted = 0";
                                        $result_nama_barang = $conn->query($sql_nama_barang);
                                        if ($result_nama_barang->num_rows > 0) {
                                            while ($row = $result_nama_barang->fetch_assoc()) {
                                                $selected = ($filter_nama_barang == $row['nama_barang']) ? 'selected' : '';
                                                echo "<option value='" . $row['nama_barang'] . "' $selected>" . $row['nama_barang'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
<!-- Kolom filter tanggal penjualan -->
<div class="col">
    <label for="tanggal_awal" class="form-label">Tanggal Awal:</label>
    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo $filter_tanggal_awal; ?>">
</div>
<div class="col">
    <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo $filter_tanggal_akhir; ?>">
</div>

                                <!-- Tombol filter -->
                                <div class="col mt-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <!-- Tombol reset -->
                                    <button type="button" class="btn btn-danger" onclick="resetForm()">Reset</button>
                                </div>
                            </div>
                        </form>
                        <table id="rekapTable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data dari database akan dimasukkan di sini -->
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 1;
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . $row["tanggal_penjualan"] . "</td>";
                                        echo "<td>" . $row["nama_barang"] . "</td>";
                                        echo "<td>" . $row["total_jumlah"] . "</td>";
                                        echo "<td>" . formatRupiah($row["total_harga"]) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootsrap.js"></script>
    <script src="script.js"></script>
    <script>
        function resetForm() {
            document.getElementById("nama_barang").value = ""; // Reset nilai dropdown nama barang
            document.getElementById("tanggal_awal").value = ""; // Reset nilai input tanggal penjualan
            document.getElementById("tanggal_akhir").value = ""; // Reset nilai input tanggal penjualan
        }

        $(document).ready(function() {
            $('#rekapTable').DataTable({
                
                dom: 'Bfrtip',
                buttons: [
                    'csvHtml5',
                    'excelHtml5',
                    {
                        extend: 'pageLength',
                        text: 'Show entries',
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
                    }
                ],
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
