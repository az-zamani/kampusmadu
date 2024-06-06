$(document).ready(function() {
    // Event listener saat nilai input jumlah berubah
    $('#jumlah').on('input', function() {
        // Ambil nilai jumlah dari input
        var jumlah = $(this).val();
        
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

                // Set nilai harga pada input harga
                $('#harga').val(hargaTotal);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});