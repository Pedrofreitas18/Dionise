<?php
namespace App\Model\Enum;

class NotificationSeverity{
    private static $codesEnum  = [
        '0' => 'Debug',         //Description: Events that provide system debug, do not indicate any risk, impact or useful information on long time period.  
                                //Examples: System debug and tests. 

        '1' => 'Informational', //Description: Events that provide useful information but do not have an immediate impact on processes or services.
                                //Examples: Informational logs, notifications of normal events.
        
        '2' => 'Warning',       //Description: Events that indicate a condition to be observed but do not require immediate action.
                                //Examples: Low-level warnings, notifications of planned changes.
        
        '3' => 'Alert',         //Description: Events that indicate a condition that may require attention or investigation but is not critical.
                                //Examples: Performance alerts, notifications of significant events.
        
        '4' => 'Attention',     //Description: Events that indicate a condition requiring immediate attention but are not emergencies.
                                //Examples: Issues that need to be addressed quickly but do not cause a disruption.
        
        '5' => 'Emergency'      //Description: Events that represent a critical situation requiring an immediate response.
                                //Examples: Severe system failures, critical security situations.      
    ];

    public static function getMessage($code){   
        $message = is_string($code) 
            ? NotificationSeverity::$codesEnum[$code]
            : NotificationSeverity::$codesEnum[strval($code)];
        return is_null($message) ? 'Undefined' : $message;
    }

}