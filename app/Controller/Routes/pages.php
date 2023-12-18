<?php
require __DIR__.'/../../../http/Response.php';

use \App\Controller\Pages;
use \Http\Response;

/*
$obRouter->get('/',[
    'middlewares' => [
        'maintenance'
    ],
    function(){
        return new Response(200, Pages\Home::getHome());
    }
]);
*/


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

$obRouter->get('/pagina/{idPagina}',[
    function($idPagina){
        return new Response(200, "Página " . $idPagina);
    }
]);

$obRouter->get('/Establishment/{id}',[
    function($id){
        return new Response(200,  Pages\Establishment::getEstablishment($id));
    }
]);

$obRouter->get('/depoimento',[
    function($request){
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }
]);
 

$obRouter->post('/depoimento',[
    function($request){
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);