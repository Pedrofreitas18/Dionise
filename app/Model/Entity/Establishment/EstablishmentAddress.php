<?php
namespace App\Model\Entity\Establishment;

use \Exception;
use \App\Model\DBConnection\Database;
use \App\Model\Log\LogManager;

class EstablishmentAddress{
  private $id;
  private $city;
  private $state;
  private $neighborhood;
  private $address;
  private $number;
  private $complement;
  private $cep;

  public function __construct($id = '', $city = '', $state = '', $neighborhood = '', $address = '', $number = '', $complement = '', $cep = '') {
    $this->id           = $id;
    $this->city         = $city;
    $this->state        = $state;
    $this->neighborhood = $neighborhood;
    $this->address      = $address;
    $this->number       = $number;
    $this->complement   = $complement;
    $this->cep          = $cep;
  }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
  public function getId()           { return $this->id; }
  public function getCity()         { return $this->city; }
  public function getState()        { return $this->state; }
  public function getNeighborhood() { return $this->neighborhood; }
  public function getAddress()      { return $this->address; }
  public function getNumber()       { return $this->number; }
  public function getComplement()   { return $this->complement; }
  public function getCep()          { return $this->cep; }

  public function setId($id)                     { $this->id = $id; }
  public function setCity($city)                 { $this->city = $city; }
  public function setState($state)               { $this->state = $state; }
  public function setNeighborhood($neighborhood) { $this->neighborhood = $neighborhood; }
  public function setAddress($address)           { $this->address = $address; }
  public function setNumber($number)             { $this->number = $number; }
  public function setComplement($complement)     { $this->complement = $complement; }
  public function setCep($cep)                   { $this->cep = $cep; }

//Read_________________________________________________________________________________________________________________________________________________________________
  public static function getByEstablishmentId($establishmentID){
    $stmt = Database::runQuery(
      "SELECT * FROM EstablishmentAddress WHERE establishment = :establishment LIMIT 1", 
       array('establishment'  =>  $establishmentID)
    );
    
    return self::stmtToEstablishmentAddress($stmt);
  }

//Other________________________________________________________________________________________________________________________________________________________________

  public static function stmtToEstablishmentAddress($stmt) 
  {
    if ($stmt->rowCount() == 0) return [];

    $establishmentAddressArray = array_map(
      fn($row) => new EstablishmentAddress(
        $row['ID'],
        $row['city'],
        $row['state'],
        $row['neighborhood'],
        $row['address'],
        $row['number'],
        $row['complement'],
        $row['cep']
      ),
      $stmt->fetchAll()
    ); 

    return $establishmentAddressArray;
  
    //return count($establishmentAddressArray) == 1 ? $establishmentAddressArray[0] : $establishmentAddressArray;
  }

}
