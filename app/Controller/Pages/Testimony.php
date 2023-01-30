<?php
namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Testimony extends Page{
    
    public static function getTestimonies(){
        
        $content =  View::render('pages/testimonies', [

        ]);

        return parent::getPage('Dionise - Depoimentos', $content);
    }
}