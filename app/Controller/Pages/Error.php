<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Model\Enum\HttpCode;

class Error extends Page{
    
    public static function getHttpErrorPage($code)
    {
        $content =  View::render('pages/Error/ErrorPage', [
            'code'    => $code,
            'message' => HttpCode::getMessage($code)
        ]);
        return parent::getPage('Error '. $code, 'Default', $content);
    }
}
