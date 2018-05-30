<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$limit=25;
$jumlahdata;
$posisi=0;
$notif="";
$no=1;
$jumlahdatauser=$h->read("SELECT COUNT(kode_satuan_kerja) AS jumlah FROM data_user",null);
foreach ($jumlahdatauser as $value) {
  $jumlahdata=$value['jumlah'];
}

if (isset($_GET['page'])) {
  $offset=$_GET['page']*$limit;
  $posisi=$_GET['page'];
  $datauser=$h->read("SELECT kode_satuan_kerja,nama_satuan_kerja,data_user.id_provinsi,alamat,password,nama_provinsi FROM data_user
    INNER JOIN data_provinsi ON data_user.id_provinsi=data_provinsi.id_provinsi ORDER BY kode_satuan_kerja ASC
    LIMIT ".$limit." OFFSET ".$offset." ",null);

}else{
  $datauser=$h->read("SELECT kode_satuan_kerja,nama_satuan_kerja,data_user.id_provinsi,alamat,password,nama_provinsi FROM data_user
    INNER JOIN data_provinsi ON data_user.id_provinsi=data_provinsi.id_provinsi ORDER BY kode_satuan_kerja ASC
    LIMIT ".$limit." ",null);
}

if(isset($_POST['cari'])){
  $key=$_POST['cari'];
  $notif="<div class='alert alert-success'>Hasil Pencarian untuk : <b>".$key."</b></div>";
  $datauser=$h->read("SELECT kode_satuan_kerja,nama_satuan_kerja,data_user.id_provinsi,alamat,password,nama_provinsi FROM data_user
    INNER JOIN data_provinsi ON data_user.id_provinsi=data_provinsi.id_provinsi
    WHERE kode_satuan_kerja LIKE ?
    OR nama_satuan_kerja LIKE ?
    OR nama_provinsi LIKE ?
    ORDER BY kode_satuan_kerja ASC ",
  array("%".$key."%","%".$key."%","%".$key."%"));
}

$jumlahpage=ceil($jumlahdata / $limit);


$h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
array($_SESSION['kode_satuan_kerja'],"Melihat data user"));

?>

<script type="text/javascript">
$(document).ready(function(){
  var id;

  $(".hapus").click(function(){
    id=$(this).data("id");
    var table="data_user";
    var key="kode_satuan_kerja";
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
            <li class="active">Data User</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Data Users</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Data User</h4>
                    </div>
                    <div class="panel-body">
                      <form class="" action="" method="post" style="margin-top:5px">
                        <input type="text" name="cari" value="" placeholder="Cari Data" class="form-control">
                      </form>
                      <br>
                      <?php echo $notif;?>
                      <?php if($_SESSION['tipe']==1):?>
                      <a href="data-userop.php" class="btn btn-primary"><i class="menu-icon icon-plus"></i> Tambah</a>
                      <?php endif;?>
                       <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                  <th>Kode Satuan Kerja</th>
                                  <th>Nama Satuan Kerja</th>
                                  <th>Nama Provinsi</th>
                                  <th>Alamat</th>
                                  <?php if($_SESSION['tipe']==1):?>
                                  <th>Operasi</th>
                                  <?php endif;?>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Kode Satuan Kerja</th>
                                <th>Nama Satuan Kerja</th>
                                <th>Nama Provinsi</th>
                                <th>Alamat</th>
                                <?php if($_SESSION['tipe']==1):?>
                                <th>Operasi</th>
                                <?php endif;?>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($datauser as $value): ?>
                                <tr>
                                  <td><?php echo $value['kode_satuan_kerja'] ?></td>
                                  <td><?php echo substr($value['nama_satuan_kerja'],0,30) ?></td>
                                  <td><?php echo $value['nama_provinsi'] ?></td>
                                  <td><?php echo substr($value['alamat'],0,30) ?></td>
                                  <?php if($_SESSION['tipe']==1):?>
                                  <td>
                                    <a style="margin-top:5px" href="data-userop.php?id=<?php echo $value['kode_satuan_kerja']?>" class="btn btn-info" data-toggle="tooltip" title="Detail / Edit Data"><i class="menu-icon icon-note"></i></a>
                                    <a style="margin-top:5px" href="#" class="btn hapus btn-danger" data-id="<?php echo $value['kode_satuan_kerja']?>" data-toggle="tooltip" title="Hapus Data"><i class="menu-icon icon-trash"></i></a>
                                  </td>
                                  <?php endif;?>
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
                             <li class="waves-effect <?php echo $status?>"><a href="data-user.php?page=<?php echo $i; ?>"><?php echo $i+1 ?></a></li>
                         <?php endfor; ?>

                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
<?php include_once 'footer.php'; ?>
