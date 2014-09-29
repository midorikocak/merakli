<?php
    require_once 'Vendor/autoload.php';
    require_once 'Vendor/BasicDB/basicdb.php';
    require 'Config/config.inc.php';
    require 'Lib/App.php';
    session_start();

    $directoryName = basename(dirname(__FILE__));
    
    $app = new \Midori\Cms\App();
    $db = new BasicDB($config['db']['host'], $config['db']['dbname'], $config['db']['username'], $config['db']['password']);
    $app->getDb($db);
    $app->getSettings();

    define('LINK_PREFIX','http://'.$_SERVER['HTTP_HOST'].'/'.$directoryName);
    define('FILE_PREFIX','http://'.$_SERVER['HTTP_HOST'].'/'.$directoryName.'/www/');

    if(strpos($_SERVER['REQUEST_URI'],$_SERVER['SCRIPT_NAME'])!==false){
        $request = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']);
    }
    else{
        $requests = explode('/',$_SERVER['REQUEST_URI']);

        if($requests[1]==$directoryName){
            unset($requests[1]);

            $request = implode('/',$requests);

            if($request=="/")
            {
                $request .= "Posts/";
            }
        }
    }

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
    if(empty($request)){
        $request = "/Posts/";
    }
    echo $app->calculate($request,$data);