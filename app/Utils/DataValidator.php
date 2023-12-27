<?php
namespace App\Utils;

class DataValidator {
    public static function isValidObjectArray($array, $class, $minSize = 0, $maxSize = 'unlimited')
    {
        if(!is_array($array))                                      return false;
        if(sizeof($array) < $minSize)                              return false; 
        if($maxSize !== 'unlimited' and sizeof($array) > $maxSize) return false; 

        $contentIsOnlyDefinedObjects = array_reduce($array, fn($result, $element) => $result && is_a($element, $class), true);
        if(!$contentIsOnlyDefinedObjects) return false;
        
        return true;
    }
}