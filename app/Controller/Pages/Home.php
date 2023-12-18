<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Model\Entity\Establishment\Establishment;

class Home extends Page{

    public static function getHome($currentPage)
    {

        $content =  View::render('pages/Home/HomePage', [
            'itens'   => self::getEstablishments($currentPage),
            'navPage' => self::getPageNavigator($currentPage)
        ]);

        return parent::getPage('Dionise - Home', $content);
    }

    private static function getEstablishments($currentPage)
    {
        $content = '';
        $itens = Establishment::getTodaysHighlights($currentPage);

        foreach ($itens as &$item) {
            $content .=  View::render('pages/Home/Item', [
                'id'             => $item->id,
                'name'           => $item->name,
                'description'    => $item->description,
                'introImageLink' => $item->introImageLink
            ]);
        }

        return $content;
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
                'class'  => $i == $currentPage ? "page-item active" : "page-item"
            ]);
        }

        return $content;
    }

}