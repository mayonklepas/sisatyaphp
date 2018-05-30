<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$sid_peralatan="";
$sid_jenis="";
$sid_unit="";
$snama_perangkat="";
$sumur_teknis_alat="";
$sketerangan="";
$sno_perka="";
$skategori="";
$snama_jenis="";
$snama_unit="";
$notif="";
$stipe="";
if(isset($_GET['id'])){
  $skode_satuan_kerja=$_GET['id'];
  $select=$h->read("SELECT id_peralatan,data_peralatan.id_jenis,data_peralatan.id_unit,
    nama_perangkat,umur_teknis_alat,keterangan,no_perka,nama_jenis,nama_unit FROM data_peralatan
    INNER JOIN data_jenis ON data_peralatan.id_jenis=data_jenis.id_jenis
    LEFT JOIN data_unit ON data_peralatan.id_unit=data_unit.id_unit WHERE id_peralatan=?",array($skode_satuan_kerja));
  foreach ($select as $value) {
    $sid_peralatan=$value['id_peralatan'];
    $sid_jenis=$value['id_jenis'];
    $sid_unit=$value['id_unit'];
    $snama_perangkat=$value['nama_perangkat'];
    $sumur_teknis_alat=$value['umur_teknis_alat'];
    $sketerangan=$value['keterangan'];
    $sno_perka=$value['no_perka'];
    $snama_jenis=$value['nama_jenis'];
    $snama_unit=$value['nama_unit'];
  }
}

$datajenis=$h->read("SELECT id_jenis,nama_jenis FROM data_jenis ORDER BY id_jenis ASC",null);
$dataunit=$h->read("SELECT id_unit,nama_unit FROM data_unit ORDER BY id_unit ASC",null);

if(isset($_POST['simpan'])){
  $id_peralatan=$_POST['id_peralatan'];
  $id_jenis=$_POST['id_jenis'];
  $id_unit=$_POST['id_unit'];
  $nama_perangkat=$_POST['nama_perangkat'];
  $umur_teknis_alat=$_POST['umur_teknis_alat'];
  $keterangan=$_POST['keterangan'];
  $no_perka=$_POST['no_perka'];
  if($sid_peralatan==""){
    $insert=$h->exec("INSERT INTO data_peralatan(id_peralatan,id_jenis,id_unit,nama_perangkat,umur_teknis_alat,keterangan,no_perka) VALUES(?,?,?,?,?,?,?)",
    array($id_peralatan,$id_jenis,$id_unit,$nama_perangkat,$umur_teknis_alat,$keterangan,$no_perka));
    if($insert){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Menambah data peralatan dengan id ".$id_peralatan.""));
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='data-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_peralatan SET id_peralatan=?,id_jenis=?,id_unit=?,nama_perangkat=?,umur_teknis_alat=?,keterangan=?,no_perka=? WHERE id_peralatan=?",
    array($id_peralatan,$id_jenis,$id_unit,$nama_perangkat,$umur_teknis_alat,$keterangan,$no_perka,$sid_peralatan));
    if($update){
      $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
      array($_SESSION['kode_satuan_kerja'],"Mengedit data peralatan dengan id ".$sid_peralatan.""));
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='data-peralatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
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
        <h4 class="panel-title">Input Data Peralatan</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal aksi" method="POST">
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Kode Perangkat</label>
                <div class="col-sm-10">
                <input type="text" name="id_peralatan" value="<?php echo $sid_peralatan?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Jenis</label>
                <div class="col-sm-10">
                  <select class="selectpicker  form-control" data-live-search="true" name="id_jenis" required=required>
                    <option value="<?php echo $sid_jenis ?>"><?php echo $snama_jenis ?></option>
                    <?php foreach ($datajenis as $value): ?>
                        <option value="<?php echo $value['id_jenis'] ?>"><?php echo $value['nama_jenis'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Unit</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_unit" required=required>
                    <option value="<?php echo $sid_unit ?>"><?php echo $snama_unit ?></option>
                    <?php foreach ($dataunit as $value): ?>
                        <option value="<?php echo $value['id_unit'] ?>" data-tokens="<?php echo $value['nama_unit'] ?>"><?php echo $value['nama_unit'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Perangkat</label>
                <div class="col-sm-10">
                <input type="text" name="nama_perangkat" required=required class="form-control" value="<?php echo $snama_perangkat ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Umur Teknis</label>
                <div class="col-sm-10">
                <input type="text" name="umur_teknis_alat" required=required class="form-control" value="<?php echo $sumur_teknis_alat ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Keterangan</label>
                <div class="col-sm-10">
                  <input type="text" name="keterangan" required=required class="form-control" value="<?php echo $sketerangan ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">No. Perka</label>
                <div class="col-sm-10">
                  <input type="text" name="no_perka" required=required class="form-control" value="<?php echo $sno_perka ?>">
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
