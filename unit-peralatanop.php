<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$lastid=0;
$selectid=$h->read("SELECT id_unit FROM data_unit ORDER BY id_unit DESC LIMIT 1",null);
foreach ($selectid as $value) {
  $lastid=$value['id_unit'];
}
$sid_unit="";
$snama_unit="";
$notif="";
if(isset($_GET['id'])){
  $sid_unit=$_GET['id'];
  $select=$h->read("SELECT id_unit,nama_unit FROM data_unit WHERE id_unit=?",array($sid_unit));
  foreach ($select as $value) {
      $sid_unit=$value['id_unit'];
      $snama_unit=$value['nama_unit'];
  }
}

if(isset($_POST['simpan'])){
  $id_unit=$_POST['id_unit'];
  $nama_unit=$_POST['nama_unit'];
  if($sid_unit==""){
    $insert=$h->exec("INSERT INTO data_unit(id_unit,nama_unit) VALUES(?,?)",array($id_unit,$nama_unit));
    if($insert){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Menambah data unit peralatan dengan id ".$id_unit.""));
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='unit-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_unit SET id_unit=?,nama_unit=? WHERE id_unit=?",array($id_unit,$nama_unit,$sid_unit));
    if($update){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Mengubah data unit peralatan dengan id ".$sid_unit.""));
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='unit-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
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
        <h4 class="panel-title">Input Data Unit</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal aksi" method="POST">
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">ID Unit</label>
                <div class="col-sm-10">
                <input type="text" name="id_unit" value="<?php if($sid_unit==""){echo $lastid+1; }else{echo $sid_unit;} ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Unit</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_unit" required=required class="form-control" value="<?php echo $snama_unit ?>">
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
