<?php
require_once 'helper/helper.php';
include_once 'navbar.php';
$h=new Helper();
$sid=$_GET['id'];
$sdatadukung="";
$snamaperangkat="";
$stahunharga="";
$namaprovinsi="";
if(isset($_GET['id'])){
  $id=$_GET['id'];
  $datafile=$h->read("SELECT data_dukung,nama_perangkat,tahun_harga,nama_provinsi FROM data_harga
    LEFT JOIN data_provinsi ON data_harga.id_provinsi=data_provinsi.id_provinsi
    INNER JOIN data_peralatan ON data_harga.id_peralatan=data_peralatan.id_peralatan WHERE id_harga=?",array($id));
  foreach ($datafile as $value) {
    $sdatadukung=$value['data_dukung'];
    $snamaperangkat=$value['nama_perangkat'];
    $stahunharga=$value['tahun_harga'];
    $snamaprovinsi=$value['nama_provinsi'];
  }
}
$notif="";
if(isset($_POST['simpan'])){
  $namafile=$_FILES['file']['name'];
  $filetipe=$_FILES['file']['type'];
  $tmp_file=$_FILES['file']['tmp_name'];
  $size=filesize($tmp_file);
  $rawext=explode(".",$namafile);
  $ext=end($rawext);
  $namabarufile=$snamaperangkat."-".$snamaprovinsi."-".$stahunharga."-".date("dmyhis").".".$ext;
  if($size <= 3000000){
    if($sdatadukung=="" || $sdatadukung=="na" || $sdatadukung=="none"){

  }else {
        unlink("file-dukung/".$sdatadukung);
  }

    try {
      move_uploaded_file($tmp_file,"file-dukung/".$namabarufile);
        $h->exec("UPDATE data_harga SET data_dukung=? WHERE id_harga=? ",array($namabarufile,$id));
        $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
        array($_SESSION['kode_satuan_kerja'],"Mengupload data dukung peralatan dengan nama ".$namabarufile.""));
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='data-harga.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
    } catch (Exception $e) {
      echo $e->getMessage();
    }

  }else{
    $notif="<div class='alert alert-danger'>Upload gagal, pastikan tipe file adalah pdf,rtf,word,xls dan ukuran lebih kecil dari 300kb</div>";
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
      //$(this).text("Sedang Menyimpan...");
      $(this).hide();
    });
  });
</script>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title"><a href="data-harga.php?">DATA HARGA PERALATAN</a> / INPUT DATA FILE</h4>
                    </div>
                    <div class="content">
                      <?php echo $notif ?>
                      <div class="alert alert-warning">
                        Nama File : <?php echo $sdatadukung ?>
                      </div>
                      <form class="aksi" action="" method="post" enctype="multipart/form-data">
                        <label for="">File Data Pendukung (DOC/XLS/PDF)</label>
                        <input type="file" name="file" value="" class="form-control" required>
                        <br>
                        <button type="submit" name="simpan" class="btn btn-primary simpan"> <i class="pe-7s-diskette"></i> Simpan</button>
                      </form>
                    </div>

                      </ul>

                    </div>
                </div>
            </div>


        </div>
    </div>

<?php
include_once 'footer.php';

?>
