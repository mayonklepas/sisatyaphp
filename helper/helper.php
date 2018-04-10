<?php

/**
 *
 */

error_reporting(E_ALL);

class Helper{

  public function conn(){
    try {
      $pdo=new PDO("mysql:host=127.0.0.1;dbname=sisatyadb", "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    return $pdo;

  }


  public function read($sql,$value){
    $statement=$this->conn()->prepare($sql);
    $statement->execute($value);
    $array=array();
    while ($data=$statement->fetch(PDO::FETCH_ASSOC)) {
      $array[]=$data;
    }
    return $array;
  }


  public function exec($sql,$value){
    $statement=$this->conn()->prepare($sql);
    $statement->execute($value);
    return $statement;
  }


}


?>
