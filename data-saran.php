<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$limit=25;
$jumlahdata;
$posisi=0;
$notif="";
$no=1;
$jumlahdataunit=$h->read("SELECT COUNT(id) AS jumlah FROM data_saran",null);
foreach ($jumlahdataunit as $value) {
  $jumlahdata=$value['jumlah'];
}

if (isset($_GET['page'])) {
  //$no=$_GET['offset'];
  $offset=$_GET['page']*$limit;
  $posisi=$_GET['page'];
  $dataunit=$h->read("SELECT id,tanggal,data_saran.kode_satuan_kerja,nama_satuan_kerja,judul,pesan FROM data_saran INNER JOIN data_user ON data_saran.kode_satuan_kerja=data_user.kode_satuan_kerja ORDER BY id DESC
    LIMIT ".$limit." OFFSET ".$offset." ",null);

}else{
  $dataunit=$h->read("SELECT id,tanggal,data_saran.kode_satuan_kerja,nama_satuan_kerja,judul,pesan FROM data_saran INNER JOIN data_user ON data_saran.kode_satuan_kerja=data_user.kode_satuan_kerja ORDER BY id DESC
    LIMIT ".$limit." ",null);
}

if(isset($_POST['cari'])){
  $key=$_POST['cari'];
  $notif="<div class='alert alert-success'>Hasil Pencarian untuk : <b>".$key."</b></div>";
  $dataunit=$h->read("SELECT id,tanggal,data_saran.kode_satuan_kerja,nama_satuan_kerja,judul,pesan FROM data_saran INNER JOIN data_user ON data_saran.kode_satuan_kerja=data_user.kode_satuan_kerja ORDER BY id DESC
     WHERE nama_satuan_kerja LIKE ? OR judul LIKE ? ORDER BY id DESC",
  array("%".$key."%","%".$key."%"));
}

$jumlahpage=ceil($jumlahdata / $limit);


$h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
array($_SESSION['kode_satuan_kerja'],"Melihat data saran"));

?>

<script type="text/javascript">
$(document).ready(function(){
  var id;

  $(".hapus").click(function(){
    id=$(this).data("id");
    var table="data_saran";
    var key="id";
    swal({
      title: "Konfirmasi",
      text: "Yakin Ingin Menghapus data ini?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya",
      cancelButtonText: "Tidak",
      closeOnConfirm: false,
      closeOnCancel: false
      },
      function(isConfirm){
      if (isConfirm) {
        $.ajax({
          url:"ajaxdelete.php",
          method:"POST",
          dataType:"HTML",
          data:{table:table,id:id,key:key},
          cache:false
        }).done(function(data){
          swal("Terhapus", data, "success");
          location.reload();
        });
      } else {
        swal("Dibatalkan", "Operasi berhasil di batalkan", "error");
      }
      });
  });
});

</script>

<div class="page-inner">
    <div class="page-breadcrumb">
        <ol class="breadcrumb container">
            <li><a href="index.php">Home</a></li>
            <li class="active">Data Saran</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Data Saran</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Data Saran</h4>
                    </div>
                    <div class="panel-body">
                      <form class="" action="" method="post" style="margin-top:5px">
                        <input type="text" name="cari" value="" placeholder="Cari Data" class="form-control">
                      </form>
                      <br>
                      <?php echo $notif;?>
                       <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Tanggal</th>
                                  <th>Nama Satuan Kerja</th>
                                  <th>Judul</th>
                                  <th>Pesan</th>
                                  <th>Operasi</th>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Nama Satuan Kerja</th>
                                <th>Judul</th>
                                <th>Pesan</th>
                                <th>Operasi</th>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($dataunit as $value): ?>
                                <tr>
                                  <td><?php echo $value['id'] ?></td>
                                  <td><?php echo date("d F Y",strtotime($value['tanggal']))?></td>
                                  <td><?php echo $value['nama_satuan_kerja'] ?></td>
                                  <td><?php echo $value['judul'] ?></td>
                                  <td><?php echo $value['pesan'] ?></td>
                                  <td>
                                    <a style="margin-top:5px" href="#" class="btn hapus btn-danger" data-id="<?php echo $value['id']?>" data-toggle="tooltip" title="Hapus Data"><i class="menu-icon icon-trash"></i></a>
                                    <a href="data-saran-detail.php?id=<?php echo $value['id']; ?>" class="btn btn-info"><i class="menu-icon icon-note"></i></a>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                           </table>
                           <ul class="pagination">

                         <?php for ($i=0; $i < $jumlahpage ; $i++): ?>
                             <?php
                               if ($posisi==$i) {
                                 $status="active";
                               }else{
                                 $status="";
                               }
                             ?>
                             <li class="waves-effect <?php echo $status?>"><a href="data-saran.php?page=<?php echo $i; ?>"><?php echo $i+1 ?></a></li>
                         <?php endfor; ?>

                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->

<?php include_once 'footer.php'; ?>
