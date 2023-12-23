<?php
namespace App\Controller\Pages;

use \App\View\View;

class Page{
    public static function getPage($title, $content, $template)
    {
        return View::render('templates/'.$template.'/page', [
            'title'   => $title,
            'header'  => self::getHeader($template),
            'footer'  => self::getFooter($template),
            'content' => $content
        ]);
    }

    private static function getHeader($template) { return View::render('templates/'.$template.'/header'); }

    private static function getFooter($template) { return View::render('templates/'.$template.'/footer'); }
}