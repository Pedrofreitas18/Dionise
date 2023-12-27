<?php
require 'vendor/autoload.php';

use Cron\CronExpression;
use \App\Model\Log\LogManager;
use \App\Model\Entity\Log\LogFile;
use \App\Model\Entity\File\Directory;
use \App\Model\Entity\Log\LogDirectory;
use \App\Model\Entity\Log\LogMainDirectory;

$lateNightRun = CronExpression::factory('* 2 * * *');
$periodicRun  = CronExpression::factory('*/5 * * * *');

if ($lateNightRun->isDue()) {
    $mainLogDirectory = LogMainDirectory::open('C:\xampp\htdocs\Dionise\app\Model\Log\files');
    $purgeFiles       = $mainLogDirectory->getAllFiles(fn($logFile) => $logFile->getDate()->diff(new DateTime())->days > 7); 

    LogManager::purge($purgeFiles);
}

if ($periodicRun->isDue()) { LogManager::getInstance()->updateLogFiles(); }