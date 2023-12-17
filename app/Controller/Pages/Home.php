<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Model\Entity\Establishment\Establishment;

class Home extends Page{
    
    public static function getHome($request)
    {
        $content =  View::render('pages/Home/HomePage', [
            'itens' => self::getEstablishments($request)
        ]);

        return parent::getPage('Dionise - Home', $content);
    }

    private static function getEstablishments($request)
    {
        $content = '';
        $itens = Establishment::getTodaysHighlights();

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
}