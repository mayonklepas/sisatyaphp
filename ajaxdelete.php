<?php
require_once "helper/helper.php";
$h=new Helper();
if(isset($_POST['id'])){
  $table=$_POST['table'];
  $id=$_POST['id'];
  $key=$_POST['key'];
  $h->exec("DELETE FROM ".$table." WHERE ".$key."=? ",array($id));
  echo "Data Berhasil Dihapus";
}

 ?>
