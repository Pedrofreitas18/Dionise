<?php
namespace App\Controller\Pages;

use \App\View\View;

class Page{
    private static function getHeader(){
        return View::render('template/header');
    }

    private static function getFooter(){
        return View::render('template/footer');
    }

    public static function getPage($title, $content){
        return View::render('template/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'footer' => self::getFooter(),
            'content' => $content
        ]);
    }
}