<?php 
require __DIR__.'/vendor/autoload.php';

use \App\Http\Router;
use \App\Http\Response;
use \App\Utils\View;

require_once 'global.php';
define('URL', getenv('URL'));

View::init([
    'URL' => URL
]);

$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';

$obRouter->run()->sendResponse();



