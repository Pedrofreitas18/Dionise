<?php
namespace App\Model\Entity\Establishment;

use \Exception;
use \App\Model\DBConnection\Database;
use \App\Model\Log\LogManager;

class Establishment{
  private $id;
  private $name;
  private $introImageLink;
  private $description;

  public function __construct($id = '', $name = '', $introImageLink = '', $description = '') {
    $this->id             = $id;
    $this->name           = $name;
    $this->introImageLink = $introImageLink;
    $this->description    = $description;
  }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
  public function getId()             { return $this->id; }
  public function getName()           { return $this->name; }
  public function getIntroImageLink() { return $this->introImageLink; }
  public function getDescription()    { return $this->description; }
  
  public function setId($id)                         { $this->id = $id; }
  public function setName($name)                     { $this->name = $name; }
  public function setIntroImageLink($introImageLink) { $this->introImageLink = $introImageLink; }
  public function setDescription($description)       { $this->description = $description; }
  
  
//Read_________________________________________________________________________________________________________________________________________________________________
  public static function getTodaysHighlights($idPage)
  {
    $idInit  = (int) ($idPage * 12) - 11;
    $idFinal = (int)  $idPage * 12;

    $stmt = Database::runQuery(
      "SELECT * FROM Establishment WHERE id >= :idInit AND id <= :idFinal ORDER BY ID ASC LIMIT 12", 
       array('idInit'  =>  $idInit, 'idFinal' =>  $idFinal)
    );
    
    return self::stmtToEstablishments($stmt);
  }

  public static function getById($id)
  {
    $stmt = Database::runQuery(
      "SELECT * FROM Establishment WHERE id = :id LIMIT 1", 
       array('id' => $id)
    );
    
    return self::stmtToEstablishments($stmt);
  }

  public static function getNumberOfEstablishments()
  {
    $stmt = Database::runQuery("SELECT COUNT(ID) as count FROM Establishment LIMIT 1");

    return $stmt->rowCount() != 1 
      ? null
      : $stmt->fetchAll()[0]['count'];
  }

//Other________________________________________________________________________________________________________________________________________________________________

  public static function stmtToEstablishments($stmt) 
  {
    if ($stmt->rowCount() == 0) return [];

    $establishmentArray = array_map(
      fn($row) => new Establishment($row['ID'], $row['name'], $row['introImage'], $row['description']),
      $stmt->fetchAll()
    ); 
    
    return $establishmentArray;
    //return count($establishmentArray) == 1 ? $establishmentArray[0] : $establishmentArray;
  }
}