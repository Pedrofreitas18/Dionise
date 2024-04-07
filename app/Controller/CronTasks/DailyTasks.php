<?php
require 'vendor/autoload.php';

use Cron\CronExpression;
use \App\Model\Log\LogManager;
use \App\Model\Log\LogFile;

$lateNightRun = CronExpression::factory('* 2 * * *');
$periodicRun  = CronExpression::factory('*/5 * * * *');

if ($lateNightRun->isDue()) {
    //$mainLogDirectory = LogMainDirectory::open('C:\xampp\htdocs\Dionise\app\Model\Log\files');
    //$purgeFiles       = $mainLogDirectory->getAllFiles(fn($logFile) => $logFile->getDate()->diff(new DateTime())->days > 7); 

    //LogManager::purge($purgeFiles);
}

