<?php
namespace App\Controller\Http;

use \Exception;

class HttpException extends Exception {
    private $httpCode;
    private $severity;
    //private $attribute3;

    public function __construct($message, $httpCode, $severity = 1, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->httpCode = $httpCode;
        $this->severity = $severity;
        //$this->attribute3 = $attribute3;
    }

    // Methods to get the attributes
    public function getHttpCode() {
        return $this->httpCode;
    }

    public function getSeverity() {
        return $this->severity;
    }

}