<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Controller\Http\HttpCodes;

class Erro extends Page{
    
    public static function getErrorPage($code, $message){
        $content =  View::render('pages/Erro/ErroPage', [
            'code'    => $code,
            'message' => HttpCodes::getMessage($code)
        ]);
        return parent::getPage('Error '. $code, 'Default', $content);
    }
}
