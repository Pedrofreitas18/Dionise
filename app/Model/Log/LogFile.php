<?php
namespace App\Model\Log;

use \Exception;

class LogFile{ 
    const LOG_FILE_HEADER = 'DateTime => Severity: Code | Message;';
    private $filePath;

    private function __construct($filePath) { $this->filePath = $filePath; }

    public static function openLogFile($filePath)  
    {
        $logFile = new LogFile($filePath);
        if(file_exists($filePath)) return $logFile;

        $dirPath = dirname($filePath);
        if(!file_exists($dirPath)) mkdir($dirPath, 0777, true);
        
        $logFile->addLine(self::LOG_FILE_HEADER);
        return $logFile;
    }

    public function delete() { unlink($this->getPath()); }    
    
//gets_____________________________________________________________________________________________________________________________________________________________________________
    public function getPath() { return $this->filePath; } 
    //public function getFileName() { return basename($this->getPath()); }
    //public function getDate() { return true; }  
    //public function getDirPath()  { return dirname($this->getPath()); }    
    //public function getDirName()  { return basename($this->getDirPath()); }

//others_____________________________________________________________________________________________________________________________________________________________________________
    public function addLine($content){ 
        try {
            $file = fopen($this->getPath(), 'a');
            fwrite($file, $content . PHP_EOL);
            fclose($file);
        }catch(Exception $e){
            //fatal error 
            //do not log this error. Loop failure possible
        }
    }

}
