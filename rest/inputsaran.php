<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
    $kode_satuan_kerja=$_POST['kode_satuan_kerja'];
    $judul=$_POST['judul'];
    $pesan=$_POST['pesan'];
    $insert=$h->exec("INSERT INTO data_saran(kode_satuan_kerja, judul, pesan) VALUES (?,?,?)",
    array($kode_satuan_kerja, $judul, $pesan));
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
