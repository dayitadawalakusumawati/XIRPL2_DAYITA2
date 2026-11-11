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
					<th>NOMOR BLOK</th>
					<th>TANGGAL PARKIR</th>
					<th>USER</th>
				</tr>
				<?php 
				$parkir = mysqli_query($koneksi,"select * from parkir limit 2");
				$no = 1;
                $user = mysqli_query($koneksi,"select * from user limit 2");
				while ($d=mysqli_fetch_array($parkir))
                {
                    $df=mysqli_fetch_array($user);
				?>
					<tr>
                        <td><?php echo $no++; ?></td>
						<td><?php echo $d['no_kendaraan']; ?></td>
                        <td><?php echo $d['no_blok']; ?></td>
                        <td><?php echo $d['tanggal']; ?></td>
                        <td><?php echo $df['nama_user']; ?></td>
                    </tr>
                <?php
				}
				?>
			</table>
		</div>


