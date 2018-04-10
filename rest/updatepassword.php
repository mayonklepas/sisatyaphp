<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
    $kode_satuan_kerja=$_POST['kode_satuan_kerja'];
    $password=$_POST['password'];
    $h->exec("UPDATE data_user SET password=? WHERE kode_satuan_kerja=? ",
    array($password,$kode_satuan_kerja));
  $res=array(array('kode' => 0 , 'keterangan'=>'Password Berhasil Diupdate','newpwd'=>$password));
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
