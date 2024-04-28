<?php 
namespace App\Model\DBConnection;

use \Exception;
use PDO;
use \App\Model\Log\LogManager;
use \App\Controller\Http\Response;
use \App\Controller\Pages\Error;

class Database
{
  const LOG_FILE_SET    = 'databaseLog';
  const LOG_CODE_PREFIX = 'DB-10';

  private static $username ;
  private static $host;
  private static $password;
  private static $dbName;
  private static $conn;

  public static function config($username, $password, $host, $dbName) {
    try { 
      self::$username = $username;
      self::$host     = $password;
      self::$password = $host;
      self::$dbName   = $dbName;
      self::$conn     = new PDO("mysql:dbname=$dbName;host=$host", $username, $password); 
    } catch (Exception $e) {
      self::log(':01', 5,'DB start error => '. $e->getMessage());
      header("Location: " . URL . "/error");
      exit();
    }
  }

  public static function runQuery($query, $params = []){
    $pdo = self::$conn;
    try{
      $stmt = $pdo->prepare($query);
      $stmt->execute($params);
    } catch (Exception $e){
      self::log(':02', 4,'Query fail => '. $query .' | Exception => '. $e->getMessage());
      return null;
    }
  
    return $stmt;
  }

  private static function log($codeSuffix, $severity, $message) {
    LogManager::log(
      self::LOG_CODE_PREFIX . $codeSuffix, 
        $severity, 
        $message, 
        self::LOG_FILE_SET
      );
  }
}