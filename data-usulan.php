<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$limit=25;
$jumlahdata;
$posisi=0;
$notif="";
$no=1;
$jumlahdataunit=$h->read("SELECT COUNT(id_acuan) AS jumlah FROM data_acuan_harga",null);
foreach ($jumlahdataunit as $value) {
  $jumlahdata=$value['jumlah'];
}

if (isset($_GET['page'])) {
  //$no=$_GET['offset'];
  $offset=$_GET['page']*$limit;
  $posisi=$_GET['page'];
  $dataunit=$h->read("SELECT dah.id_acuan,dah.id_user,du.nama_satuan_kerja,dp.nama_provinsi,dah.kode_alat,dah.nama_alat,dah.satuan_alat,
     dah.harga, dah.tanggal, dah.data_dukung,dp.nama_balai FROM data_acuan_harga dah
     LEFT JOIN data_user du ON dah.id_user=du.kode_satuan_kerja
     LEFT JOIN data_provinsi dp ON du.id_provinsi=dp.id_provinsi ORDER BY dah.id_acuan ASC
    LIMIT ".$limit." OFFSET ".$offset." ",null);

}else{
  $dataunit=$h->read("SELECT dah.id_acuan,dah.id_user,du.nama_satuan_kerja,dp.nama_provinsi,dah.kode_alat,dah.nama_alat,dah.satuan_alat,
     dah.harga, dah.tanggal, dah.data_dukung,dp.nama_balai FROM data_acuan_harga dah
     LEFT JOIN data_user du ON dah.id_user=du.kode_satuan_kerja
     LEFT JOIN data_provinsi dp ON du.id_provinsi=dp.id_provinsi ORDER BY dah.id_acuan ASC
    LIMIT ".$limit." ",null);
}

if(isset($_POST['cari'])){
  $key=$_POST['cari'];
  $notif="<div class='alert alert-success'>Hasil Pencarian untuk : <b>".$key."</b></div>";
  $dataunit=$h->read("SELECT dah.id_acuan,dah.id_user,du.nama_satuan_kerja,dp.nama_provinsi,dah.kode_alat,dah.nama_alat,dah.satuan_alat,
     dah.harga, dah.tanggal, dah.data_dukung,dp.nama_balai FROM data_acuan_harga dah
     LEFT JOIN data_user du ON dah.id_user=du.kode_satuan_kerja
     LEFT JOIN data_provinsi dp ON du.id_provinsi=dp.id_provinsi ORDER BY dah.id_acuan
     WHERE dp.nama_provinsi LIKE ? OR dah.nama_alat LIKE ? ORDER BY id_unit ASC",
  array("%".$key."%","%".$key."%"));
}

$jumlahpage=ceil($jumlahdata / $limit);

?>

<script type="text/javascript">
$(document).ready(function(){
  var id;

  $(".hapus").click(function(){
    id=$(this).data("id");
    var table="data_acuan_harga";
    var key="id_acuan";
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
            <li class="active">Data Usulan Harga</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Data Usulan Harga</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Data Usulan Harga</h4>
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
                                  <th>ID Acuan</th>
                                  <th>Satuan Kerja</th>
                                  <th>Provinsi</th>
                                  <th>Balai</th>
                                  <th>Kode Alat</th>
                                  <th>Satuan Alat</th>
                                  <th>Harga</th>
                                  <th>Tanggal</th>
                                  <th>Data Dukung</th>
                                  <th>Operasi</th>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>ID Acuan</th>
                                <th>Satuan Kerja</th>
                                <th>Provinsi</th>
                                <th>Balai</th>
                                <th>Kode Alat</th>
                                <th>Satuan Alat</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                                <th>Data Dukung</th>
                                <th>Operasi</th>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($dataunit as $value): ?>
                                <tr>
                                  <td><?php echo $value['id_acuan'] ?></td>
                                  <td><?php echo $value['nama_satuan_kerja'] ?></td>
                                  <td><?php echo $value['nama_provinsi'] ?></td>
                                  <td><?php echo $value['kode_alat'] ?></td>
                                  <td><?php echo $value['nama_alat'] ?></td>
                                  <td><?php echo $value['satuan_alat'] ?></td>
                                  <td><?php echo $value['harga'] ?></td>
                                  <td><?php echo date("d F Y",strtotime($value['tanggal']))?></td>
                                  <td><?php echo $value['data_dukung'] ?></td>
                                  <td>
                                    <a style="margin-top:5px" href="#" class="btn hapus btn-danger" data-id="<?php echo $value['id_acuan']?>" data-toggle="tooltip" title="Hapus Data"><i class="menu-icon icon-trash"></i></a>
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
                             <li class="waves-effect <?php echo $status?>"><a href="data-usulan.php?page=<?php echo $i; ?>"><?php echo $i+1 ?></a></li>
                         <?php endfor; ?>

                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->

<?php include_once 'footer.php'; ?>
