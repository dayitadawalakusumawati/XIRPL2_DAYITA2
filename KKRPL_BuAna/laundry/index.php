<html>
    <head>
        <title>Sistem Informasi Laundry</title>
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    </head>
    <body style="background: #92f1cb;">
        <br><br>
        <center>
            <h2>SISTEM INFORMASI LAUNDRY</h2>
        </center>
        <br><br>

        <div class="container">
            <div class="col-md-4 col-md-offset-4">

            <?php
                if (isset($_GET['pesan'])){
                    if ($_GET['pesan'] == 'gagal') {
                        echo "<div>Login gagal ! Username atau Password Salah!</div>";
                    }elseif ($_GET['pesan'] == 'logout') {
                        echo "<div class='alert alert-info'>Anda telah berhasil Logout!</div>";
                    }elseif ($_GET['pesan'] == 'belum_login') {
                        echo "<div class='alert alert-danger'>Anda harus login untuk mengakses halaman admin!</div>";
                    }
                }
             ?>

                <form action="login.php" method="post">
                    <div class="panel">
                        <br>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Log In">
                        </div>
                        <br>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>