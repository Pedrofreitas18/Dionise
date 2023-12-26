<?php
namespace App\Model\Entity\File;

use \Exception;
use \DateTime;
use \App\Model\Entity\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\FileManagement\FileCRUD;

class Directory{
    private $path;   
    private $files          = [];
    private $subDirectories = [];

    public function __construct($path)  { $this->path = $path; }

    public static function open($path)  { 
        $directory = new Directory($path);

        if($directory->isSet()) {
            $directory->loadFiles();
            $directory->loadSubDirectories();
        } else 
        { $directory->create(); }

        return $directory; 
    } 

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function getPath()                         { return $this->path; }
    public function getName()                         { return basename(rtrim($this->getPath(), '/\\')); }
    public function getFiles($lambda = true)          { return array_filter($this->files, $lambda); }
    public function getSubDirectories($lambda = true) { return array_filter($this->subDirectories, $lambda); }


//Other________________________________________________________________________________________________________________________________________________________________
    public function isSet()  { return file_exists($this->getPath()) ? true : false; }    
    public function create() { mkdir($this->getPath(), 0777, true); }  

    private function loadSubDirectories()  { 
        $this->subDirectories =  
            array_map(
                fn($dirPath) => self::open($dirPath), 
                glob($this->getPath() . '/*', GLOB_ONLYDIR)
            ); 
    }

    private function loadFiles() {
        $this->files =  
            array_map(
                fn($filePath) => File::open($filePath), 
                array_filter(glob($this->getPath() . '/*', GLOB_NOSORT), 'is_file')
            ); 
    }

}
