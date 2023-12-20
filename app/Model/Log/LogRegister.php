<?php
namespace App\Model\Log;

use \App\Model\Enum\NotificationSeverity;

class LogRegister{

    public static function newLogLine($code, $severity, $message, $fileSet){   
        $content = '';
        
        $dirPath = __DIR__ ."\\files\\". $fileSet;
        if (!is_dir($dirPath)) mkdir($dirPath, 0777, false);

        $filePath = $dirPath .'\\'. $fileSet . date('Y_m_d') .'.log';
        try
        {
            if (!file_exists($filePath)) $content .= 'DateTime => Severity: Code | Message;' . PHP_EOL;
            $file = fopen($filePath, 'a');
        
            $content .= 
                date('Y-m-d H:i:s')                      . " => "    
                .NotificationSeverity::getMessage($severity) . ": "
                .$code                                   . " | "
                .$message                                . ";"
                .PHP_EOL;

            fwrite($file, $content);
            fclose($file);

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

}

