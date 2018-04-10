<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
  $id_kategori=$_POST['id_kategori'];
  $data=$h->read("SELECT id_sub_kategori,nama_sub_kategori FROM data_sub_kategori WHERE id_kategori=? ",array($id_kategori));
  $res=array(array('kode' =>  0, 'keterangan'=>'sukses'));
  echo json_encode(array('status' => $res, 'data'=>$data) );
}else{
  $res=array(array('kode' => 1 , 'keterangan'=>'key tidak valid'));
  echo json_encode(array('status' => $res));
}
}else{
  $res=array(array('kode' => 2 , 'keterangan'=>'key tidak ada'));
  echo json_encode(array('status' => $res));
}

?>
