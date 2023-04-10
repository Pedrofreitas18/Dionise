<?php 

require __DIR__.'/../vendor/autoload.php';

use \App\View\View;

require_once 'global.php';
define('URL', getenv('URL'));

View::init([
    'URL' => URL
]);