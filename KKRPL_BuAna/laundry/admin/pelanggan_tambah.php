<?php
    include 'header.php';
?>

<div class="container">
    <br><br><br>
    <div class="panel">
        <div class="panel-heading">
            <h4>Tambah Pelanggan Baru</h4>
        </div>
        <div class="panel-body">
            <form method="post" action="pelanggan_aksi.php">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama">
                </div>
                <div class="form-group">
                    <label>HP</label>
                    <input type="text" name="hp" class="form-control" placeholder="Masukkan Nomor Hp">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat">
                </div>
                <br>
                <input type="submit" class="btn btn-primary" value="Simpan">
            </form>
        </div>
    </div>
</div>