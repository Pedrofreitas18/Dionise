<?php
require 'vendor/autoload.php';

use Cron\CronExpression;
use \App\Model\Log\LogManager;
use \App\Model\Entity\Log\LogFile;

$cronExpression = CronExpression::factory('* 2 * * *');

if ($cronExpression->isDue()) {
    //LogManager::purge( 
    //    fn($logFile) => $logFile->getDate()->diff(new DateTime())->days >= 15,
    //    LogFile::getAllLogFiles()
    //);
}