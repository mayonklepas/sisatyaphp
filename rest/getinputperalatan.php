<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
  $kategori=$h->read("SELECT id_kategori,nama_kategori FROM data_kategori",null);
  $jenis=$h->read("SELECT id_jenis,nama_jenis FROM data_jenis",null);
  $unit=$h->read("SELECT id_unit,nama_unit FROM data_unit",null);
  $res=array(array('kode' =>  0, 'keterangan'=>'sukses'));
  echo json_encode(array('status' => $res, 'kategori'=>$kategori,'jenis'=>$jenis,'unit'=>$unit) );
}else{
  $res=array(array('kode' => 1 , 'keterangan'=>'key tidak valid'));
  echo json_encode(array('status' => $res));
}
}else{
  $res=array(array('kode' => 2 , 'keterangan'=>'key tidak ada'));
  echo json_encode(array('status' => $res));
}

?>
