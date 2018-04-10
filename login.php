<?php
require_once 'helper/helper.php';
$h=new Helper();
$notif="";
if(isset($_POST['login'])){
  $kode_satuan_kerja="";
  $nama_satuan_kerja="";
  $id_provinsi="";
  $alamat="";
  $password="";
  $nama_balai="";
  $nama_provinsi="";
  $jumlah=0;
  $username=$_POST['username'];
  $password=$_POST['password'];
  $datalogin=$h->read("SELECT COUNT(kode_satuan_kerja) AS jumlah, kode_satuan_kerja,nama_satuan_kerja,data_user.id_provinsi,
  alamat,password,nama_provinsi FROM data_user
    INNER JOIN data_provinsi ON data_user.id_provinsi=data_provinsi.id_provinsi WHERE kode_satuan_kerja=? AND password=? LIMIT 1",array($username,$password));
  foreach ($datalogin as  $value) {
    $kode_satuan_kerja=$value['kode_satuan_kerja'];
    $nama_satuan_kerja=$value['nama_satuan_kerja'];
    $id_provinsi=$value['id_provinsi'];
    $alamat=$value['alamat'];
    $password=$value['password'];
    $nama_provinsi=$value['nama_provinsi'];
    $jumlah=$value['jumlah'];
  }
  if($jumlah==1){
    session_start();
    $_SESSION['kode_satuan_kerja']=$kode_satuan_kerja;
    $_SESSION['nama_satuan_kerja']=$nama_satuan_kerja;
    $_SESSION['id_provinsi']=$id_provinsi;
    $_SESSION['alamat']=$alamat;
    $_SESSION['password']=$password;
    $_SESSION['nama_provinsi']=$nama_provinsi;
    header("location:index.php");
  }else{
    $notif="<div class='alert alert-danger'>User atau password salah</div>";
  }

}

?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Title -->
        <title>Modern | Login - Sign in</title>

        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />

        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href="assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>

        <!-- Theme Styles -->
        <link href="assets/css/modern.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>

        <script src="assets/plugins/3d-bold-navigation/js/modernizr.js"></script>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="login-box">
                                <a href="index.html" class="logo-name text-lg text-center">SISATYA</a>
                                <p class="text-center m-t-md">Login untuk menggunakan aplikasi.</p>
                                <form class="m-t-md" action="" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Email" required name="username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password" required name=password>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block" name="login">Login</button>
                                </form>
                                <p class="text-center m-t-xs text-sm">2015 &copy; Modern by Steelcoders.</p>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->


        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
        <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/plugins/pace-master/pace.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>
        <script src="assets/plugins/uniform/jquery.uniform.min.js"></script>
        <script src="assets/plugins/classie/classie.js"></script>
        <script src="assets/plugins/waves/waves.min.js"></script>
        <script src="assets/js/modern.min.js"></script>

    </body>
</html>
