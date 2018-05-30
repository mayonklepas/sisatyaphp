<?php
include_once 'navbar.php';
if ($_SESSION['tipe']!=1) {
  header("location:aksesditolak.php");
}
require_once "helper/helper.php";
$h=new Helper();
$skode_satuan_kerja="";
$snama_satuan_kerja="";
$sid_provinsi="";
$snama_provinsi="";
$salamat="";
$spassword="";
$notif="";
if(isset($_GET['id'])){
  $skode_satuan_kerja=$_GET['id'];
  $select=$h->read("SELECT kode_satuan_kerja,nama_satuan_kerja,data_user.id_provinsi,alamat,password,nama_provinsi FROM data_user
    INNER JOIN data_provinsi ON data_user.id_provinsi=data_provinsi.id_provinsi WHERE kode_satuan_kerja=?",array($skode_satuan_kerja));
  foreach ($select as $value) {
    $snama_satuan_kerja=$value['nama_satuan_kerja'];
    $sid_provinsi=$value['id_provinsi'];
    $snama_provinsi=$value['nama_provinsi'];
    $salamat=$value['alamat'];
    $spassword=$value['password'];
  }
}

$dataprovinsi=$h->read("SELECT id_provinsi,nama_provinsi FROM data_provinsi ORDER BY id_provinsi ASC",null);

if(isset($_POST['simpan'])){
  $kode_satuan_kerja=$_POST['kode_satuan_kerja'];
  $nama_satuan_kerja=$_POST['nama_satuan_kerja'];
  $id_provinsi=$_POST['id_provinsi'];
  $alamat=$_POST['alamat'];
  $password=$_POST['password'];
  if($skode_satuan_kerja==""){
    $insert=$h->exec("INSERT INTO data_user(kode_satuan_kerja,nama_satuan_kerja,id_provinsi,alamat,password) VALUES(?,?,?,?,?)",
    array($kode_satuan_kerja,$nama_satuan_kerja,$id_provinsi,$alamat,$password));
    if($insert){    
    $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
    array($_SESSION['kode_satuan_kerja'],"Menambah data user dengan id ".$kode_satuan_kerja.""));
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='data-user.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_user SET kode_satuan_kerja=?,nama_satuan_kerja=?,id_provinsi=?,alamat=?,password=? WHERE kode_satuan_kerja=?",
    array($kode_satuan_kerja,$nama_satuan_kerja,$id_provinsi,$alamat,$password,$skode_satuan_kerja));
    if($update){
        $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
        array($_SESSION['kode_satuan_kerja'],"Mengedit data user dengan id ".$skode_satuan_kerja.""));
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='data-user.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'><b>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }

}

?>


<script type="text/javascript">
  $(document).ready(function(){
    $(".aksi").submit(function(event){
      $(".simpan").html("<i class='menu-icon icon-refresh'></i> Sedang Menyimpan");
      $(this).submit();
      event.preventDefault();
    });
    $(".alert").click(function(){
      $(this).hide();
    });
  });
</script>

<div id="main-wrapper" class="container">
<div class="row">
<div class="col-md-12">
<?php echo $notif ?>
<div class="panel panel-white">
    <div class="panel-heading clearfix">
        <h4 class="panel-title">Input Data User</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal aksi" method="POST">
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Kode Satuan Kerja</label>
                <div class="col-sm-10">
                    <input type="text" name="kode_satuan_kerja" value="<?php echo $skode_satuan_kerja?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Satuan Kerja</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_satuan_kerja" required=required class="form-control" value="<?php echo $snama_satuan_kerja ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Provinsi</label>
                <div class="col-sm-10">
                  <select class="selectpicker form-control" data-live-search="true" name="id_provinsi">
                    <?php foreach ($dataprovinsi as $value): ?>
                        <option value="<?php echo $value['id_provinsi'] ?>" data-tokens="<?php echo $value['nama_provinsi'] ?>"><?php echo $value['nama_provinsi'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" name="alamat" required=required class="form-control" value="<?php echo $salamat ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" required=required class="form-control" value="<?php echo $spassword ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Retype Password</label>
                <div class="col-sm-10">
                    <input type="password" name="repassword" required=required class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <button type="submit" name="simpan" class="btn btn-primary simpan"> <i class="menu-icon icon-paper-plane"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>

<?php include_once 'footer.php';

?>
