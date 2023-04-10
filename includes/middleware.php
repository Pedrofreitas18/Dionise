<?php 
require __DIR__.'/../vendor/autoload.php';

use \App\Http\Middleware\Queue as MiddlewareQueue;

require_once 'global.php';

MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);