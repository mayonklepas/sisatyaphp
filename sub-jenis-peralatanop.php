<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$lastid=0;
$selectid=$h->read("SELECT id_sub_jenis FROM data_sub_jenis ORDER BY id_sub_jenis DESC LIMIT 1",null);
foreach ($selectid as $value) {
  $lastid=$value['id_sub_jenis'];
}
$sid_sub_jenis="";
$sid_jenis="";
$snama_sub_jenis="";
$notif="";
if(isset($_GET['id'])){
  $sid_sub_jenis=$_GET['id'];
  $select=$h->read("SELECT data_sub_jenis.id_sub_jenis,id_jenis,nama_sub_jenis FROM data_sub_jenis WHERE data_sub_jenis.id_sub_jenis=?",array($sid_sub_jenis));
  foreach ($select as $value) {
      $sid_sub_jenis=$value['id_sub_jenis'];
      $sid_jenis=$value['id_jenis'];
      $snama_sub_jenis=$value['nama_sub_jenis'];
  }
}

if(isset($_POST['simpan'])){
  $id_sub_jenis=$_POST['id_sub_jenis'];
  $id_jenis=$_POST['id_jenis'];
  $nama_sub_jenis=$_POST['nama_sub_jenis'];
  if($sid_sub_jenis==""){
    $insert=$h->exec("INSERT INTO data_sub_jenis(id_sub_jenis,id_jenis,nama_sub_jenis) VALUES(?,?)",array($id_sub_jenis,$id_jenis,$nama_sub_jenis));
    if($insert){
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='sub-jenis-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_sub_jenis SET id_sub_jenis=?,id_jenis=?,nama_sub_jenis=? WHERE id_sub_jenis=?",array($id_sub_jenis,$id_jenis,$nama_sub_jenis,$sid_sub_jenis));
    if($update){
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='sub-jenis-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'><b>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }

}

$datajenis=$h->read("SELECT id_jenis,nama_jenis FROM data_jenis ORDER BY id_jenis ASC",null);

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
        <h4 class="panel-title">Input Data Sub Jenis</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal aksi" method="POST">
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">ID Sub Jenis</label>
                <div class="col-sm-10">
                <input type="text" name="id_sub_jenis" value="<?php if($sid_sub_jenis==""){echo $lastid+1; }else{echo $sid_sub_jenis;} ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Jenis</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_jenis" required=required>
                    <option value="<?php echo $sid_jenis ?>"><?php echo $snama_jenis ?></option>
                    <?php foreach ($datajenis as $value): ?>
                        <option value="<?php echo $value['id_jenis'] ?>"><?php echo $value['nama_jenis'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Sub Jenis</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_sub_jenis" required=required class="form-control" value="<?php echo $snama_sub_jenis ?>">
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
