<?php 

require __DIR__.'/../vendor/autoload.php';

use \App\Utils\View;
use \App\Model\DBConnection\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

require_once 'global.php';
define('URL', getenv('URL'));

View::init([
    'URL' => URL
]);

Database::config(
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD'),
    getenv('DB_HOST'),
    getenv('DB_NAME')
);

MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);
