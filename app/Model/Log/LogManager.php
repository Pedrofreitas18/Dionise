<?php
namespace App\Model\Log;

use \App\Model\Enum\NotificationSeverity;

class LogManager{

    public static function log($code, $severity, $message, $fileSet){        
        try {
            $logFile = new LogFile(LogFile::generatePath($fileSet, date('Y_m_d')));
            $logFile->addLogLines([new LogLine($code, $severity, date('Y-m-d H:i:s'), $message)]);
            $logFile->upsert();

            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function purge($filtro, $logFiles) {
        $filtredList = array_filter($logFiles, $filtro);
        array_map(fn($file) => $file->delete(), $filtredList);
    }

}

