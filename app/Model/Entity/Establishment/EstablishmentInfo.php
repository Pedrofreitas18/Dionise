<?php
namespace App\Model\Entity\Establishment;

use \Exception;
use \App\Model\DBConnection\Database;
use \App\Model\Log\LogManager;

class EstablishmentInfo{
    private $id;
    private $sequence;
    private $title;
    private $text;
    private $establishmentID;

    public function __construct($id = '', $sequence = '', $title = '', $text = '', $establishmentID = '') {
        $this->id              = $id;
        $this->sequence        = $sequence;
        $this->title           = $title;
        $this->text            = $text;
        $this->establishmentID = $establishmentID;
    }

 //gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function getId()              { return $this->id; }
    public function getSequence()        { return $this->sequence; }
    public function getTitle()           { return $this->title; }
    public function getText()            { return $this->text; }
    public function getEstablishmentID() { return $this->establishmentID; }

    public function setId($id)                           { $this->id = $id; }
    public function setSequence($sequence)               { $this->sequence = $sequence; }
    public function setTitle($title)                     { $this->title = $title; }
    public function setText($text)                       { $this->text = $text; }
    public function setEstablishmentID($establishmentID) { $this->establishmentID = $establishmentID; }

//Read_________________________________________________________________________________________________________________________________________________________________
    public static function getEstablishmentInfos($establishmentId) 
    {
        $stmt = Database::runQuery(
            "SELECT * FROM EstablishmentInfo WHERE establishment = :establishment", 
             array('establishment' => $establishmentId)
          );
          
          return self::stmtToEstablishmentInfo($stmt);
    } 

//Other________________________________________________________________________________________________________________________________________________________________
    public static function stmtToEstablishmentInfo($stmt) 
    {
        if ($stmt->rowCount() == 0) return [];
      
        $establishmentInfoArray = array_map(
            fn($row) => new EstablishmentInfo(
                $row['ID'],
                $row['sequence'],
                $row['title'],
                $row['text'],
                $row['establishment']
            ),
            $stmt->fetchAll()
        ); 
      
        return $establishmentInfoArray;
        //return count($establishmentInfoArray) == 1 ? $establishmentInfoArray[0] : $establishmentInfoArray;
    }
}