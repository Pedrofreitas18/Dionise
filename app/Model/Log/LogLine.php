<?php
namespace App\Model\Log;

use \Exception;
use \App\Model\Enum\NotificationSeverity;

class LogLine{
    const HEADER = 'DateTime => Severity: Code | Message;';
    
    private $code;
    private $severity;
    private $dateTime;
    private $message;

    public function __construct($code, $severity, $dateTime, $message) {
        $this->code     = $code;
        $this->severity = $severity;
        $this->dateTime = $dateTime;
        $this->message  = $message;
    }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function getCode()             { return $this->code; }

    public function getSeverity()         { return $this->severity; }

    public function getDateTime()         { return $this->dateTime; }

    public function getMessage()          { return $this->message; }

    public function getSeverityMessage()  { return NotificationSeverity::getMessage($this->getSeverity()); }

    public static function getGetHeader() { return self::HEADER; }

//Other________________________________________________________________________________________________________________________________________________________________
    public function toString(){
        return 
              $this->getDateTime()        . ' => ' 
            . $this->getSeverityMessage() . ': '
            . $this->getCode()            . ' | '
            . $this->getMessage()         . ';'
        ;
    }
}

