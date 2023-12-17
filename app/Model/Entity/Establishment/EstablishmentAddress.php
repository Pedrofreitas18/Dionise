<?php
namespace App\Model\Entity\Establishment;

use \App\Model\DBConnection\Database;

class EstablishmentAddress{

  public $id;
  public $city;
  public $state;
  public $neighborhood;
  public $address;
  public $number;
  public $complement;
  public $cep;

  public static function getByEstablishmentId($establishmentID){
    $pdo = Database::getPDO();
    try{
      $stmt = $pdo->prepare("SELECT * FROM EstablishmentAddress WHERE establishment = :establishment LIMIT 1");
      $stmt->execute( array(
        'establishment' => $establishmentID
      ));
    } catch (\throwable $th){
      echo $th;  //precisa de tratamento de exception
      die;
    }

    if ($stmt->rowCount() != 1) return null;
    
    $row = $result = $stmt->fetchAll()[0];

    $obAddress = new Establishment;
    $obAddress->id           = $row['ID'];
    $obAddress->city         = $row['city'];
    $obAddress->state        = $row['state'];
    $obAddress->neighborhood = $row['neighborhood'];
    $obAddress->address      = $row['address'];
    $obAddress->number       = $row['number'];
    $obAddress->complement   = $row['complement'];
    $obAddress->cep          = $row['cep'];
      
    return $obAddress;
  }

}