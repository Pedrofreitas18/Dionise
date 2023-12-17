<?php 
namespace App\Model\DBConnection;
use PDO;
class Database
{
    private static $username ;
    private static $host;
    private static $password ;
    private static $dbName;
    private static $conn;

    public static function config($username, $password, $host, $dbName)
    {
        try
        {
            $conn = new PDO("mysql:dbname=$dbName;host=$host", $username, $password); 

            self::$username = $username;
            self::$host     = $host;
            self::$password = $password;
            self::$dbName   = $dbName;
            self::$conn     = $conn;
        } catch (\throwable $th)
        {
            echo $th;
            die;
        }
        
    }

    public static function getPDO()
    {
        return self::$conn;
    }
}