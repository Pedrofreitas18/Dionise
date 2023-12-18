<?php

use \App\Controller\Pages;
use \App\Controller\Http\Response;

$obRouter->get('/',[
    function(){
        return new Response(200, Pages\Home::getHome(1));
    }
]);

$obRouter->get('/page/{currentPage}',[
    function($currentPage){
        return new Response(200, Pages\Home::getHome($currentPage));
    }
]);


$obRouter->get('/about',[
    function(){
        return new Response(200, Pages\About::getAbout());
    }
]);

$obRouter->get('/Establishment/{id}',[
    function($id){
        return new Response(200,  Pages\Establishment::getEstablishment($id));
    }
]);

$obRouter->get('/404',[
    function(){
        return new Response(200,  Pages\ErroHttp::getErroHttp(404));
    }
]);

$obRouter->get('/405',[
    function(){
        return new Response(200,  Pages\ErroHttp::getErroHttp(405));
    }
]);