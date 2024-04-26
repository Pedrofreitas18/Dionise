<?php
namespace App\Model\Log;

use \DateTime;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\Log\LogFile;
use \App\Utils\DateTimeTool;
use \App\Utils\DataValidator;

class LogManager { 

    const LOG_FILES_ROUTE = __DIR__ ."\\files\\";

//Service______________________________________________________________________________________________________________________________________________________________________________________

    public static function log($code, $severity, $message, $fileSet) 
    {
        $logFile = LogFile::openLogFile(LogManager::generatePath($fileSet));
        $logFile->addLine(self::generateLogLine($code, $severity, $message));
    }

    public static function purge($logFiles) { if(DataValidator::isValidObjectArray($logFiles, LogFile::class, 1)) array_walk($logFiles, fn($file) => $file->delete()); }
    public static function getAllLogFiles($dirPath) { return array_map( fn($filePath) => LogFile::openLogFile($filePath), glob(self::LOG_FILES_ROUTE . '/*')); }

//Internal_Use_____________________________________________________________________________________________________________________________________________________________________________

    private static function generatePath($fileSet) { return self::LOG_FILES_ROUTE . "\\" . $fileSet .  "\\" . $fileSet . date('Y_m_d') . '.log'; }

    private static function generateLogLine($code, $severity, $message) 
    {
        $severityMessage = NotificationSeverity::getMessage($severity);
        return  
             date('Y-m-d H:i:s') . " => "    
            .$severityMessage    . ": "
            .$code               . " | "
            .$message            . ";";
    }
}

