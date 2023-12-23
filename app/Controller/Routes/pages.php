<?php

use \App\Controller\Pages;
use \App\Controller\Http\Response;
use \App\Model\Log\LogManager;
use \App\Model\Log\LogFile;


define("LOG_FILE_SET", "routesLog");

$obRouter->get('/',[
    function(){
        //LogManager::log(200, 1, URL . '/', LOG_FILE_SET);
        return new Response(200, Pages\Home::getHomePage(1));
    }
]);

$obRouter->get('/page/{currentPage}',[
    function($currentPage){
        //LogManager::log(200, 1, URL . '/page/' . $currentPage, LOG_FILE_SET);
        return new Response(200, Pages\Home::getHomePage($currentPage));
    }
]);


$obRouter->get('/about',[
    function(){
        //LogManager::log(200, 1, URL . '/about', LOG_FILE_SET);
        return new Response(200, Pages\About::getAbout());
    }
]);

$obRouter->get('/Establishment/{id}',[
    function($id){
        //LogManager::log(200, 1, URL . '/Establishment/' . $id, LOG_FILE_SET);
        return new Response(200,  Pages\Establishment::getEstablishmentPage($id));
    }
]);

$obRouter->get('/error',[
    function(){
        //for exceptions only!!
        return new Response(500, Pages\Error::getHttpErrorPage(500));
    }
]);