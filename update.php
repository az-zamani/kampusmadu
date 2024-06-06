<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
    // Fungsi untuk memformat angka ke dalam format Rupiah
    function formatRupiah($angka){
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kampusmadu</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script>
        function resetForm() {
            $('#namabarang').val(null).trigger('change'); // Reset nilai dropdown
            document.getElementById("jumlah").value = ""; // Reset nilai input jumlah
            document.getElementById("harga").value = ""; // Reset nilai input harga
            document.getElementById("keterangan").value = ""; // Reset nilai textarea keterangan
        }

        $(document).ready(function() {
            $('#namabarang').select2({
                placeholder: 'Pilih Barang...',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: 'fetch.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.text,
                                    harga_satuan: item.harga_satuan
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#penjualanTable').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: [
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

            // Event listener for selecting barang
            $('#namabarang').on('select2:select', function (e) {
                let data = e.params.data;
                $('#jumlah').val(''); // Reset jumlah input
            });
        });
    </script>
    <style>
        .select2-container--bootstrap .select2-selection--single .select2-selection__rendered {
            line-height: 2.25; /* Match Bootstrap input height */
        }
        .select2-container--bootstrap .select2-selection--single {
            height: calc(2.25rem + 2px); /* Match Bootstrap input height */
        }
        .select2-container--bootstrap .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px); /* Match Bootstrap input height */
            right: 10px; /* Adjust arrow position */
        }
    </style>
  </head>
  <body>
    <?php require("sidebar.php"); ?>
    <div class="content" id="content">
        <h3 class="text-center">Update Penjualan</h3>
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                    <!-- START CARD -->
                    <div class="card mb-3">
                        <div class="card-header bg-primary-subtle">Data Barang</div>
                        <div class="card-body">
                            <form action="input_penjualan.php" id="input_jual" method="POST">
                                <div class="col mb-3">
                                    <label for="namabarang" class="form-label">Nama Barang</label>
                                    <select class="form-select" id="namabarang" name="tbarang" style="width: 100%;">
                                        <option value="" selected>Pilih Barang...</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control" name="tjumlah" id="jumlah" placeholder="Masukkan Jumlah">
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="text" class="form-control money" id="harga" placeholder="Masukkan Harga" name="tharga" readonly>
                                        <input type="hidden" id="harga_hidden" name="harga_hidden">
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="ttanggal" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                    <textarea class="form-control" name="tketerangan" id="keterangan"></textarea>
                                </div>
                                <div class="text-center mb-3">
                                    <hr>
                                    <button class="btn btn-primary" name="binput" type="submit">Input</button>
                                    <button class="btn btn-danger" name="breset" type="reset" onclick="resetForm()">Reset</button>
                                </div>
                                <div class="text-end">
                                    <a class="link-opacity-75 text-mb-end" href="rekap.php">Rekap</a>
                                </div>
                            </form>
                            <div id="alertContainer"></div>
                            <script>
    $(document).ready(function() {
        $('#input_jual').submit(function(e) {
            e.preventDefault(); // Mencegah form melakukan submit bawaan

            $.ajax({
                type: 'POST',
                url: 'input_penjualan.php',
                data: $('#input_jual').serialize(),
                success: function(response) {
                    if (response.type == 'success') {
                        // Menampilkan alert Bootstrap jika data berhasil ditambahkan
                        $('#alertContainer').html(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            response.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>'
                        );

                        // Kosongkan form setelah submit
                        $('#input_jual')[0].reset();

                        // Refresh halaman setelah beberapa detik
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    } else {
                        // Menampilkan alert Bootstrap jika terjadi kesalahan
                        $('#alertContainer').html(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            response.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    // Menampilkan alert Bootstrap jika terjadi error pada saat melakukan AJAX
                    $('#alertContainer').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        'Error: ' + error +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>'
                    );
                }
            });
        });
    });
</script>
                        </div>
                    </div>
                    <!-- END CARD -->
                    <!-- CARD LAPORAN -->
                    <div class="card">
                        <div class="card-header text-center bg-primary-subtle">Laporan Penjualan</div>
                        <div class="card-body">
                            <table class="table table-sm" id="penjualanTable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal Penjualan</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data dari database akan dimasukkan di sini -->
                                    <?php
                                    // Memanggil file koneksi.php untuk melakukan koneksi ke database
                                    include 'koneksi.php';

                                    // Query untuk mengambil data dari tabel penjualan dan barang
                                    $sql = "SELECT 
                                                penjualan.id_penjualan, 
                                                penjualan.tanggal_penjualan,
                                                barang.nama_barang, 
                                                penjualan.jumlah_barang_terjual, 
                                                penjualan.harga_total, 
                                                barang.jumlah_stok 
                                            FROM 
                                                penjualan 
                                            JOIN 
                                                barang ON penjualan.id_barang = barang.id_barang";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $no = 1;
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<th scope='row'>" . $no++ . "</th>";
                                            echo "<td>" . $row["tanggal_penjualan"] . "</td>";
                                            echo "<td>" . $row["nama_barang"] . "</td>";
                                            echo "<td>" . $row["jumlah_barang_terjual"] . "</td>";
                                            echo "<td>" . formatRupiah($row["harga_total"]) . "</td>";
                                            echo "<td>" . $row["jumlah_stok"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                                    }

                                    // Menutup koneksi ke database
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END CARD LAPORAN -->
                </div>
            </div>
        </div>
    </div>
    <script src="bootsrap.js"></script>
    <script>
    $(document).ready(function() {
        // Event listener saat nilai input jumlah berubah
        $('#jumlah').on('input', function() {
            // Ambil nilai jumlah dari input
            var jumlah = $(this).val();
            
            // Hilangkan karakter non-digit dari input harga
            var hargaInput = $('#harga').val().replace(/\D/g,'');

            // Lakukan AJAX request untuk mengambil harga barang dari database
            $.ajax({
                url: 'option_barang.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Cari harga barang yang sesuai dari data yang diambil
                    var hargaBarang = data.find(function(barang) {
                        return barang.id_barang == $('#namabarang').val();
                    });
                    
                    // Hitung harga total berdasarkan harga per barang dan jumlah
                    var hargaTotal = jumlah * hargaBarang.harga_barang;

                    // Set nilai harga pada input harga dengan format Rupiah
                    $('#harga').val(formatRupiah(hargaTotal));

                    // Set nilai harga asli (decimal) pada input hidden
                    $('#harga_hidden').val(hargaTotal);
                    console.log(response); // Cetak respons JSON ke konsol
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Fungsi untuk memformat angka ke dalam format Rupiah
        function formatRupiah(angka) {
            var number_string = angka.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }
    });
    </script>
    <!-- tanggal -->
    <script>
        window.onload = function() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // Januari dimulai dari 0
            var yyyy = today.getFullYear();
            var formattedDate = yyyy + '-' + mm + '-' + dd;
            document.getElementById('tanggal').value = formattedDate;
        }
    </script>
  </body>
</html>
