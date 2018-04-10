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
    <meta charset="utf-8">
    <title>
      SISATYA ADMIN PANEL
    </title>
    <style media="screen">
    @import "bourbon";

body {
background-image: url("assets/img/bg.jpg");
background-size: cover;
}

.wrapper {
margin-top: 80px;
margin-bottom: 80px;
}

.form-signin {
max-width: 380px;
padding: 15px 35px 45px;
margin: 0 auto;
background-color: #fff;
border: 1px solid rgba(0,0,0,0.1);

.form-signin-heading,
.checkbox {
  margin-bottom: 30px;
}

.checkbox {
  font-weight: normal;
}

.form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  @include box-sizing(border-box);

  &:focus {
    z-index: 2;
  }
}

input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

input[type="password"] {
  margin-bottom: 20px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
}

    </style>
    <link href="assets/css/modern.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  </head>
  <body>
    <div class="wrapper">
  <form class="form-signin" method="post">
    <h3 class="form-signin-heading">SISATYA Login</h3>
    <label for="">Username</label>
    <input type="text" class="form-control" name="username" placeholder="Email Address" required="" autofocus="" />
    <label for="">Password</label>
    <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
    <!--<label class="checkbox">
      <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
    </label>-->
    <br>
    <button class="btn btn-lg btn-primary" type="submit" name="login" style="margin-bottom:10px;">Login</button>
    <?php echo $notif ?>
  </form>
</div>
  </body>
</html>
