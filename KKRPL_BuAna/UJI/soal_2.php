<html>
    <head>
        <title>Sistem Informasi Laundry</title>
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    </head>

    <body style="background: #f4f5f4;">
        <br><br>
        <center>
            <h2>DATA PARKIR KENDARAAN</h2>
        </center>
        <br><br>

<?php
    $koneksi = mysqli_connect("localhost","root","","parkir");

    if (mysqli_connect_errno()) {
        echo "Koneksi Database Gagal : " .mysqli_connect_errno();
    }
?>
		    <div class="panel-body">
			<table class="table table-bordered table-striped">
				<tr>
					<th width="1%">NO</th>
					<th>NOMOR KENDARAAN</th>
					<th>STATUS</th>
					<th>LEVEL USER</th>
				</tr>
				<?php 
				$parkir = mysqli_query($koneksi,"select * from parkir limit 2");
				$no = 1;
				while ($d=mysqli_fetch_array($parkir))
                {
				?>
					<tr>
                        <td><?php echo $no++; ?></td>
						<td><?php echo $d['no_kendaraan']; ?></td>
                        <td>
                        <?php
                        if ($d['no_blok']=="1"){
                        echo "<div class=>Parkir</div>";
                        }elseif ($d['no_blok']=="2"){
                        echo "<div class=>Keluar</div>";
                        }
                        ?>
                        </td>
                        <td>
                        <?php
                        if ($d['kd_user']=="1"){
                        echo "<div class=>Petugas</div>";
                        }elseif ($d['kd_user']=="2"){
                        echo "<div class=>Super Admin</div>";
                        }
                        ?>
                        </td>
                    </tr>
                <?php
				}
				?>
			</table>
		</div>
</html>

