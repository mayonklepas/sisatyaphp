<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
if(isset($_GET['id'])){
  $sid=$_GET['id'];
  $h->exec("UPDATE data_saran SET status=1 WHERE id=?",array($sid));
  $select=$h->read("SELECT id,tanggal,data_saran.kode_satuan_kerja,nama_satuan_kerja,judul,pesan FROM data_saran INNER JOIN data_user ON data_saran.kode_satuan_kerja=data_user.kode_satuan_kerja WHERE id=?",array($sid));
  foreach ($select as $value) {
      $stanggal=date("d F Y", strtotime($value['tanggal']));
      $snama_satuan_kerja=$value['nama_satuan_kerja'];
      $sjudul=$value['judul'];
      $spesan=$value['pesan'];
  }
$h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
array($_SESSION['kode_satuan_kerja'],"Melihat data saran dengan id ".$sid.""));
}


?>


<div id="main-wrapper" class="container">
<div class="row">
<div class="col-md-6">
<div class="panel panel-white">
    <div class="panel-heading clearfix">
        <h4 class="panel-title"><?php echo $sjudul ?></h4>
    </div>
    <div class="panel-body">
        <h5>Dari <?php echo $snama_satuan_kerja ?></h5>
        <br>
        <p><?php echo $spesan ?></p>
        <br>
        <h6><?php echo $stanggal ?></h6>
    </div>
</div>
</div>
</div>
</div>
<?php include_once 'footer.php';

?>
