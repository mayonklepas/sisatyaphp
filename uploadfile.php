<?php
require_once 'helper/helper.php';
include_once 'navbar.php';
$h=new Helper();
$sid=$_GET['id'];
$kat=$_GET['kat'];
$snama_kegiatan="";
$snama="";
$snik="";
$snegara="";
$skota="";
$fieldkat="";
$headerkat="";
$namafiledidb="";
if($kat=="undangan"){
  $fieldkat="surat_undangan";
  $headerkat="SURAT UNDANGAN";
}elseif ($kat=="deputi") {
  $fieldkat="surat_deputi";
  $headerkat="SURAT DEPUTI";
}elseif ($kat=="persetujuan") {
  $fieldkat="surat_persetujuan";
  $headerkat="SURAT PERSETUJUAN";
}else {
  $fieldkat="pas_foto";
  $headerkat="Foto";
}
if(isset($_GET['id'])){
  $id=$_GET['id'];
  $datafile=$h->read("SELECT id, data_kegiatan.nik,data_pemohon.nama, nama_kegiatan, durasi, negara, kota,".$fieldkat." FROM data_kegiatan INNER JOIN data_pemohon ON data_kegiatan.nik=data_pemohon.nik",array($id));
  foreach ($datafile as $value) {
    $snama_kegiatan=$value['nama_kegiatan'];
    $snik=$value['nik'];
    $sid=$value['id'];
    $snama=$value['nama'];
    $snegara=$value['negara'];
    $skota=$value['kota'];
    $namafiledidb=$value[$fieldkat];
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
  $namabarufile=$sid."-".$snik."-".$snama."-".$snama_kegiatan."-".$kat."-".date("dmyhis").".".$ext;
  if($size <= 3000000){
    if($namafiledidb=="" || $namafiledidb=="na" || $namafiledidb=="none"){

  }else {
        unlink("file/".$namafiledidb);
  }

    try {
      move_uploaded_file($tmp_file,"file/".$namabarufile);
        $h->exec("UPDATE data_kegiatan SET ".$fieldkat."=? WHERE id=? ",array($namabarufile,$id));
        $notif="<div class='alert alert-success'><b>Data Berhasil Disimpan</b>
         <a href='data-kegiatan.php' style='color:red;'> <i class='pe-7s-back'></i> Kembali ke Data </a></div>";
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
      $(".simpan").html("<i class='fa fa-spinner'></i> Sedang Menyimpan");
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
    <div class="container-fluid" style="margin-top:20px;margin-bottom:20px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="title"><a href="data-kegiatan.php?">DATA KEGIATAN </a> / INPUT <?php echo $headerkat ?></h4>
                      <?php echo $notif ?>
                      <div class="alert alert-warning">
                        Nama File : <?php echo $namafiledidb ?>
                        <?php if ($namafiledidb != "" || $namafiledidb !="na" ): ?>
                           <a href="file/<?php echo $namafiledidb ?>" class="">Download</a>
                        <?php endif; ?>
                      </div>
                      <form class="aksi" action="" method="post" enctype="multipart/form-data">
                        <?php if ($kat=="foto"): ?>
                          <label for="">Pas Foto (JPG/JPEG/PNG)</label>
                        <?php else: ?>
                            <label for="">File Data (DOC/XLS/PDF)</label>
                        <?php endif; ?>
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
?>
