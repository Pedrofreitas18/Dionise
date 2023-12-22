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
    private static $password ;
    private static $dbName;
    private static $conn;

    public static function config($username, $password, $host, $dbName)
    {

        try{
            self::$username = $username;
            self::$host     = $host;
            self::$password = $password;
            self::$dbName   = $dbName;
            self::$conn = new PDO("mysql:dbname=$dbName;host=$host", $username, $password); 
        } catch (Exception $e)
        {
           LogManager::log(Database::LOG_CODE_PREFIX . ':01', 5, $e->getMessage(), Database::LOG_FILE_SET);
           echo $e->getMessage();
           die;
        }
        
    }

    public static function getPDO()
    {
        return self::$conn;
    }
}