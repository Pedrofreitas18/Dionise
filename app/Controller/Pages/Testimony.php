<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Model\Entity\Organization;
use \App\Model\Entity\Testimony as EntityTestimony;

class Testimony extends Page{
    
    public static function getTestimonies($request){
        $content =  View::render('pages/Testimony/testimonies', [
            'itens' => self::getTestimonyItens($request)
        ]);

        return parent::getPage('Dionise - Depoimentos', $content);
    }

    public static function insertTestimony($request)
    {
        $postVars = $request->getPostVars();
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();
        return self::getTestimonies($request);
    }

    private static function getTestimonyItens($request){
        $content = '';
        $itens = EntityTestimony::getTestimonies();

        foreach ($itens as &$item) {
            $content .=  View::render('pages/Testimony/item', [
                'nome'     => $item->nome,
                'mensagem' => $item->mensagem,
                'data'     => date('d/m/Y H:i:s', strtotime($item->data))
            ]);
        }

        return $content;
    }
}