<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
    if(isset($_POST['keyword'])){
      $keyword="%".$_POST['keyword']."%";
      $data=$h->read("SELECT dah.id_acuan,dah.id_user,du.nama_satuan_kerja,dp.nama_provinsi,dah.kode_alat,dah.nama_alat,dah.satuan_alat,
         dah.harga, dah.tanggal, dah.data_dukung,dp.nama_balai FROM data_acuan_harga dah
         INNER JOIN data_user du ON dah.id_user=du.kode_satuan_kerja
         INNER JOIN data_provinsi dp ON du.id_provinsi=d h.id_provinsi
         WHERE
         (dah.nama_alat LIKE ?
         OR dah.nama_alat LIKE ?
         OR dah.satuan_alat LIKE ?
         OR du.nama_satuan_kerja LIKE ?
         OR dah.tanggal LIKE ?) AND EXTRACT(YEAR FROM dah.tanggal) = YEAR(NOW()) ",array($keyword,$keyword,$keyword,$keyword,$keyword));
      $res=array(array('kode' =>  0, 'keterangan'=>'sukses'));
      echo json_encode(array('status' => $res, 'data'=>$data) );
    }else {
      $data=$h->read("SELECT dah.id_acuan,dah.id_user,du.nama_satuan_kerja,dp.nama_provinsi,dah.kode_alat,dah.nama_alat,dah.satuan_alat,
         dah.harga, dah.tanggal, dah.data_dukung,dp.nama_balai FROM data_acuan_harga dah
         INNER JOIN data_user du ON dah.id_user=du.kode_satuan_kerja
         INNER JOIN data_provinsi dp ON du.id_provinsi=dp.id_provinsi
         WHERE EXTRACT(YEAR FROM dah.tanggal) = YEAR(NOW())",null);
      $res=array(array('kode' =>  0, 'keterangan'=>'sukses'));
      echo json_encode(array('status' => $res, 'data'=>$data) );
    }
}else{
  $res=array(array('kode' => 1 , 'keterangan'=>'key tidak valid'));
  echo json_encode(array('status' => $res));
}
}else{
  $res=array(array('kode' => 2 , 'keterangan'=>'key tidak ada'));
  echo json_encode(array('status' => $res));
}

?>
