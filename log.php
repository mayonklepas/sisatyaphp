<?php
include_once 'navbar.php';
if ($_SESSION['tipe']!=1) {
    header("location:aksesditolak.php");
}
require_once "helper/helper.php";
$h=new Helper();
$notif="";
$datalog=$h->read("SELECT tanggal,nama_satuan_kerja,aksi FROM log_aktivitas INNER JOIN data_user 
ON log_aktivitas.id_user=data_user.kode_satuan_kerja WHERE CAST(tanggal AS DATE)=?",
array(date("Y-m-d")));
if(isset($_POST['filter'])){
  $tanggal=$_POST['tanggal'];
  $notif="<div class='alert alert-success'>Hasil Filter tanggal : <b>".$tanggal."</b></div>";
  $datalog=$h->read("SELECT tanggal,nama_satuan_kerja,aksi FROM log_aktivitas INNER JOIN data_user 
  ON log_aktivitas.id_user=data_user.kode_satuan_kerja WHERE CAST(tanggal AS DATE)=?",
  array($tanggal));
}

?>


<div class="page-inner">
    <div class="page-breadcrumb">
        <ol class="breadcrumb container">
            <li><a href="index.php">Home</a></li>
            <li class="active">Log Aktivitas</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Log Aktivitas</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Log log_aktivitas</h4>
                    </div>
                    <div class="panel-body">
                      

                      <div class="row">
                      
                      <form class="" action="" method="post" style="margin-top:5px">
                      <div class="col-lg-4">
                      <input type="date" name="tanggal" value="<?php echo date("Y-m-d") ?>" class="form-control">
                      </div>

                      <div class="col-lg-2"><button type="submit" name="filter" class="form-control default"> Filter </button></div>
                      </form>
                      
                      </div>

                      
                      <br>
                      <?php echo $notif;?>
                     <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                  <th>Tanggal</th>
                                  <th>Pengguna</th>
                                  <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                              <th>Tanggal</th>
                              <th>Pengguna</th>
                              <th>Aksi</th>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($datalog as $value): ?>
                                <tr>
                                <td><?php echo $value['tanggal'] ?></td>
                                <td><?php echo $value['nama_satuan_kerja'] ?></td>
                                <td><?php echo $value['aksi'] ?></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
<?php include_once 'footer.php'; ?>
