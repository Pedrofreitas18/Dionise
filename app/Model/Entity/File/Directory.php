<?php
namespace App\Model\Entity\File;

use \Exception;
use \DateTime;
use \App\Model\Entity\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\FileManagement\FileCRUD;

class Directory{
    protected $path;   

    protected function __construct($path)  { $this->path = $path; }

    public static function open($path)  { 
        $directory = new Directory($path);
        if(!$directory->isSet()) $directory->create(); 
        return $directory; 
    } 

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function getPath() { return $this->path; }
    public function getName() { return basename(rtrim($this->getPath(), '/\\')); }

    public function getFiles($filter = null) { 
        return 
            array_filter(
                array_map(
                    fn($filePath) => File::open($filePath), 
                    array_filter(glob($this->getPath() . '/*', GLOB_NOSORT), 'is_file')
                ), 
                $filter
            );
    }

    public function getDirectories($filter = null) { 
        return 
            array_filter(
                array_map(
                    fn($dirPath) => self::open($dirPath), 
                    glob($this->getPath() . '/*', GLOB_ONLYDIR)
                ), 
                $filter
            );
    }

    public function getAllFiles($filter = null) {  //include sub folder files 
        return    
            array_merge(
                $this->getFiles($filter),
                ...array_map(
                    fn($dir) => $dir->getAllFiles($filter), 
                    $this->getDirectories()
                )
            );
    }

//Other________________________________________________________________________________________________________________________________________________________________
    public function isSet()  { return file_exists($this->getPath()) ? true : false; }    
    public function create() { mkdir($this->getPath(), 0777, true); }  
}
