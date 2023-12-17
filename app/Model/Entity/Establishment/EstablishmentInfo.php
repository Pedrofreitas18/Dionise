<?php
namespace App\Model\Entity\Establishment;

use \App\Model\DBConnection\Database;

class EstablishmentInfo{
    public $id;
    public $sequence;
    public $title;
    public $text;
    public $establishmentID;

    public static function getEstablishmentInfos($establishmentId){
        $pdo = Database::getPDO();
        try {
            $stmt = $pdo->prepare("SELECT * FROM EstablishmentInfo WHERE establishment = :establishment");
            $stmt->execute( array(
                'establishment' => $establishmentId
            ));
        } catch (\throwable $th) {
          echo $th; //precisa de tratamento de exception
          die;
        }

        if (!$stmt->rowCount() > 0) return null;
    
        $return = [];
        foreach ($stmt->fetchAll() as $row)
        {
            $obInfo = new EstablishmentInfo;
            $obInfo->id              = $row['ID'];
            $obInfo->sequence        = $row['sequence'];
            $obInfo->title           = $row['title'];
            $obInfo->text            = $row['text'];
            $obInfo->establishmentID = $row['establishment'];
          
            array_push($return, $obInfo);
        }
        return $return;
      }

}