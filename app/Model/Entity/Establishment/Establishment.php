<?php
namespace App\Model\Entity\Establishment;

use \Exception;
use \App\Model\DBConnection\Database;
use \App\Model\Log\LogManager;

class Establishment{
  const LOG_FILE_SET    = 'databaseLog';
  const LOG_CODE_PREFIX = 'ET-10';

  public $id;
  public $name;
  public $introImageLink;
  public $description;
   
  public static function getTodaysHighlights($idPage){
    $idInit  = (int) ($idPage * 12) - 11;
    $idFinal = (int)  $idPage * 12;
    $query = "SELECT * FROM Establishment WHERE id >= :idInit AND id <= :idFinal ORDER BY ID ASC LIMIT 12";
    
    $pdo    = Database::getPDO();
    try{
      $stmt = $pdo->prepare($query);
      $stmt->execute( array(
        'idInit'  =>  $idInit,
        'idFinal' =>  $idFinal
      ));
    } catch (Exception $e){
      Manager::log(
        Establishment::LOG_CODE_PREFIX .':01', 
        4, 
        'Query fail => '. $query .' | Exception => '. $e->getMessage(), 
        Establishment::LOG_FILE_SET
      );
      return null;
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
    $query = "SELECT * FROM Establishment WHERE id = :id LIMIT 1";
    
    $pdo = Database::getPDO();
    try{
      $stmt = $pdo->prepare($query);
      $stmt->execute( array(
        'id' => $id
      ));
    } catch (Exception $e){
      LogManager::log(
        Establishment::LOG_CODE_PREFIX .':02', 
        4, 
        'Query fail => '. $query .' | Exception => '. $e->getMessage(), 
        Establishment::LOG_FILE_SET
      );
      return null;
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

  public static function getNumberOfEstablishments(){
    $query = "SELECT COUNT(ID) as count FROM Establishment LIMIT 1";

    $pdo = Database::getPDO();
    try{
      $stmt = $pdo->prepare($query);
      $stmt->execute();
    } catch (Exception $e){
      LogManager::log(
        Establishment::LOG_CODE_PREFIX .':03', 
        4, 
        'Query fail => '. $query .' | Exception => '. $e->getMessage(), 
        Establishment::LOG_FILE_SET
      );
      return null;
    }

    if ($stmt->rowCount() != 1) return null;

    $row = $stmt->fetchAll()[0];
    return $row['count'];
  }

}