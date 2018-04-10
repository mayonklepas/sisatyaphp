<?php
require_once '../helper/helper.php';
$h=new Helper();
$res="";
if(isset($_POST['key'])){
  if($_POST['key']=="bk201!@#"){
    if(isset($_POST['keyword'])){
      $id_provinsi=$_POST['id_provinsi'];
      $id_jenis=$_POST['id_jenis'];
      $keyword="%".$_POST['keyword']."%";
    $data=$h->read("SELECT dh.id_peralatan,
    dp.id_jenis,dj.nama_jenis,dp.id_unit,dk.nama_kategori,dsk.nama_sub_kategori,
    dun.nama_unit,dp.nama_perangkat,dp.umur_teknis_alat,dp.keterangan,dp.no_perka,dh.tanggal,dh.tahun_harga,
    dh.harga_tahun FROM data_harga dh
    LEFT JOIN data_peralatan dp ON dh.id_peralatan=dp.id_peralatan
    LEFT JOIN data_jenis dj ON dp.id_jenis=dj.id_jenis
    LEFT JOIN data_sub_kategori dsk ON dj.id_sub_kategori=dsk.id_sub_kategori
    LEFT JOIN data_kategori dk ON dsk.id_kategori=dk.id_kategori
    LEFT JOIN data_unit dun ON dp.id_unit=dun.id_unit
    WHERE  (dj.nama_jenis LIKE ?
        OR umur_teknis_alat LIKE ?
        OR nama_perangkat LIKE ?
        OR dh.tanggal LIKE ?
        OR dh.harga_tahun LIKE ?)
        AND dp.id_jenis=?",array($keyword,$keyword,$keyword,
        $keyword,$keyword,$id_jenis));
    $res=array(array('kode' =>  0, 'keterangan'=>'sukses'));
    echo json_encode(array('status' => $res, 'data'=>$data) );
  }else{
    $id_provinsi=$_POST['id_provinsi'];
    $id_jenis=$_POST['id_jenis'];
    $data=$h->read("SELECT dh.id_peralatan,dp.id_jenis,dj.nama_jenis,dp.id_unit,dk.nama_kategori,dsk.nama_sub_kategori,
    dun.nama_unit,dp.nama_perangkat,dp.umur_teknis_alat,dp.keterangan,dp.no_perka,dh.tanggal,dh.tahun_harga,
    dh.harga_tahun FROM data_harga dh
    LEFT JOIN data_peralatan dp ON dh.id_peralatan=dp.id_peralatan
    LEFT JOIN data_jenis dj ON dp.id_jenis=dj.id_jenis
    LEFT JOIN data_sub_kategori dsk ON dj.id_sub_kategori=dsk.id_sub_kategori
    LEFT JOIN data_kategori dk ON dsk.id_kategori=dk.id_kategori
    LEFT JOIN data_unit dun ON dp.id_unit=dun.id_unit
    WHERE dp.id_jenis=?",array($id_jenis));
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
