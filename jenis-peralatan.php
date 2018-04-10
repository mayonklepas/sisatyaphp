<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$limit=25;
$jumlahdata;
$posisi=0;
$notif="";
$no=1;
$jumlahdatajenis=$h->read("SELECT COUNT(id_jenis) AS jumlah FROM data_jenis",null);
foreach ($jumlahdatajenis as $value) {
  $jumlahdata=$value['jumlah'];
}

if (isset($_GET['page'])) {
  //$no=$_GET['offset'];
  $offset=$_GET['page']*$limit;
  $posisi=$_GET['page'];
  $datajenis=$h->read("SELECT id_jenis, nama_jenis ,data_jenis.id_sub_kategori,nama_sub_kategori  FROM data_jenis INNER JOIN data_sub_kategori ON data_jenis.id_sub_kategori=data_sub_kategori.id_sub_kategori ORDER BY id_jenis ASC
    LIMIT ".$limit." OFFSET ".$offset." ",null);

}else{
  $datajenis=$h->read("SELECT id_jenis, nama_jenis ,data_jenis.id_sub_kategori,nama_sub_kategori  FROM data_jenis INNER JOIN data_sub_kategori ON data_jenis.id_sub_kategori=data_sub_kategori.id_sub_kategori ORDER BY id_jenis ASC
    LIMIT ".$limit." ",null);
}

if(isset($_POST['cari'])){
  $key=$_POST['cari'];
  $notif="<div class='alert alert-success'>Hasil Pencarian untuk : <b>".$key."</b></div>";
  $datajenis=$h->read("SELECT id_jenis, nama_jenis ,data_jenis.id_sub_kategori,nama_sub_kategori  FROM data_jenis INNER JOIN data_sub_kategori ON data_jenis.id_sub_kategori=data_sub_kategori.id_sub_kategori WHERE id_jenis LIKE ? OR nama_jenis LIKE ? ORDER BY id_jenis ASC",
  array("%".$key."%","%".$key."%"));
}

$jumlahpage=ceil($jumlahdata / $limit);

?>

<script type="text/javascript">
$(document).ready(function(){
  var id;

  $(".hapus").click(function(){
    id=$(this).data("id");
    var table="data_jenis";
    var key="id_jenis";
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
            <li class="active">Data Jenis Peralatan</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Data Jenis Peralatan</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Data Jenis Peralatan</h4>
                    </div>
                    <div class="panel-body">
                      <form class="" action="" method="post" style="margin-top:5px">
                        <input type="text" name="cari" value="" placeholder="Cari Data" class="form-control">
                      </form>
                      <br>
                      <?php echo $notif;?>
                      <a href="jenis-peralatanop.php" class="btn btn-primary"><i class="menu-icon icon-plus"></i> Tambah</a>
                       <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Nama Sub Kategori</th>
                                  <th>Nama Jenis</th>
                                  <th>Operasi</th>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>ID</th>
                                <th>Nama Sub Kategori</th>
                                <th>Nama Jenis</th>
                                <th>Operasi</th>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($datajenis as $value): ?>
                                <tr>
                                  <td><?php echo $value['id_jenis'] ?></td>
                                  <td><?php echo $value['nama_sub_kategori'] ?></td>
                                  <td><?php echo $value['nama_jenis'] ?></td>
                                  <td>
                                    <a style="margin-top:5px" href="jenis-peralatanop.php?id=<?php echo $value['id_jenis']?>" class="btn btn-info" data-toggle="tooltip" title="Detail / Edit Data"><i class="menu-icon icon-note"></i></a>
                                    <a style="margin-top:5px" href="#" class="btn hapus btn-danger" data-id="<?php echo $value['id_jenis']?>" data-toggle="tooltip" title="Hapus Data"><i class="menu-icon icon-trash"></i></a>
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
                             <li class="waves-effect <?php echo $status?>"><a href="jenis-peralatan.php?page=<?php echo $i; ?>"><?php echo $i+1 ?></a></li>
                         <?php endfor; ?>

                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
<?php include_once 'footer.php'; ?>
