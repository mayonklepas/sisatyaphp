<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$limit=25;
$jumlahdata;
$posisi=0;
$notif="";
$no=1;
$jumlahdatabalai=$h->read("SELECT COUNT(id_balai) AS jumlah FROM data_balai",null);
foreach ($jumlahdatabalai as $value) {
  $jumlahdata=$value['jumlah'];
}

if (isset($_GET['page'])) {
  //$no=$_GET['offset'];
  $offset=$_GET['page']*$limit;
  $posisi=$_GET['page'];
  $databalai=$h->read("SELECT id_balai, nama_balai FROM data_balai ORDER BY id_balai ASC
    LIMIT ".$limit." OFFSET ".$offset." ",null);

}else{
  $databalai=$h->read("SELECT id_balai, nama_balai FROM data_balai ORDER BY id_balai ASC
    LIMIT ".$limit." ",null);
}

if(isset($_POST['cari'])){
  $key=$_POST['cari'];
  $notif="<div class='alert alert-success'>Hasil Pencarian untuk : <b>".$key."</b></div>";
  $databalai=$h->read("SELECT id_balai, nama_balai FROM data_balai WHERE id_balai LIKE ? OR nama_balai LIKE ? ORDER BY id_balai ASC",
  array("%".$key."%","%".$key."%"));
}

$jumlahpage=ceil($jumlahdata / $limit);

?>

<script type="text/javascript">
$(document).ready(function(){
  var id;

  $(".hapus").click(function(){
    id=$(this).data("id");
    var table="data_balai";
    var key="id_balai";
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

<div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="header">
                      <h4 class="title">Data Balai</h4>
                      <p class="category">Data Balai </p>
                      <form class="" action="" method="post" style="margin-top:5px">
                        <input type="text" name="cari" value="" placeholder="Cari Data" class="form-control">
                      </form>
                      <br>
                      <?php echo $notif;?>
                      <a href="data-balaiop.php" class="btn btn-primary"><i class="pe-7s-plus"></i> Tambah Balai</a>
                  </div>
                  <div class="content table-responsive table-full-width">
                      <table class="table table-hover table-striped">
                          <thead>
                            <th>ID</th>
                            <th>Nama Balai</th>
                            <th>Operasi</th>
                          </thead>
                          <tbody>
                            <?php foreach ($databalai as $value): ?>
                              <tr>
                                <td><?php echo $value['id_balai'] ?></td>
                                <td><?php echo $value['nama_balai'] ?></td>
                                <td>
                                  <a style="margin-top:5px" href="data-balaiop.php?id=<?php echo $value['id_balai']?>" class="btn btn-primary"><i class="pe-7s-note2"></i> Edit</a>
                                  <a style="margin-top:5px" href="#" class="btn hapus btn-danger" data-id="<?php echo $value['id_balai']?>" ><i class="pe-7s-less"></i> Hapus</a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                      </table>
                  </div>
                  <div class="header">
                    <ul class="pagination">

                  <?php for ($i=0; $i < $jumlahpage ; $i++): ?>
                      <?php
                        if ($posisi==$i) {
                          $status="active";
                        }else{
                          $status="";
                        }
                      ?>
                      <li class="waves-effect <?php echo $status?>"><a href="data-balai.php?page=<?php echo $i; ?>"><?php echo $i+1 ?></a></li>
                  <?php endfor; ?>

                    </ul>
                  </div>
              </div>
          </div>
      </div>

    </div>
</div>
<?php include_once 'footer.php'; ?>
