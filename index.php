<?php 

require __DIR__.'/http/Router.php';
require __DIR__.'/includes/app.php';

use \Http\Router;

$obRouter = new Router(URL);

include __DIR__.'/App/Controller/Routes/pages.php';

$obRouter->run()->sendResponse();



