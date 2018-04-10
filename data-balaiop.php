<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$lastid=0;
$selectid=$h->read("SELECT id_balai FROM data_balai ORDER BY id_balai DESC LIMIT 1",null);
foreach ($selectid as $value) {
  $lastid=$value['id_balai'];
}
$sid_balai="";
$snama_balai="";
$notif="";
if(isset($_GET['id'])){
  $sid_balai=$_GET['id'];
  $select=$h->read("SELECT id_balai,nama_balai FROM data_balai WHERE id_balai=?",array($sid_balai));
  foreach ($select as $value) {
      $sid_balai=$value['id_balai'];
      $snama_balai=$value['nama_balai'];
  }
}

if(isset($_POST['simpan'])){
  $id_balai=$_POST['id_balai'];
  $nama_balai=$_POST['nama_balai'];
  if($sid_balai==""){
    $insert=$h->exec("INSERT INTO data_balai(id_balai,nama_balai) VALUES(?,?)",array($id_balai,$nama_balai));
    if($insert){
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='data-balai.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_balai SET id_balai=?,nama_balai=? WHERE id_balai=?",array($id_balai,$nama_balai,$sid_balai));
    if($update){
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='data-balai.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'><b>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }

}

?>


<script type="text/javascript">
  $(document).ready(function(){
    $(".aksi").submit(function(event){
      $(".simpan").html("<i class='pe-7s-rocket'></i> Sedang Menyimpan");
      $(this).submit();
      event.preventDefault();
    });
    $(".alert").click(function(){
      $(this).hide();
    });
  });
</script>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title"><a href="data-balai.php">DATA BALAI</a> / INPUT DATA BALAI</h4>
                    </div>
                    <div class="content">
                      <?php echo $notif ?>
                      <form class="aksi" action="" method="post">
                        <label for="">ID Balai</label>
                        <input type="text" name="id_balai" value="<?php if($sid_balai==""){echo $lastid+1; }else{echo $sid_balai;} ?>" class="form-control">
                        <label for="">Nama Balai</label>
                        <input type="text" name="nama_balai" required=required class="form-control" value="<?php echo $snama_balai ?>">
                        <br>
                        <button type="submit" name="simpan" class="btn btn-primary simpan"> <i class="pe-7s-diskette"></i> Simpan</button>
                      </form>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php include_once 'footer.php';

?>
