<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$lastid=0;
$selectid=$h->read("SELECT id_jenis FROM data_jenis ORDER BY id_jenis DESC LIMIT 1",null);
foreach ($selectid as $value) {
  $lastid=$value['id_jenis'];
}
$sid_jenis="";
$snama_jenis="";
$notif="";
if(isset($_GET['id'])){
  $sid_jenis=$_GET['id'];
  $select=$h->read("SELECT id_jenis,nama_jenis FROM data_jenis WHERE id_jenis=?",array($sid_jenis));
  foreach ($select as $value) {
      $sid_jenis=$value['id_jenis'];
      $snama_jenis=$value['nama_jenis'];
  }
}

if(isset($_POST['simpan'])){
  $id_jenis=$_POST['id_jenis'];
  $nama_jenis=$_POST['nama_jenis'];
  if($sid_jenis==""){
    $insert=$h->exec("INSERT INTO data_jenis(id_jenis,nama_jenis) VALUES(?,?)",array($id_jenis,$nama_jenis));
    if($insert){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Menambah data jenis peralatan dengan id ".$id_jenis.""));
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='jenis-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_jenis SET id_jenis=?,nama_jenis=? WHERE id_jenis=?",array($id_jenis,$nama_jenis,$sid_jenis));
    if($update){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Mengedit data jenis peralatan dengan id ".$sid_jenis.""));
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='jenis-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
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
                <label for="input-Default" class="col-sm-2 control-label">ID Jenis</label>
                <div class="col-sm-10">
                <input type="text" name="id_jenis" value="<?php if($sid_jenis==""){echo $lastid+1; }else{echo $sid_jenis;} ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Jenis</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_jenis" required=required class="form-control" value="<?php echo $snama_jenis ?>">
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
