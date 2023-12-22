<?php

use \App\Controller\Pages;
use \App\Controller\Http\Response;
use \App\Model\Log\LogManager;
use \App\Model\Log\LogFile;


define("LOG_FILE_SET", "routesLog");

$obRouter->get('/',[
    function(){
        LogManager::purge( 
            fn($logFile) => $logFile->getDate()->diff(new DateTime())->days >= 5,
            LogFile::getAllLogFiles()
        );

        LogManager::log(200, 1, URL . '/', LOG_FILE_SET);
        return new Response(200, Pages\Home::getHome(1));
    }
]);

$obRouter->get('/page/{currentPage}',[
    function($currentPage){
        LogManager::log(200, 1, URL . '/page/' . $currentPage, LOG_FILE_SET);
        return new Response(200, Pages\Home::getHome($currentPage));
    }
]);


$obRouter->get('/about',[
    function(){
        LogManager::log(200, 1, URL . '/about', LOG_FILE_SET);
        return new Response(200, Pages\About::getAbout());
    }
]);

$obRouter->get('/Establishment/{id}',[
    function($id){
        LogManager::log(200, 1, URL . '/Establishment/' . $id, LOG_FILE_SET);
        return new Response(200,  Pages\Establishment::getEstablishment($id));
    }
]);