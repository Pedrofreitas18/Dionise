<?php
namespace App\Model\Entity\Log;

use \Exception;
use \DateTime;
use \App\Model\Entity\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\FileManagement\FileCRUD;
use \App\Model\Entity\File\Directory;
use \App\Utils\DataValidator;

class LogMainDirectory extends Directory{

    private function __construct($path)  { parent::__construct($path); }

    public static function open($path)  { 
        parent::open($path);
        return new self($path); 
    } 

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________    
    public function getFiles($filter = null)       { return []; }  //do not have files
    public function getDirectories($filter = null) { 
        return 
            array_map(
                $filter,
                LogDirectory::directoryToLogDirectory(parent::getDirectories())
            );
    } 
    
    public function getAllFiles($filter = null) { 
        $logFiles = 
            array_merge(
                ...array_map(
                    fn($logDir) => $logDir->getFiles(),
                    $this->getDirectories()
                ) 
            );
        
        return array_filter($logFiles, $filter);
    }

//Other________________________________________________________________________________________________________________________________________________________________
}
