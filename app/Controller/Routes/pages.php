<?php

use \App\Controller\Pages;
use \App\Controller\Http\Response;
use \App\Model\Log\LogManager;
use \App\Model\Log\LogFile;


define("LOG_FILE_SET", "routesLog");

$obRouter->get('/',[
    function(){
        $content = Pages\Home::getHomePage(1);
        LogManager::log(200, 1, URL . '/', LOG_FILE_SET);
        return new Response(200, $content);
    }
]);

$obRouter->get('/page/{currentPage}',[
    function($currentPage){
        $content = Pages\Home::getHomePage($currentPage);
        LogManager::log(200, 1, URL . '/page/' . $currentPage, LOG_FILE_SET);
        return new Response(200, $content);
    }
]);


$obRouter->get('/about',[
    function(){
        $content = Pages\About::getAbout();
        LogManager::log(200, 1, URL . '/about', LOG_FILE_SET);
        return new Response(200, $content);
    }
]);

$obRouter->get('/Establishment/{id}',[
    function($id){
        $content = Pages\Establishment::getEstablishmentPage($id);
        LogManager::log(200, 1, URL . '/Establishment/' . $id, LOG_FILE_SET);
        return new Response(200, $content);
    }
]);

$obRouter->get('/error',[
    function(){
        //for exceptions only!!
        $content = Pages\Error::getHttpErrorPage(500);
        return new Response(500, $content);
    }
]);