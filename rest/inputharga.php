<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
    $tms=new DateTime();
    $id_acuan=$tms->getTimeStamp();
    $id_user=$_POST['id_user'];
    $kode_alat=$_POST['kode_alat'];
    $nama_alat=$_POST['nama_alat'];
    $satuan_alat=$_POST['satuan_alat'];
    $harga=$_POST['harga'];
    $insert=$h->exec("INSERT INTO data_acuan_harga(id_acuan, id_user, kode_alat, nama_alat, satuan_alat, harga,data_dukung)
     VALUES (?,?,?,?,?,?,'none')",
    array($id_acuan, $id_user, $kode_alat, $nama_alat, $satuan_alat, $harga));
  $res=array(array('kode' => 0 , 'keterangan'=>'Pesan Berhasil Dikirim'));
  echo json_encode(array('status' => $res));
}else{
  $res=array(array('kode' => 1, 'keterangan'=>'Key tidak valid'));
  echo json_encode(array('status' => $res));
}
}else{
  $res=array(array('kode' => 2 , 'keterangan'=>'Key tidak ada'));
  echo json_encode(array('status' => $res));
}

?>
