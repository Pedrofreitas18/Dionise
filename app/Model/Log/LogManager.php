<?php
namespace App\Model\Log;

use \DateTime;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\Entity\Log\LogFile;
use \App\Model\Entity\Log\LogLine;
use \App\Utils\DateTimeTool;
use \App\Utils\DataValidator;

//singleton
class LogManager {
    private static $instance;
    private $logCollection;
    private $date;

    private function __construct() {
        $this->clearCache();
        $this->updateDate();
    }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________

    //always use getInstance
    public static function getInstance() {
        if(!self::$instance) self::$instance = new self();
        if( self::$instance->getDate() < DateTimeTool::getTodaysHourZero()) self::refresh();

        return self::$instance;
    }

    private function getDate()                   { return $this->date; }
    private function getLogFiles($lambda = true) { return array_filter($this->logCollection, $lambda); }

//Internal_Use________________________________________________________________________________________________________________________________________________________________________________
    private function clearCache()     { $this->logCollection = []; }
    private function updateDate()     { $this->date = DateTimeTool::getTodaysHourZero(); }

    private static function refresh() { 
        self::$instance->updateLogFiles();
        self::$instance->clearCache();
        self::$instance->updateDate();
    }

    private function openLogFile($fileSet) {
        $filtredArray = $this->getLogFiles(fn($logFile) => $logFile->getFileSet() == $fileSet);
        if(count($filtredArray) == 1) return $filtredArray[0];
        
        $logFile = LogFile::open($fileSet, $this->getDate()->format('Y_m_d'));
        array_push($this->logCollection, $logFile);
        return $logFile;
    }

//Service______________________________________________________________________________________________________________________________________________________________________________________
    public function updateLogFiles() { array_walk($this->logCollection, fn($logFile) => $logFile->update()); }

    public static function log($code, $severity, $message, $fileSet) {
        $logFile = self::getInstance()->openLogFile($fileSet); 
        $logFile->addLogLine(new LogLine($code, $severity, date('Y-m-d H:i:s'), $message));
    }

    public static function purge($logFiles) { 
        if(DataValidator::isValidObjectArray($logFiles, LogFile::class, 1))
            array_walk($logFiles, fn($file) => $file->delete()); 
    }

}

