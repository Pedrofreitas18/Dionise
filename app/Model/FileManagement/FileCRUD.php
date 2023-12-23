<?php
namespace App\Model\FileManagement;

use \Exception;
use \DateTime;
use \App\Model\Log\LogLine;
use \App\Model\Enum\NotificationSeverity;

class FileCRUD{
//Create/Update_______________________________________________________________________________________________________________________________________________________________
    public static function createDirectoryHierarchy($dirPath){  
        if (!file_exists($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) throw new Exception("Ocorreu um problema");
        }
    }

    public static function createFile($path, $initText = ''){      
        if(!file_exists($path) or filesize($path) == 0){
            $dirPath = pathinfo($path, PATHINFO_DIRNAME);
            if (!file_exists($dirPath)) FileCRUD::createDirectoryHierarchy($dirPath);
            FileCRUD::write($path, $initText, 'w');
        }
    }

    public static function upsertFile($path, $content, $initText = ''){ 
        if(!file_exists($path) or filesize($path) == 0) self::createFile($path, $initText);
        FileCRUD::write($path, $content, 'a');
    }

//Read_________________________________________________________________________________________________________________________________________________________________
    public static function getFilesByDirectoryList($dirPaths) 
    { 
        return 
            array_merge(
                ...array_map(
                    fn($dirPath) => FileCRUD::getFilesByDirectory($dirPath), 
                    $dirPaths
                )
            ); 
    }

    public static function getFilesByDirectory($dirPath)
    { 
        return 
            array_map(
                fn($filePath) =>  new LogFile($filePath), 
                glob($dirPath . '/*')
            ); 
    }

//Delete_______________________________________________________________________________________________________________________________________________________________
    public static function delete($path) { unlink($path); }

//Other________________________________________________________________________________________________________________________________________________________________

    private static function write($path, $content, $param){ 
        try {
            $file = fopen($path, $param);
            fwrite($file, $content);
            fclose($file);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

}
