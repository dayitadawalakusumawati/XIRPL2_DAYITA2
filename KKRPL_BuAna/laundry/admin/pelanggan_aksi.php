<?php
    include '../koneksi.php';

    $nama = $_POST['nama'];
    $hp = $_POST['hp'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi,"insert into pelanggan values('','$nama','$hp','$alamat')");

    echo "<script>
        window.alert('Data berhasil disimpan');
        window.location.href = 'pelanggan.php';
    </script>";
?>