<?php
namespace App\Model\Log;

use \Exception;
use \DateTime;
use \App\Model\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\FileManagement\FileCRUD;

class LogFile{
    const MAIN_LOG_FOLDER = __DIR__ ."\\files";
    const DATE_FORMAT     = 'Y_m_d';
    const FILE_EXTENSION  = "log";

    private $path;   
    private $logLines = [];

    public function __construct($path) {
        $this->path = $path;
        $this->validate();
    }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function  getPath()             { return $this->path; }

    private function getLogLines()         { return $this->logLines; }

    public function  getName()             { return pathinfo($this->getPath())['filename']; }

    public function  getExtension()        { return pathinfo($this->getPath())['extension']; }

    public function  getDirPath()          { return pathinfo($this->getPath())['dirname']; }

    public function  getDirName()          { return basename($this->getDirPath()); }
 
    public function  getPrefix()           { return substr($this->getName(), 0, strlen($this->getDirName())); }

    public function  getSuffix()           { return substr($this->getName(), strlen($this->getDirName()), strlen($this->getName())); }

    public function  getDate()             { return DateTime::createFromFormat(self::DATE_FORMAT, $this->getSuffix()); }

    public function  addLogLines($logLines){ $this->logLines = array_merge($this->logLines, $logLines); }

    public function  logLinesToString()    { return implode('', array_map(fn($logLine) => $logLine->toString() . PHP_EOL, $this->getLogLines())); }

//Create/Update_________________________________________________________________________________________________________________________________________________________
    public function upsert(){ 
        FileCRUD::upsertFile($this->getPath(), $this->logLinesToString(), LogLine::getGetHeader());
    }

//Read_________________________________________________________________________________________________________________________________________________________________
    public static function getAllLogFiles(){
        $dirPaths = glob(self::MAIN_LOG_FOLDER . '/*', GLOB_ONLYDIR);
        return array_merge(...array_map(fn($dirPath) => LogFile::getFiles($dirPath), $dirPaths));  //... unpackege de result arrays
    }

    public static function getFiles($dirPath) { return array_map(fn($filePath) =>  new LogFile($filePath), glob($dirPath . '/*')); }

//Delete_______________________________________________________________________________________________________________________________________________________________
    public function delete(){ unlink($this->getPath()); }

//Other________________________________________________________________________________________________________________________________________________________________
    
    public static function generatePath($fileSet, $date) { return self::MAIN_LOG_FOLDER . '\\' . $fileSet . '\\' . $fileSet . $date . '.' . self::FILE_EXTENSION; }
    
    public function validate(){
        if($this->getExtension() !== self::FILE_EXTENSION) 
            throw new InvalidArgumentException("O parâmetro é inválido1"); //must be a .log file
        if($this->getDirName() !== $this->getPrefix()) 
            throw new InvalidArgumentException("O parâmetro é inválido2"); //file prefix must be the folder name
        if($this->getDate() == false )                 
            throw new InvalidArgumentException("O parâmetro é inválido3"); //suffix must be a valid date string
        
        return true;     
    }
}

