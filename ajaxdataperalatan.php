<?php
require_once "helper/helper.php";
$h=new Helper();
if(isset($_POST['key'])){
  $key=$_POST['key'];
  $data=$h->read("SELECT nama_perangkat FROM data_peralatan WHERE id_peralatan = ? LIMIT 1",array($key));
  foreach ($data as $value) {
    echo $value['nama_perangkat'];
  }
}

 ?>
