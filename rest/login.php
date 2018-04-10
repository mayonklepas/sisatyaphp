<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
    $kode_satuan_kerja=$_POST['kode_satuan_kerja'];
    $password=$_POST['password'];
  $data=$h->read("SELECT COUNT(kode_satuan_kerja) AS jumlah,kode_satuan_kerja,nama_satuan_kerja,
    data_user.id_provinsi,alamat,password,nama_provinsi,alamat,password 
    FROM data_user INNER JOIN data_provinsi ON data_user.id_provinsi=data_provinsi.id_provinsi
    WHERE kode_satuan_kerja=? AND password=? LIMIT 1",array($kode_satuan_kerja,$password));
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
