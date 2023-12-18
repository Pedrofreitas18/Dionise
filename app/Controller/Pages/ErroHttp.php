<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Controller\Http\HttpCodes;

class ErroHttp extends Page{
    
    public static function getErroHttp($code){
        $content =  View::render('pages/Erro/ErroPage', [
            'code'    => $code,
            'message' => HttpCodes::getMessage($code)
        ]);
        return parent::getPage('Error '. $code, 'Default', $content);
    }
}
