<?php
namespace App\Model\Entity\Log;

use \Exception;
use \DateTime;
use \App\Model\Entity\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\FileManagement\FileCRUD;

//log file schema -> MAIN_LOG_FOLDER\FILE_SET\FILE_SETyyyy_mm_dd.log
class LogFile{
    const MAIN_LOG_FOLDER = ROOT_PATH . "\\app\\model\\Log\\files";
    const DATE_FORMAT     = 'Y_m_d';
    const FILE_EXTENSION  = "log";

    private $path;   
    private $logLines = [];

    public function __construct($path) {
        $this->path = $path;
        $this->validate();
    }

    public static function openFile($fileSet, $date)  { return new LogFile(LogFile::generatePath($fileSet, $date)); }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function  getPath()             { return $this->path; }

    private function getLogLines()         { return $this->logLines; }

    public function  getName()             { return pathinfo($this->getPath())['filename']; }

    public function  getExtension()        { return pathinfo($this->getPath())['extension']; }

    public function  getDirPath()          { return pathinfo($this->getPath())['dirname']; }

    public function  getFileSet()          { return basename($this->getDirPath()); } //FILE_SET = DirectoryName
 
    public function  getPrefix()           { return substr($this->getName(), 0, strlen($this->getFileSet())); }

    public function  getSuffix()           { return substr($this->getName(), strlen($this->getFileSet()), strlen($this->getName())); }

    public function  getDate()             { return DateTime::createFromFormat(self::DATE_FORMAT, $this->getSuffix()); }

    public function  addLogLines($logLines){ $this->logLines = array_merge($this->logLines, $logLines); }

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

//Create/Update_________________________________________________________________________________________________________________________________________________________
    public function upsert() { FileCRUD::upsertFile($this->getPath(), $this->logLinesToString(), LogLine::getGetHeader()); }

//Read_________________________________________________________________________________________________________________________________________________________________
    public static function getAllLogFiles() 
    { 
        return 
            array_merge(
                ...array_map(
                        fn($dirPath) => LogFile::getFilesFromDirectory($dirPath), 
                        LogFile::getAllLogDirectories()
                    )
                ); 
    }

    public static function getAllLogDirectories()  { return  $dirPaths = glob(self::MAIN_LOG_FOLDER . '/*', GLOB_ONLYDIR); }
    
    public static function getFilesFromDirectory($dirPath) 
    { 
        return 
            array_map(
                fn($filePath) => new LogFile($filePath), 
                array_filter(
                    glob($dirPath . '/*', GLOB_BRACE), 
                    'is_file'
                )
            ); 
    }

//Delete_______________________________________________________________________________________________________________________________________________________________
    public function delete() { unlink($this->getPath()); }

//Other________________________________________________________________________________________________________________________________________________________________
    
    public static function generatePath($fileSet, $date) { return self::MAIN_LOG_FOLDER . '\\' . $fileSet . '\\' . $fileSet . $date . '.' . self::FILE_EXTENSION; }
    
    public function validate(){
        if($this->getExtension() !== self::FILE_EXTENSION) 
            throw new InvalidArgumentException("O parâmetro é inválido1"); //must be a .log file
        if($this->getFileSet() !== $this->getPrefix()) 
            throw new InvalidArgumentException("O parâmetro é inválido2"); //file prefix must be the folder name
        if($this->getDate() == false )                 
            throw new InvalidArgumentException("O parâmetro é inválido3"); //suffix must be a valid date string
        
        return true;     
    }
}

