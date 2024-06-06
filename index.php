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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kampusmadu</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="wrapper">
        <?php require("sidebar.php")?>
      <div class="content" id="content">
        <h3 class="text-center">Data Barang</h3>
        <div class="col-md-7 mx-auto">
          <div class="card">
            <div class="card-header bg-primary-subtle">
              Data Barang
            </div>
            <div class="card-body">
              <form action="input_barang.php" id="inputdata" method="POST">
                <div class="mb-3">
                  <label for="namabarang" class="form-label">Nama Barang</label>
                  <input type="text" class="form-control" name="tnama" id="namabarang" placeholder="Madu Murni 100%">
                </div>
                <div class="mb-3">
                  <label for="harga" class="form-label">Harga</label>
                  <input type="text" class="form-control" name="tharga" id="harga" placeholder="10000" step="0.01" min="0" max="99999999.99">
                </div>
                <div class="mb-3">
                  <label for="jumlah" class="form-label">Jumlah</label>
                  <input type="number" class="form-control" name="tjumlah" id="jumlah" placeholder="Jumlah Barang">
                </div>
                <div class="text-center mb-3">
                  <hr>
                  <div id="liveAlertPlaceholder"></div>
                  <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
                  <button class="btn btn-danger" name="breset" type="reset">Kosongkan</button>
                </div>
              </form>
              <!-- Alert container untuk menampilkan alert -->
              <div id="alertContainer"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Kode JavaScript untuk menampilkan alert -->
    <script>
      document.getElementById('inputdata').addEventListener('submit', function(event) {
          event.preventDefault(); // Menghentikan pengiriman formulir secara default
          
          // Hapus format Rupiah sebelum mengirimkan data
          let hargaInput = document.getElementById('harga');
          hargaInput.value = unformatRupiah(hargaInput.value);

          fetch('input_barang.php', {
              method: 'POST',
              body: new FormData(this)
          })
          .then(response => response.json()) // Mengonversi respons ke JSON
          .then(data => {
              if (data.type === 'success') {
                  // Menampilkan alert Bootstrap success
                  showAlert('primary', data.message);
                  // Bersihkan formulir setelah sukses
                  this.reset();
              } else {
                  // Menampilkan alert Bootstrap error
                  showAlert('danger', data.message);
              }
          })
          .catch(error => {
              console.error('Error:', error);
          });
      });

      // Fungsi untuk menghapus format Rupiah
      function unformatRupiah(angka) {
          return angka.replace(/[^0-9,-]+/g, '');
      }

      // Fungsi untuk menampilkan alert Bootstrap
      function showAlert(type, message) {
          // Buat elemen div untuk alert
          let alertDiv = document.createElement('div');
          alertDiv.className = `alert alert-${type} alert-dismissible fade show`;

          // Buat tombol close
          let closeButton = document.createElement('button');
          closeButton.className = 'btn-close';
          closeButton.setAttribute('type', 'button');
          closeButton.setAttribute('data-bs-dismiss', 'alert');
          closeButton.setAttribute('aria-label', 'Close');
          closeButton.innerHTML = '<span aria-hidden="true">&times;</span>';

          // Tambahkan tombol close ke dalam alertDiv
          alertDiv.appendChild(closeButton);

          // Tambahkan pesan ke dalam alertDiv
          alertDiv.appendChild(document.createTextNode(message));

          // Tampilkan alertDiv di dalam alertContainer
          document.getElementById('alertContainer').appendChild(alertDiv);

          // Tambahkan event listener untuk tombol close
          closeButton.addEventListener('click', function() {
              // Hapus elemen notifikasi alert dari DOM saat tombol close diklik
              alertDiv.remove();
          });

          // Hilangkan alert setelah beberapa detik
          setTimeout(function() {
              alertDiv.remove();
          }, 3000); // Waktu dalam milidetik (5000 ms = 5 detik)
      }
  </script>

  <!-- JavaScript untuk memformat input harga -->
  <script>
    document.getElementById('harga').addEventListener('input', function(event) {
        this.value = formatRupiah(this.value);
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
