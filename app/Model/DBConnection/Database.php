<?php 
namespace App\Model\DBConnection;

class Database
{
    private static $username ;
    private static $host;
    private static $password ;
    private static $dbName;
    
    private static $conn;

    public static function config($username, $password, $host, $dbName)
    {
        self::$username = $username;
        self::$host = $host;
        self::$password = $password;
        self::$dbName = $dbName;

        $conn = mysqli_connect(self::$host, self::$username, self::$password, self::$dbName);
        if(!$conn) die("Houve um erro: " . mysqli_connect_error());
        self::$conn = $conn;
    }

    public static function simpleInsert($table, $params = []){
        $keys = array_keys($params);
        $values  = array_values($params);
        foreach ($values as &$value) {
            if(gettype($value) == 'string')  $value = "'".$value."'";
        }
        $query = 'INSERT INTO '. $table .' ('.implode(',',$keys).') VALUES ('.implode(',',$values).')';
        
        $result = mysqli_query(self::$conn, $query);
        if($result == true){
            $query = "SELECT * FROM `$table` WHERE ID = LAST_INSERT_ID();";
            
            $result = mysqli_query(self::$conn, $query);
            if (mysqli_num_rows($result) == 1) {
                return mysqli_fetch_assoc($result);
            } else {
                echo "erro";
            }
        }
        die;
    }

    public static function customQuery($query){
        return mysqli_query(self::$conn, $query);
    }

}