<?php
namespace App\Model\Entity\Establishment;

use \App\Model\DBConnection\Database;

class Establishment{
  public $id;
  public $name;
  public $introImageLink;
  public $description;
   
  public static function getTodaysHighlights(){
    $pdo    = Database::getPDO();
    
    try{
      $stmt = $pdo->prepare("SELECT * FROM Establishment ORDER BY ID DESC LIMIT 12");
      $stmt->execute();
    } catch (\throwable $th){
      echo $th;  //precisa de tratamento de exception
      die;
    }

    if (!$stmt->rowCount() > 0) return null;
    
    $return = [];
    foreach ($stmt->fetchAll() as $row)
    {
      $obEstablishment = new Establishment;
      $obEstablishment->id             = $row['ID'];
      $obEstablishment->name           = $row['name'];
      $obEstablishment->description    = $row['description'];
      $obEstablishment->introImageLink = $row['introImage'];
      
      array_push($return, $obEstablishment);
    }
    return $return;
  }

  public static function getById($id){
    $pdo = Database::getPDO();
    try{
      $stmt = $pdo->prepare("SELECT * FROM Establishment WHERE id = :id LIMIT 1");
      $stmt->execute( array(
        'id' => $id
      ));
    } catch (\throwable $th){
      echo $th;  //precisa de tratamento de exception
      die;
    }

    if ($stmt->rowCount() != 1) return null;

    $row = $stmt->fetchAll()[0];

    $obEstablishment = new Establishment;
    $obEstablishment->id             = $row['ID'];
    $obEstablishment->name           = $row['name'];
    $obEstablishment->description    = $row['description'];
    $obEstablishment->introImageLink = $row['introImage'];

    return $obEstablishment;
  }

}