<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$limit=25;
$jumlahdata;
$posisi=0;
$notif="";
$no=1;
$jumlahdataharga=$h->read("SELECT COUNT(id_harga) AS jumlah FROM data_harga",null);
foreach ($jumlahdataharga as $value) {
  $jumlahdata=$value['jumlah'];
}

if (isset($_GET['page'])) {
  //$no=$_GET['offset'];
  $offset=$_GET['page']*$limit;
  $posisi=$_GET['page'];
  $dataharga=$h->read("SELECT id_harga,tanggal,tahun_harga,data_harga.id_peralatan,nama_perangkat,harga_tahun,data_dukung,nama_provinsi FROM data_harga
    LEFT JOIN data_peralatan ON data_harga.id_peralatan=data_peralatan.id_peralatan
    LEFT JOIN data_provinsi ON data_harga.id_provinsi=data_provinsi.id_provinsi ORDER BY id_harga ASC
    LIMIT ".$limit." OFFSET ".$offset." ",null);

}else{
  $dataharga=$h->read("SELECT id_harga,tanggal,tahun_harga,data_harga.id_peralatan,nama_perangkat,harga_tahun,data_dukung,nama_provinsi FROM data_harga
    LEFT JOIN data_peralatan ON data_harga.id_peralatan=data_peralatan.id_peralatan
    LEFT JOIN data_provinsi ON data_harga.id_provinsi=data_provinsi.id_provinsi ORDER BY id_harga ASC
    LIMIT ".$limit." ",null);
}

if(isset($_POST['cari'])){
  $key=$_POST['cari'];
  $notif="<div class='alert alert-success'>Hasil Pencarian untuk : <b>".$key."</b></div>";
  $dataharga=$h->read("SELECT id_harga,tanggal,tahun_harga,data_harga.id_peralatan,nama_perangkat,harga_tahun,data_dukung,nama_provinsi FROM data_harga
    INNER JOIN data_peralatan ON data_harga.id_peralatan=data_peralatan.id_peralatan
    LEFT JOIN data_provinsi ON data_harga.id_provinsi=data_provinsi.id_provinsi
    WHERE tanggal LIKE ?
    OR nama_perangkat LIKE ?
    OR tahun_harga LIKE ?
    OR data_provinsi.nama_provinsi LIKE ?
    ORDER BY id_harga ASC ",
  array("%".$key."%","%".$key."%","%".$key."%","%".$key."%"));
}

$jumlahpage=ceil($jumlahdata / $limit);

?>

<script type="text/javascript">
$(document).ready(function(){
  var id;
  $(".hapus").click(function(){
    id=$(this).data("id");
    var table="data_harga";
    var key="id_harga";
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
            <li class="active">Data Harga Peralatan</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Data Harga Peralatan</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Data Harga Peralatan</h4>
                    </div>
                    <div class="panel-body">
                      <form class="" action="" method="post" style="margin-top:5px">
                        <input type="text" name="cari" value="" placeholder="Cari Data" class="form-control">
                      </form>
                      <br>
                      <?php echo $notif;?>
                      <a href="data-hargaop.php" class="btn btn-primary"><i class="menu-icon icon-plus"></i> Tambah</a>
                       <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                  <th>Kode</th>
                                  <th>Tanggal</th>
                                  <th>Tahun</th>
                                  <th>Nama Peralatan</th>
                                  <th>Provinsi</th>
                                  <th>Harga</th>
                                  <th>Attachment</th>
                                  <th>Operasi</th>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Tahun</th>
                                <th>Nama Peralatan</th>
                                <th>Provinsi</th>
                                <th>Harga</th>
                                <th>Attachment</th>
                                <th>Operasi</th>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($dataharga as $value): ?>
                                <tr>
                                  <td><?php echo $value['id_harga'] ?></td>
                                  <td><?php echo $value['tanggal'] ?></td>
                                  <td><?php echo $value['tahun_harga'] ?></td>
                                  <td><?php echo substr($value['nama_perangkat'],0,50) ?></td>
                                  <td><?php echo $value['nama_provinsi'] ?></td>
                                  <td><?php echo number_format($value['harga_tahun']) ?></td>
                                  <td> <?php if ($value['data_dukung']==""): ?>
                                     <a href="upload-attachment.php?id=<?php echo $value['id_harga']?>" style="margin-top:5px" class="btn btn-warning" data-toggle="tooltip" title="Upload File">
                                       <i class="menu-icon icon-cloud-upload"></i></a>
                                  <?php else: ?>
                                      <a href="file-dukung/<?php echo $value['data_dukung']?>" class="btn btn-success" style="margin-top:5px" data-toggle="tooltip" title="Download File"> <i class="menu-icon icon-cloud-download"></i></a>
                                    <a href="upload-attachment.php?id=<?php echo $value['id_harga']?>" style="margin-top:5px" class="btn btn-warning" data-toggle="tooltip" title="Ganti File">
                                      <i class="menu-icon icon-cloud-upload"></i></a>
                                  <?php endif; ?>
                                </td>
                                  <td>
                                    <a style="margin-top:5px" href="data-hargaop.php?id=<?php echo $value['id_harga']?>" class="btn btn-info" data-toggle="tooltip" title="Detail / Edit Data"><i class="menu-icon icon-note"></i></a>
                                    <a style="margin-top:5px" href="#" class="btn hapus btn-danger" data-id="<?php echo $value['id_harga']?>" data-toggle="tooltip" title="Hapus Data"><i class="menu-icon icon-trash"></i></a>
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
                             <li class="waves-effect <?php echo $status?>"><a href="data-harga.php?page=<?php echo $i; ?>"><?php echo $i+1 ?></a></li>
                         <?php endfor; ?>

                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
<?php include_once 'footer.php'; ?>
