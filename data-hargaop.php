<?php
include_once 'navbar.php';
/*if ($_SESSION['nama_unit_kerja']!="Admin") {
  header("location:aksesditolak.php");
}*/
require_once "helper/helper.php";
$h=new Helper();
$sid_harga="";
$stanggal="";
$sid_peralatan="";
$snama_perangkat="";
$sharga_tahun="";
$sdata_dukung="";
$snama_provinsi="";
$id_provinsi="";
$stahun_harga="";
$notif="";
if(isset($_GET['id'])){
  $sid_harga=$_GET['id'];
  $select=$h->read("SELECT id_harga,tanggal,tahun_harga,data_harga.id_peralatan,nama_perangkat,harga_tahun,data_dukung,
    data_harga.id_provinsi,nama_provinsi FROM data_harga
    INNER JOIN data_peralatan ON data_harga.id_peralatan=data_peralatan.id_peralatan
    LEFT JOIN data_provinsi ON data_harga.id_provinsi=data_provinsi.id_provinsi WHERE id_harga=?",array($sid_harga));
  foreach ($select as $value) {
    $sid_harga=$value['id_harga'];
    $stanggal=$value['tanggal'];
    $sid_peralatan=$value['id_peralatan'];
    $snama_perangkat=$value['nama_perangkat'];
    $sharga_tahun=$value['harga_tahun'];
    $sdata_dukung=$value['data_dukung'];
    $sid_provinsi=$value['id_provinsi'];
    $snama_provinsi=$value['nama_provinsi'];
    $stahun_harga=$value['tahun_harga'];
  }
}

$dataprovinsi=$h->read("SELECT id_provinsi,nama_provinsi FROM data_provinsi ORDER BY id_provinsi ASC",null);
$dataperalatan=$h->read("SELECT id_peralatan,nama_perangkat FROM data_peralatan ORDER BY id_peralatan ASC",null);

if(isset($_POST['simpan'])){
  $tms=new DateTime();
  $id_harga=$tms->getTimeStamp();
  $tanggal=$_POST['tanggal'];
  $tahun=$_POST['tahun_harga'];
  $id_peralatan=$_POST['id_peralatan'];
  $nama_perangkat=$_POST['nama_perangkat'];
  $harga_tahun=$_POST['harga_tahun'];
  $id_provinsi=$_POST['id_provinsi'];
  if($sid_harga==""){
    $insert=$h->exec("INSERT INTO data_harga(id_harga,tanggal,tahun_harga,id_peralatan,harga_tahun,id_provinsi,kode_satuan_kerja) VALUES(?,?,?,?,?,?,?)",
    array($id_harga,$tanggal,$tahun,$id_peralatan,$harga_tahun,$id_provinsi,$_SESSION['kode_satuan_kerja']));
    if($insert){
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='data-harga.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }else{
    $update=$h->exec("UPDATE data_harga SET id_harga=?,tanggal=?,tahun_harga=?,id_peralatan=?,harga_tahun=?,id_provinsi=?,kode_satuan_kerja=? WHERE id_harga=?",
    array($id_harga,$tanggal,$tahun,$id_peralatan,$harga_tahun,$id_provinsi,$_SESSION['kode_satuan_kerja'],$sid_harga));
    if($update){
      $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
      <a href='data-harga.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    }else{
      $notif="<div class='alert alert-danger'><b>Data Gagal Disimpan cek koneksi</b></div>";
    }
  }

}

?>


<script type="text/javascript">
  $(document).ready(function(){
    $(".aksi").submit(function(event){
      $(".simpan").html("<i class='menu-icon icon-paper-refresh'></i> Sedang Menyimpan");
      $(this).submit();
      event.preventDefault();
    });
    $(".alert").click(function(){
      $(this).hide();
    });

    $("#id_peralatan").keyup(function(){
      $("#label_perangkat").html("   <label style='color:blue'>Sedang Mencari Data</label>");
      $("#nama_perangkat").val("");
      key=$(this).val();
      $.ajax({
        url:"ajaxdataperalatan.php",
        method:"POST",
        dataType:"text",
        data:{key:key},
        cache:false
      }).done(function(data){
        if(data==""){
          $("#nama_perangkat").val("");
          $("#label_perangkat").html("   <label style='color:red'>Data Tidak Ditemukan </label>");
        }else{
          $("#nama_perangkat").val(data);
          $("#label_perangkat").html("   <label style='color:green'>Data Ditemukan </label>");
        }

      })
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
                <label for="input-Default" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-10">
                <input type="date" name="tanggal" value="<?php echo $stanggal?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Tahun</label>
                <div class="col-sm-10">
                  <input type="text" name="tahun_harga"  id=tahun list="daftar-tahun" class="form-control" value="<?php echo $stahun_harga?>">
                  <datalist class="" id="daftar-tahun">
                    <?php for ($i=date("Y")-10 ; $i < date("Y")+10 ; $i++ ): ?>
                      <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php endfor; ?>
                  </datalist>
                </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Kode Perangkat</label>
                <div class="col-sm-10">
                <input type="text" name="id_peralatan" id="id_peralatan"  value="<?php echo $sid_peralatan?>" class="form-control" list="daftar-peralatan">
                <datalist class="" id="daftar-peralatan">
                  <?php foreach ($dataperalatan as $value): ?>
                      <option value="<?php echo $value['id_peralatan'] ?>"><?php echo $value['nama_perangkat'] ?></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>
            <div class="form-group">
                <label for="input-Default" class="col-sm-2 control-label">Nama Perangkat</label>
                <div class="col-sm-10">
                  <span id="label_perangkat" ></span>
                  <input type="text" name="nama_perangkat" id="nama_perangkat" class="form-control" value="<?php echo $snama_perangkat ?>">
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
                <label for="input-Default" class="col-sm-2 control-label">No. Perka</label>
                <div class="col-sm-10">
                <input type="number" name="harga_tahun" required=required class="form-control" value="<?php echo $sharga_tahun ?>">
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
