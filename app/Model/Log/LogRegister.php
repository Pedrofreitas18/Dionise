<?php
namespace App\Model\Log;

use \App\Model\Code\LogType;

class LogRegister{

    public static function newLogLine($code, $type, $message, $fileSet){   
        $content = '';
        
        $dirPath = __DIR__ ."\\files\\". $fileSet;
        if (!is_dir($dirPath)) mkdir($dirPath, 0777, false);

        $filePath = $dirPath .'\\'. $fileSet . date('Y_m_d') .'.log';
        try
        {
            if (!file_exists($filePath)) $content .= 'DateTime => Type: HttpCode | Message;' . PHP_EOL;
            $file = fopen($filePath, 'a');
        
            $content .= 
                date('Y-m-d H:i:s')         . " => "    
                .LogType::getMessage($type) . ": "
                .$code                      . " | "
                .$message                   . ";"
                .PHP_EOL;

            fwrite($file, $content);
            fclose($file);

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

}

