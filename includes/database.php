<?php 

require __DIR__.'/../vendor/autoload.php';

use \App\Model\DBConnection\Database;

require_once 'global.php';

Database::config(
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD'),
    getenv('DB_HOST'),
    getenv('DB_NAME')
);
