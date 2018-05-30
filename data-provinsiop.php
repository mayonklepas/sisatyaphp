<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$lastid=0;
$selectid=$h->read("SELECT id_provinsi FROM data_provinsi ORDER BY id_provinsi DESC LIMIT 1",null);
foreach ($selectid as $value) {
  $lastid=$value['id_provinsi'];
}
$sid_provinsi="";
$snama_provinsi="";
$snama_balai="";
$notif="";
if(isset($_GET['id'])){
  $sid_provinsi=$_GET['id'];
  $select=$h->read("SELECT id_provinsi,nama_provinsi,nama_balai FROM data_provinsi WHERE id_provinsi=?",array($sid_provinsi));
  foreach ($select as $value) {
      $sid_provinsi=$value['id_provinsi'];
      $snama_provinsi=$value['nama_provinsi'];
      $snama_balai=$value['nama_balai'];
  }
}

if(isset($_POST['simpan'])){
  $id_provinsi=$_POST['id_provinsi'];
  $nama_provinsi=$_POST['nama_provinsi'];
  $nama_balai=$_POST['nama_balai'];
  if($sid_provinsi==""){
    $insert=$h->exec("INSERT INTO data_provinsi(id_provinsi,nama_provinsi,nama_balai) VALUES(?,?,?)",array($id_provinsi,$nama_provinsi,$nama_balai));
    if($insert){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Menambah data provinsi dengan id ".$id_provinsi.""));
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='data-provinsi.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_provinsi SET id_provinsi=?,nama_provinsi=?,nama_balai=? WHERE id_provinsi=?",array($id_provinsi,$nama_provinsi,$nama_balai,$sid_provinsi));
    if($update){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Mengedit data provinsi dengan id ".$sid_provinsi.""));
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='data-provinsi.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
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
        <h4 class="panel-title">Input Data Provinsi</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal aksi" method="POST">
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">ID Provinsi</label>
                <div class="col-sm-10">
                <input type="text" name="id_provinsi" value="<?php if($sid_provinsi==""){echo $lastid+1; }else{echo $sid_provinsi;} ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Provinsi</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_provinsi" required=required class="form-control" value="<?php echo $snama_provinsi ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Balai</label>
                <div class="col-sm-10">
                  <input type="text" name="nama_balai" required=required class="form-control" value="<?php echo $snama_balai ?>">
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
