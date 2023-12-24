<?php
namespace App\Model\Log;

use \App\Model\Enum\NotificationSeverity;
use \App\Model\Entity\Log\LogFile;
use \App\Model\Entity\Log\LogLine;

class LogManager{

    public static function log($code, $severity, $message, $fileSet){        
        $logFile = LogFile::openFile($fileSet, date('Y_m_d'));
        $logFile->addLogLines([new LogLine($code, $severity, date('Y-m-d H:i:s'), $message)]);
        $logFile->upsert();
    }
    
    public static function purge($filtro, $logFiles) {
        array_map(
            fn($file) => $file->delete(), 
            array_filter($logFiles, $filtro)
        );
    }
}

