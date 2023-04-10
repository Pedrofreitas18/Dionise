<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Model\Entity\Organization;

class Home extends Page{
    
    public static function getHome(){
        $obOrganization = new Organization;
        
        $content =  View::render('pages/home');

        return parent::getPage('Dionise - Home', $content);
    }
}