<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$lastid=0;
$selectid=$h->read("SELECT id_kategori FROM data_kategori ORDER BY id_kategori DESC LIMIT 1",null);
foreach ($selectid as $value) {
  $lastid=$value['id_kategori'];
}
$sid_kategori="";
$snama_kategori="";
$notif="";
if(isset($_GET['id'])){
  $sid_kategori=$_GET['id'];
  $select=$h->read("SELECT id_kategori,nama_kategori FROM data_kategori WHERE id_kategori=?",array($sid_kategori));
  foreach ($select as $value) {
      $sid_kategori=$value['id_kategori'];
      $snama_kategori=$value['nama_kategori'];
  }
}

if(isset($_POST['simpan'])){
  $id_kategori=$_POST['id_kategori'];
  $nama_kategori=$_POST['nama_kategori'];
  if($sid_kategori==""){
    $insert=$h->exec("INSERT INTO data_kategori(id_kategori,nama_kategori) VALUES(?,?)",array($id_kategori,$nama_kategori));
    if($insert){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Menambah data kategori peralatan dengan id ".$id_kategori.""));
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='kategori-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_kategori SET id_kategori=?,nama_kategori=? WHERE id_kategori=?",array($id_kategori,$nama_kategori,$sid_kategori));
    if($update){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Mengedit data kategori peralatan dengan id ".$sid_kategori.""));
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='kategori-peralatan.php' style='color:red;'> <i class=''pe-7s-back'></i> Kembali ke Data </a></div>";
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
        <h4 class="panel-title">Input Data Kategori</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal aksi" method="POST">
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">ID Kategori</label>
                <div class="col-sm-10">
                <input type="text" name="id_kategori" value="<?php if($sid_kategori==""){echo $lastid+1; }else{echo $sid_kategori;} ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Kategori</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_kategori" required=required class="form-control" value="<?php echo $snama_kategori ?>">
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
