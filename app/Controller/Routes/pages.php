<?php

use \App\Controller\Pages;
use \App\Controller\Http\Response;
use \App\Model\Log\LogRegister;

$obRouter->get('/',[
    function(){
        LogRegister::newLogLine(200, 1, URL . '/', 'routesLog');
        return new Response(200, Pages\Home::getHome(1));
    }
]);

$obRouter->get('/page/{currentPage}',[
    function($currentPage){
        LogRegister::newLogLine(200, 1, URL . '/page/' . $currentPage, 'routesLog');
        return new Response(200, Pages\Home::getHome($currentPage));
    }
]);


$obRouter->get('/about',[
    function(){
        LogRegister::newLogLine(200, 1, URL . '/about', 'routesLog');
        return new Response(200, Pages\About::getAbout());
    }
]);

$obRouter->get('/Establishment/{id}',[
    function($id){
        LogRegister::newLogLine(200, 1, URL . '/Establishment/' . $id, 'routesLog');
        return new Response(200,  Pages\Establishment::getEstablishment($id));
    }
]);