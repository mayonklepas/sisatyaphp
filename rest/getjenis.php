<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
  $id_sub_kategori=$_POST['id_sub_kategori'];
  $data=$h->read("SELECT id_jenis,nama_jenis FROM data_jenis WHERE id_sub_kategori=?",array($id_sub_kategori));
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
