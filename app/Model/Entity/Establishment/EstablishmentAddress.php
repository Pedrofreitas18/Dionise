<?php
namespace App\Model\Entity\Establishment;

use \Exception;
use \App\Model\DBConnection\Database;
use \App\Model\Log\LogRegister;

class EstablishmentAddress{
  const LOG_FILE_SET    = 'databaseLog';
  const LOG_CODE_PREFIX = 'ET-12';

  public $id;
  public $city;
  public $state;
  public $neighborhood;
  public $address;
  public $number;
  public $complement;
  public $cep;

  public static function getByEstablishmentId($establishmentID){
    $query = "SELECT * FROM EstablishmentAddress WHERE establishment = :establishment LIMIT 1";
    
    $pdo = Database::getPDO();
    try{
      $stmt = $pdo->prepare($query);
      $stmt->execute( array(
        'establishment' => $establishmentID
      ));
    } catch (Exception $e){
      LogRegister::newLogLine(
        EstablishmentAddress::LOG_CODE_PREFIX .':01', 
        4, 
        'Query fail => '. $query .' | Exception => '. $e->getMessage(), 
        EstablishmentAddress::LOG_FILE_SET
      );
      return null;
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