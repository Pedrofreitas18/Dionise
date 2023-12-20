<?php
namespace App\Model\Entity\Establishment;

use \App\Model\DBConnection\Database;
use \App\Model\Log\LogRegister;

class EstablishmentInfo{
    const LOG_FILE_SET    = 'databaseLog';
    const LOG_CODE_PREFIX = 'ET-11';

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
            LogRegister::newLogLine(
                EstablishmentInfo::LOG_CODE_PREFIX .':01', 
                4, 
                'Query fail => '. $query .' | Exception => '. $e->getMessage(), 
                EstablishmentInfo::LOG_FILE_SET
              );
            return null;
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