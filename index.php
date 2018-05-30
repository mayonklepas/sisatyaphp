<?php
include_once 'navbar.php';
require_once "helper/helper.php";
$h=new Helper();
$datahargaup=$h->read("SELECT id_harga,tanggal,tahun_harga,data_harga.id_peralatan,nama_perangkat,harga_tahun,data_dukung,nama_provinsi FROM data_harga
LEFT JOIN data_peralatan ON data_harga.id_peralatan=data_peralatan.id_peralatan
LEFT JOIN data_provinsi ON data_harga.id_provinsi=data_provinsi.id_provinsi ORDER BY harga_tahun DESC
LIMIT 10 ",null);

$datahargadown=$h->read("SELECT id_harga,tanggal,tahun_harga,data_harga.id_peralatan,nama_perangkat,harga_tahun,data_dukung,nama_provinsi FROM data_harga
LEFT JOIN data_peralatan ON data_harga.id_peralatan=data_peralatan.id_peralatan
LEFT JOIN data_provinsi ON data_harga.id_provinsi=data_provinsi.id_provinsi ORDER BY harga_tahun ASC
LIMIT 10 ",null);

$h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
array($_SESSION['kode_satuan_kerja'],"Melihat Dasboard Aplikasi"));

?>
<div class="page-inner">
    <div class="page-breadcrumb">
        <ol class="breadcrumb container">
            <li><a href="index.php">Home</a></li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">
            <h3>Home</h3>
        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title">10 Harga Peralatan Tertinggi</h3>
                    </div>
                    <div class="panel-body">
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
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($datahargaup as $value): ?>
                                <tr>
                                  <td><?php echo $value['id_harga'] ?></td>
                                  <td><?php echo date("d F Y",strtotime($value['tanggal'])) ?></td>
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
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                           </table>
                        </div>
                    </div>
                </div>
            </div>

        <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title">10 Harga Peralatan Terendah</h3>
                    </div>
                    <div class="panel-body">
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
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php foreach ($datahargadown as $value): ?>
                                <tr>
                                  <td><?php echo $value['id_harga'] ?></td>
                                  <td><?php echo date("d F Y",strtotime($value['tanggal'])) ?></td>
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
