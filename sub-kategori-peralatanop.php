<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$lastid=0;
$selectid=$h->read("SELECT id_sub_kategori FROM data_sub_kategori ORDER BY id_sub_kategori DESC LIMIT 1",null);
foreach ($selectid as $value) {
  $lastid=$value['id_sub_kategori'];
}
$sid_sub_kategori="";
$sid_kategori="";
$snama_kategori="";
$snama_sub_kategori="";
$notif="";
if(isset($_GET['id'])){
  $sid_sub_kategori=$_GET['id'];
  $select=$h->read("SELECT data_sub_kategori.id_sub_kategori,data_sub_kategori.d_kategori,nama_sub_kategori,nama_kategori FROM data_sub_kategori INNER JON data_kategori ON data_sub_kategori.id_kategori=data_kategori.id_kategori WHERE data_sub_kategori.id_sub_kategori=?",array($sid_sub_kategori));
  foreach ($select as $value) {
      $sid_sub_kategori=$value['id_sub_kategori'];
      $sid_kategori=$value['id_kategori'];
      $snama_sub_kategori=$value['nama_sub_kategori'];
      $snama_kategori=$value['nama_kategori'];
  }
}

if(isset($_POST['simpan'])){
  $id_sub_kategori=$_POST['id_sub_kategori'];
  $id_kategori=$_POST['id_kategori'];
  $nama_sub_kategori=$_POST['nama_sub_kategori'];
  if($sid_sub_kategori==""){
    $insert=$h->exec("INSERT INTO data_sub_kategori(id_sub_kategori,id_kategori,nama_sub_kategori) VALUES(?,?,?)",array($id_sub_kategori,$id_kategori,$nama_sub_kategori));
    if($insert){
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='sub-kategori-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_sub_kategori SET id_sub_kategori=?,id_kategori=?,nama_sub_kategori=? WHERE id_sub_kategori=?",array($id_sub_kategori,$id_kategori,$nama_sub_kategori,$sid_sub_kategori));
    if($update){
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='sub-kategori-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'><b>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }

}

$datakategori=$h->read("SELECT id_kategori,nama_kategori FROM data_kategori ORDER BY id_kategori ASC",null);

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
        <h4 class="panel-title">Input Data Sub Kategori</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal aksi" method="POST">
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">ID Sub Kategori</label>
                <div class="col-sm-10">
                <input type="text" name="id_sub_kategori" value="<?php if($sid_sub_kategori==""){echo $lastid+1; }else{echo $sid_sub_kategori;} ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_kategori" required=required>
                    <option value="<?php echo $sid_kategori ?>"><?php echo $snama_kategori ?></option>
                    <?php foreach ($datakategori as $value): ?>
                        <option value="<?php echo $value['id_kategori'] ?>"><?php echo $value['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Sub Kategori</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_sub_kategori" required=required class="form-control" value="<?php echo $snama_sub_kategori ?>">
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
