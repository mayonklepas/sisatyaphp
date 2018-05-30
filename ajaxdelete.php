<?php
require_once "helper/helper.php";
$h=new Helper();
if(isset($_POST['id'])){
  $table=$_POST['table'];
  $id=$_POST['id'];
  $key=$_POST['key'];
  $h->exec("DELETE FROM ".$table." WHERE ".$key."=? ",array($id));
  $h->exec("INSERT INTO log_aktivitas (id_user,aksi) VALUES(?,?)",
  array($_SESSION['kode_satuan_kerja'],"Menghapus data ".$table." dengan id ".$id.""));
  echo "Data Berhasil Dihapus";
}

 ?>
