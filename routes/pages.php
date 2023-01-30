<?php
use \App\Controller\Pages;
use \App\Http\Response;


$obRouter->get('/',[
    function(){
        return new Response(200, Pages\Home::getHome());
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

$obRouter->get('/depoimento',[
    function(){
        return new Response(200, Pages\Testimony::getTestimonies());
    }
]);
