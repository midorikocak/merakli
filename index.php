<?php
$startTime = microtime(true);
require_once 'Vendor/BasicDB/basicdb.php';
require 'Config/config.inc.php';
require_once 'Vendor/autoload.php';




$directoryName = basename(dirname(__FILE__));

define('LINK_PREFIX', 'http://' . $_SERVER['HTTP_HOST'] . '/' . $directoryName);
define('FILE_PREFIX', 'http://' . $_SERVER['HTTP_HOST'] . '/' . $directoryName . '/www/');
define('DIRECTORY_NAME',$directoryName);

$app = new \Midori\Cms\App($config);


$endTime = microtime(true);
$elapsed = $endTime - $startTime;
    //echo "Execution time : $elapsed seconds"; // Uncomment for debugging