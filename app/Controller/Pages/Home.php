<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Model\Entity\Establishment\Establishment;
use \App\Utils\DataValidator;
use \App\Controller\Exception\HttpException;
use \App\Model\Log\LogManager;

class Home extends Page{
    const LOG_FILE_SET = 'pageControllerLog';
    
    public static function getHomePage($id) { 
        try {
            return 
                parent::getPage(
                    'Dionise - Home', 
                     self::getHome($id), 
                    'Default'
                );
        }catch(HttpException $e){
            LogManager::log($e->getHttpCode(), $e->getSeverity(), $e->getMessage(), self::LOG_FILE_SET);
            return Error::getHttpErrorPage($e->getHttpCode());
        }
    }

    private static function getHome($currentPage)
    {
        return View::render('pages/Home/HomePage', [
            'itens'   => self::getEstablishments($currentPage),
            'navPage' => self::getPageNavigator($currentPage)
        ]);
    }

    private static function getEstablishments($currentPage)
    {
        $establishmentArray = Establishment::getTodaysHighlights($currentPage);
        
        if(!DataValidator::isValidObjectArray($establishmentArray, Establishment::class, 0)) 
            throw new HttpException(__METHOD__ . ' fail -> Invalid Argument: ' . print_r($establishmentArray, true), 500, 4);
        if(sizeof($establishmentArray) == 0)                                                          
            throw new HttpException(__METHOD__ . ' fail -> No establishments founds ID = ' . $currentPage, 404, 1);
                
        return implode('', array_map(
            fn($establishment) => View::render('pages/Home/Item', [
                'id'             => $establishment->getId(),
                'name'           => $establishment->getName(),
                'description'    => $establishment->getDescription(),
                'introImageLink' => $establishment->getIntroImageLink()
            ]),
            $establishmentArray
        )); 
    }

    private static function getPageNavigator($currentPage)
    {        
        $sizeMax = 5; //size of navbar
        $final = (int) $currentPage + ($sizeMax - ($currentPage % $sizeMax));
        $init = $final +1 -$sizeMax;

        //if there is no records enought to full the size, limit must be the final
        $numberOfEstablishments = Establishment::getNumberOfEstablishments();
        $limit = ceil($numberOfEstablishments/12);
        if($final > $limit) $final = $limit;

        $content =  View::render('pages/Home/NavPage', [
            'itens'                 => self::getPageNavigatorItens($init, $final, $currentPage),
            
            'next-button-class'     => $currentPage == $final ? "page-item disabled" : "page-item",
            'next-link'             => $currentPage == $final ? "#" : URL."/page/".$currentPage +1,

            'previous-button-class' => $currentPage == 1 ? "page-item disabled" : "page-item",
            'previous-link'         => $currentPage == 1 ? "#" : URL."/page/".$currentPage -1
        ]);

        return $content;
    }

    private static function getPageNavigatorItens($init, $final, $currentPage)
    {
        $content = '';
        for ($i = $init; $i <= $final; $i++) {
            $content .=  View::render('pages/Home/NavPageItem', [
                'number' => $i,
                'link'   => $i == $currentPage ? "#" : URL.'/page/'.$i,
                'class'  => $i == $currentPage ? "page-item active" : "page-item"
            ]);
        }

        return $content;
    }
}