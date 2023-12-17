<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Model\Entity\Organization;

class About extends Page{
    
    public static function getAbout(){
        $obOrganization = new Organization;
        
        $content =  View::render('pages/About/AboutPage', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description
        ]);

        return parent::getPage('Dionise - Sobre', $content);
    }
}
