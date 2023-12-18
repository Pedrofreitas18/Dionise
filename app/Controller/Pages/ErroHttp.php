<?php
namespace App\Controller\Pages;

use \App\View\View;

class ErroHttp extends Page{
    
    public static function getErroHttp($code){
        $message = 'batata';

        $content =  View::render('pages/Erro/ErroPage', [
            'code'    => $code,
            'message' => $message
        ]);
        return parent::getPage('Erro '. $code, 'Default', $content);
    }
}
