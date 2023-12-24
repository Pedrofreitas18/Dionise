<?php 

require __DIR__.'/includes/app.php';

use App\Controller\Http\Router;

$obRouter = new Router(URL);

include __DIR__.'/App/Controller/Routes/pages.php';
include __DIR__.'/App/Controller/CronTasks/DailyTasks.php';

$obRouter->run()->sendResponse();



