<?php
namespace App\Controller\Http;

use \App\Model\Log\LogManager;

class Response{

    private $httpCode = 200;
    private $headers = [];
    private $contentType = 'text/html';
    private $content;
    
    public function __construct($httpCode, $content, $contentType = 'text/html'){
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);  
    }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function getHttpCode() { return $this->httpCode; }

    public function setContentType($contentType){
        $this->contentType = $contentType;
        $this->addHeaders('Content-Type', $contentType);
    }
    public function addHeaders($key, $value) { $this->headers[$key] = $value; }

//Other________________________________________________________________________________________________________________________________________________________________
    public function sendHeaders(){
        http_response_code($this->getHttpCode());
        foreach($this->headers as $key=>$value){
            header($key. ': ' . $value);
        }
    }

    public function sendResponse(){
        $this->sendHeaders();
        switch ($this->contentType){
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}