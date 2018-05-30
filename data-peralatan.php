<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$limit=25;
$jumlahdata;
$posisi=0;
$notif="";
$no=1;
$jumlahdataperalatan=$h->read("SELECT COUNT(id_peralatan) AS jumlah FROM data_peralatan",null);
foreach ($jumlahdataperalatan as $value) {
  $jumlahdata=$value['jumlah'];
}

if (isset($_GET['page'])) {
  //$no=$_GET['offset'];
  $offset=$_GET['page']*$limit;
  $posisi=$_GET['page'];
  $dataperalatan=$h->read("SELECT id_peralatan,data_peralatan.id_jenis,data_peralatan.id_unit,
    data_kategori.nama_kategori,data_sub_kategori.nama_sub_kategori,
    nama_perangkat,umur_teknis_alat,keterangan,no_perka,nama_jenis,nama_unit FROM data_peralatan
    INNER JOIN data_jenis ON data_peralatan.id_jenis=data_jenis.id_jenis
    INNER JOIN data_sub_kategori ON data_jenis.id_sub_kategori=data_sub_kategori.id_sub_kategori
    INNER JOIN data_kategori ON data_sub_kategori.id_kategori=data_kategori.id_kategori
    LEFT JOIN data_unit ON data_peralatan.id_unit=data_unit.id_unit ORDER BY CAST(id_peralatan AS DECIMAL) ASC
    LIMIT ".$limit." OFFSET ".$offset." ",null);

}else{
  $dataperalatan=$h->read("SELECT id_peralatan,data_peralatan.id_jenis,data_peralatan.id_unit,
    data_kategori.nama_kategori,data_sub_kategori.nama_sub_kategori,
    nama_perangkat,umur_teknis_alat,keterangan,no_perka,nama_jenis,nama_unit FROM data_peralatan
    INNER JOIN data_jenis ON data_peralatan.id_jenis=data_jenis.id_jenis
    INNER JOIN data_sub_kategori ON data_jenis.id_sub_kategori=data_sub_kategori.id_sub_kategori
    INNER JOIN data_kategori ON data_sub_kategori.id_kategori=data_kategori.id_kategori
    LEFT JOIN data_unit ON data_peralatan.id_unit=data_unit.id_unit ORDER BY CAST(id_peralatan AS DECIMAL) ASC
    LIMIT ".$limit." ",null);
}

if(isset($_POST['cari'])){
  $key=$_POST['cari'];
  $notif="<div class='alert alert-success'>Hasil Pencarian untuk : <b>".$key."</b></div>";
  $dataperalatan=$h->read("SELECT id_peralatan,data_peralatan.id_jenis,data_peralatan.id_unit,
    data_kategori.nama_kategori,data_sub_kategori.nama_sub_kategori,
    nama_perangkat,umur_teknis_alat,keterangan,no_perka,nama_jenis,nama_unit FROM data_peralatan
    INNER JOIN data_jenis ON data_peralatan.id_jenis=data_jenis.id_jenis
    INNER JOIN data_sub_kategori ON data_jenis.id_sub_kategori=data_sub_kategori.id_sub_kategori
    INNER JOIN data_kategori ON data_sub_kategori.id_kategori=data_kategori.id_kategori
    LEFT JOIN data_unit ON data_peralatan.id_unit=data_unit.id_unit
    WHERE nama_perangkat LIKE ?
    OR nama_jenis LIKE ?
    OR nama_unit LIKE ?
    OR keterangan LIKE ?
    OR no_perka LIKE ?
    ORDER BY id_peralatan ASC ",
  array("%".$key."%","%".$key."%","%".$key."%","%".$key."%","%".$key."%"));
}

$jumlahpage=ceil($jumlahdata / $limit);

$h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
array($_SESSION['kode_satuan_kerja'],"Melihat data peralatan"));

?>

<script type="text/javascript">
$(document).ready(function(){
  var id;

  $(".hapus").click(function(){
    id=$(this).data("id");
    var table="data_peralatan";
    var key="id_peralatan";
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
            <li class="active">Data Peralatan</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Data Peralatan</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Data Peralatan</h4>
                    </div>
                    <div class="panel-body">
                      <form class="" action="" method="post" style="margin-top:5px">
                        <input type="text" name="cari" value="" placeholder="Cari Data" class="form-control">
                      </form>
                      <br>
                      <?php echo $notif;?>
                      <a href="data-peralatanop.php" class="btn btn-primary"><i class="menu-icon icon-plus"></i> Tambah</a>
                       <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                  <th>Kode Perangkat</th>
                                  <th>Kategori</th>
                                  <th>Sub Kategori</th>
                                  <th>Jenis</th>
                                  <th>Satuan</th>
                                  <th>Nama Perangkat</th>
                                  <th>Umur Teknis</th>
                                  <th>Keterangan</th>
                                  <th>No Perka</th>
                                  <th>Operasi</th>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Kode Perangkat</th>
                                <th>Kategori</th>
                                <th>Sub Kategori</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Nama Perangkat</th>
                                <th>Umur Teknis</th>
                                <th>Keterangan</th>
                                <th>No Perka</th>
                                <th>Operasi</th>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($dataperalatan as $value): ?>
                                <tr>
                                  <td><?php echo $value['id_peralatan'] ?></td>
                                  <td><?php echo $value['nama_kategori'] ?></td>
                                  <td><?php echo $value['nama_sub_kategori'] ?></td>
                                  <td><?php echo $value['nama_jenis'] ?></td>
                                  <td><?php echo $value['nama_unit'] ?></td>
                                  <td><?php echo substr($value['nama_perangkat'],0,50) ?></td>
                                  <td><?php echo $value['umur_teknis_alat'] ?></td>
                                  <td><?php echo $value['keterangan'] ?></td>
                                  <td><?php echo $value['no_perka'] ?></td>
                                  <td>
                                    <a style="margin-top:5px" href="data-peralatanop.php?id=<?php echo $value['id_peralatan']?>" class="btn btn-info" data-toggle="tooltip" title="Detail / Edit Data"><i class="menu-icon icon-note"></i></a>
                                    <a style="margin-top:5px" href="#" class="btn hapus btn-danger" data-id="<?php echo $value['id_peralatan']?>" data-toggle="tooltip" title="Hapus Data" ><i class="menu-icon icon-trash"></i></a>
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
                             <li class="waves-effect <?php echo $status?>"><a href="data-peralatan.php?page=<?php echo $i; ?>"><?php echo $i+1 ?></a></li>
                         <?php endfor; ?>

                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
<?php include_once 'footer.php'; ?>
