<?php
namespace App\Model\Entity\File;

use \Exception;
use \DateTime;
use \App\Model\Entity\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;
use \App\Model\FileManagement\FileCRUD;

class File{
    protected $path;   

    protected function __construct($path) {
        $this->path = $path;   
    }

    public static function open($filePath, $initContent = '') {   
        Directory::open(pathinfo($filePath)['dirname']); //makes sure that directory tree exists

        $file = new File($filePath);
        if(!$file->isSet() or $file->isEmpty()) 
            $file->write($initContent == '' ? $initContent : $initContent . PHP_EOL, 'w');

        return $file;
    }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function  getPath()      { return $this->path; }
    public function  getName()      { return pathinfo($this->getPath())['filename']; }
    public function  getExtension() { return pathinfo($this->getPath())['extension']; }
    public function  getDirPath()   { return pathinfo($this->getPath())['dirname']; }

//Other________________________________________________________________________________________________________________________________________________________________
    public function isEmpty()       { return filesize($this->getPath()) == 0 ? true : false ; }
    public function isSet()         { return file_exists($this->getPath()) ? true : false; }    
    
    public function delete()        { unlink($this->getPath()); }

    public function write($content, $method){ 
        try {
            $file = fopen($this->getPath(), $method);
            fwrite($file, $content);
            fclose($file);
        }catch(Exception $e){
            //fatal error 
            //do not log this error. Loop failure possible
        }
    }
}

