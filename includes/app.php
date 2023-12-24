<?php 

require __DIR__.'/../vendor/autoload.php';

use \App\View\View;
use \App\Model\DBConnection\Database;

require_once 'global.php';
define('URL', getenv('URL'));
define('ROOT_PATH', getenv('ROOT_PATH'));

View::init([
    'URL' => URL
]);

Database::config(
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD'),
    getenv('DB_HOST'),
    getenv('DB_NAME')
);