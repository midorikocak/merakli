<?php
    require 'Vendor/autoload.php';
    require 'Config/config.inc.php';
    require 'Lib/App.php';
    
    
    $app = new \Midori\Cms\App();
    $app->connect($config['db']['host'],$config['db']['username'],$config['db']['password'],$config['db']['dbname']);
    $request = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']);
    $data = $_POST;
    echo $app->calculate($request,$data);
?>