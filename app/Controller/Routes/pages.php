<?php

use \App\Controller\Pages;
use \App\Controller\Http\Response;
use \App\Model\Log\LogRegister;

define("LOG_FILE_SET", "routesLog");

$obRouter->get('/',[
    function(){
        LogRegister::newLogLine(200, 1, URL . '/', LOG_FILE_SET);
        return new Response(200, Pages\Home::getHome(1));
    }
]);

$obRouter->get('/page/{currentPage}',[
    function($currentPage){
        LogRegister::newLogLine(200, 1, URL . '/page/' . $currentPage, LOG_FILE_SET);
        return new Response(200, Pages\Home::getHome($currentPage));
    }
]);


$obRouter->get('/about',[
    function(){
        LogRegister::newLogLine(200, 1, URL . '/about', LOG_FILE_SET);
        return new Response(200, Pages\About::getAbout());
    }
]);

$obRouter->get('/Establishment/{id}',[
    function($id){
        LogRegister::newLogLine(200, 1, URL . '/Establishment/' . $id, LOG_FILE_SET);
        return new Response(200,  Pages\Establishment::getEstablishment($id));
    }
]);