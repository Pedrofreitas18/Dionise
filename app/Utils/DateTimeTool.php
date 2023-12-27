<?php
namespace App\Utils;

use \DateTime;

class DateTimeTool {

    public static function getNow() { return new DateTime('today'); }
    
    public static function getTodaysHourZero()
    {
        $today = self::getNow();
        $today->setTime(0, 0, 0);
        return $today;
    }
    
}
