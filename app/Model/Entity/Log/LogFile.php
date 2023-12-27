<?php
namespace App\Model\Entity\Log;

use \Exception;
use \DateTime;
use \App\Model\Entity\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\FileManagement\FileCRUD;
use \App\Model\Entity\File\File;
use \App\Utils\DataValidator;

//log file schema -> MAIN_LOG_FOLDER\FILE_SET\FILE_SETyyyy_mm_dd.log
class LogFile extends File{
    const MAIN_LOG_FOLDER      = ROOT_PATH . "\\app\\model\\Log\\files";
    const DEFAULT_LOG_FILE_SET = 'defaultLog';
    const DATE_FORMAT          = 'Y_m_d';
    const FILE_EXTENSION       = "log"; 

    private $logLines = [];

    private function __construct($path) {
        parent::__construct($path);
       
        if( 
            !$this->isGeneratedDateValid() or
            !$this->isExtensionValid()     or
            !$this->isFileSetValid()        
        )    $this->path = LogFile::generatePath(self::DEFAULT_LOG_FILE_SET, date('Y_m_d'));
        
    }

    public static function open($fileSet, $date = null) { 
        $filePath = LogFile::generatePath($fileSet, $date == null ? date('Y_m_d') : $date);
        parent::open($filePath, LogLine::getGetHeader());
        return new LogFile($filePath); 
    }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    private function getLogLines()          { return $this->logLines; }
    public function  getFileSet()           { return basename($this->getDirPath()); } //FILE_SET = DirectoryName
    public function  getPrefix()            { return substr($this->getName(), 0, strlen($this->getFileSet())); }
    public function  getSuffix()            { return substr($this->getName(), strlen($this->getFileSet()), strlen($this->getName())); }
    public function  getDate()              { return DateTime::createFromFormat(self::DATE_FORMAT, $this->getSuffix()); }

//Create/Update_________________________________________________________________________________________________________________________________________________________
    public function update() { 
        parent::write($this->logLinesToString(), 'a'); 
        $this->logLines = [];
    }

    public function addLogLine($logLine) { array_push($this->logLines, $logLine); }

//Other________________________________________________________________________________________________________________________________________________________________

    public function  logLinesToString()
    { 
        return 
            implode(
                '', 
                array_map(
                    fn($logLine) => $logLine->toString() . PHP_EOL, 
                    $this->getLogLines()
                )
            ); 
    }

    public static function fileToLogFile($fileArray) {      
        if(!DataValidator::isValidObjectArray($fileArray, parent::class))
            echo 'erro';
        
        return 
            array_map(
                fn($file) =>  new self($file->getPath()),
                $fileArray,
            );
    }

    public static function generatePath($fileSet, $date) { return self::MAIN_LOG_FOLDER . '\\' . $fileSet . '\\' . $fileSet . $date . '.' . self::FILE_EXTENSION; }

    public function isExtensionValid()     { return $this->getExtension() == self::FILE_EXTENSION ? true  : false; }
    public function isFileSetValid()       { return $this->getFileSet()   == $this->getPrefix()   ? true  : false; }
    public function isGeneratedDateValid() { return $this->getDate()      == false                ? false : true ; }
    //public function isInMainLogFolder()    { return self::MAIN_LOG_FOLDER == pathinfo($this->getDirPath())['dirname']; }
}

