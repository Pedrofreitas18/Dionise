<?php 
require __DIR__.'/../vendor/autoload.php';

use \Http\Middleware\Queue as MiddlewareQueue;

require_once 'global.php';

MiddlewareQueue::setMap([
    'maintenance' => \Http\Middleware\Maintenance::class
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);