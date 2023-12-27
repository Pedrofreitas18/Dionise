<?php
namespace App\Model\Entity\Log;

use \Exception;
use \DateTime;
use \App\Model\Entity\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\FileManagement\FileCRUD;
use \App\Model\Entity\File\Directory;
use \App\Utils\DataValidator;

class LogDirectory extends Directory{

    private function __construct($path)  { parent::__construct($path); }

    public static function open($path)  { 
        parent::open($path);
        return new LogDirectory($path); 
    } 

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function getDirectories($filter = null) {  return []; }                        //do not have sub directories
    public function getAllFiles($filter = null)    {  return $this->getFiles($filter); }  //do not have files in sub folders

    public function getFiles($filter = null) { 
        
        $files = parent::getFiles(fn($file) => $file->getExtension() == 'log');
        $files = LogFile::fileToLogFile($files);

        return array_filter($files, $filter);
    }

//Other________________________________________________________________________________________________________________________________________________________________
    public static function directoryToLogDirectory($directoryArray) { 
        if(!DataValidator::isValidObjectArray($directoryArray, parent::class))
            echo 'erro';
        
        return 
            array_map(
                fn($dir) =>  new self($dir->getPath()),
                $directoryArray,
            );
    }
}
