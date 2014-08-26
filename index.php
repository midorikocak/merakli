<?php
    require 'Vendor/autoload.php';
    require 'Config/config.inc.php';
    require 'Lib/App.php';
    
    
    $app = new \Midori\Cms\App();
    $app->connect($config['db']['host'],$config['db']['username'],$config['db']['password'],$config['db']['dbname']);
    $request = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']);
    if(!empty($_POST))
    {
        $data = $_POST;
    }
    elseif(!empty($_FILES))
    {
        $data = $_FILES;
    }
    else{
        $data = "";
    }
    
    echo $app->calculate($request,$data);
    
?>