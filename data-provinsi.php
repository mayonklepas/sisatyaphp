<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$limit=20;
$jumlahdata;
$posisi=0;
$notif="";
$no=1;
$jumlahdataprovinsi=$h->read("SELECT COUNT(id_provinsi) AS jumlah FROM data_provinsi",null);
foreach ($jumlahdataprovinsi as $value) {
  $jumlahdata=$value['jumlah'];
}

if (isset($_GET['page'])) {
  //$no=$_GET['offset'];
  $offset=$_GET['page']*$limit;
  $posisi=$_GET['page'];
  $dataprovinsi=$h->read("SELECT id_provinsi, nama_provinsi,nama_balai FROM data_provinsi ORDER BY id_provinsi ASC
    LIMIT ".$limit." OFFSET ".$offset." ",null);

}else{
  $dataprovinsi=$h->read("SELECT id_provinsi, nama_provinsi,nama_balai FROM data_provinsi ORDER BY id_provinsi ASC
    LIMIT ".$limit." ",null);
}

if(isset($_POST['cari'])){
  $key=$_POST['cari'];
  $notif="<div class='alert alert-success'>Hasil Pencarian untuk : <b>".$key."</b></div>";
  $dataprovinsi=$h->read("SELECT id_provinsi, nama_provinsi,nama_balai FROM data_provinsi WHERE id_provinsi LIKE ? OR nama_provinsi LIKE ? ORDER BY id_provinsi ASC",
  array("%".$key."%","%".$key."%"));
}

$jumlahpage=ceil($jumlahdata / $limit);
$h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
array($_SESSION['kode_satuan_kerja'],"Melihat data provinsi"));

?>

<script type="text/javascript">
$(document).ready(function(){
  var id;

  $(".hapus").click(function(){
    id=$(this).data("id");
    var table="data_provinsi";
    var key="id_provinsi";
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
            <li class="active">Data Provinsi</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Data Provinsi</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Data Provinsi</h4>
                    </div>
                    <div class="panel-body">
                      <form class="" action="" method="post" style="margin-top:5px">
                        <input type="text" name="cari" value="" placeholder="Cari Data" class="form-control">
                      </form>
                      <br>
                      <?php echo $notif;?>
                      <a href="data-provinsiop.php" class="btn btn-primary"><i class="menu-icon icon-plus"></i> Tambah</a>
                       <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Nama Provinsi</th>
                                  <th>Nama Balai</th>
                                  <th>Operasi</th>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>ID</th>
                                <th>Nama Provinsi</th>
                                <th>Nama Balai</th>
                                <th>Operasi</th>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($dataprovinsi as $value): ?>
                                <tr>
                                  <td><?php echo $value['id_provinsi'] ?></td>
                                  <td><?php echo $value['nama_provinsi'] ?></td>
                                  <td><?php echo $value['nama_balai'] ?></td>
                                  <td>
                                    <a style="margin-top:5px" href="data-provinsiop.php?id=<?php echo $value['id_provinsi']?>" class="btn btn-info" data-toggle="tooltip" title="Detail / Edit Data"><i class="menu-icon icon-note"></i></a>
                                    <a style="margin-top:5px" href="#" class="btn hapus btn-danger" data-id="<?php echo $value['id_provinsi']?>" data-toggle="tooltip" title="Hapus Data"><i class="menu-icon icon-trash"></i></a>
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
                             <li class="waves-effect <?php echo $status?>"><a href="data-provinsi.php?page=<?php echo $i; ?>"><?php echo $i+1 ?></a></li>
                         <?php endfor; ?>

                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
    
<?php include_once 'footer.php'; ?>
