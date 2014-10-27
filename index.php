<?php
    $startTime = microtime(true);
    require_once 'Vendor/autoload.php';
    require_once 'Vendor/BasicDB/basicdb.php';
    require 'Config/config.inc.php';
    $sess_name = session_name();
    if (session_start()) {
    	setcookie($sess_name, session_id(), null, '/', null, null, true);
    }

    $directoryName = basename(dirname(__FILE__));
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
    
    
    
    
    $app = new \Midori\Cms\App();
    
    try {
        $db = new BasicDB($config['db']['host'], $config['db']['dbname'], $config['db']['username'], $config['db']['password']);
        $app->getDb($db);
        
        if($app->getUsers()==false)
        {
            if(!isset($_POST['user'])){
                echo $app->installUser();
            }
            else
            {
                if(isset($_POST['user']['username']) && preg_match('/^\w{5,}$/', $_POST['user']['username']) && filter_var($_POST['user']['email'], FILTER_VALIDATE_EMAIL)){
                    $_POST['user']['username'] = filter_var($_POST['user']['username'], FILTER_SANITIZE_MAGIC_QUOTES);
                    
                    if(isset($_POST['user']['password1']) && isset($_POST['user']['password2']) && ($_POST['user']['password1'] == $_POST['user']['password2'])){
                        echo $app->installUser($_POST['user']);
                    }
                    else{
                        echo $app->installUser();
                    }
                }
                else{
                    echo $app->installUser();
                }
            }
        }
        elseif(!$app->getSettings())
        {
            if(isset($_POST['setting'])){
                echo $app->installSettings($_POST['setting']);
            }
            else{
                echo $app->installSettings();
            }
        }
        else
        {
            echo $app->calculate($request,$data);
        }
    } catch (Exception $e) {
        if($e->getCode()==1049)
        {
            if(isset($_POST['db']['host'])){
                $_POST['db']['host'] = filter_var(gethostbyname($_POST['db']['host']), FILTER_VALIDATE_IP);
            }
            
            if(isset($_POST['db']['dbname']) && preg_match('/^\w{5,}$/', $_POST['db']['dbname']) ){
                $_POST['db']['dbname'] = filter_var($_POST['db']['dbname'], FILTER_SANITIZE_MAGIC_QUOTES);
            }
            
            if(isset($_POST['db']['username']) && preg_match('/^\w{5,}$/', $_POST['db']['username']) ){
                $_POST['db']['username'] = filter_var($_POST['db']['username'], FILTER_SANITIZE_MAGIC_QUOTES);
            }
            
            if(isset($_POST['db']['password'])){
                $_POST['db']['password'] = filter_var($_POST['db']['password'], FILTER_SANITIZE_MAGIC_QUOTES);
            }
            if(isset($_POST['db']))
            {
                $config['db'] = $_POST['db'];
                echo $app->installDatabase($config);
            }
            else{
                echo $app->installDatabase();
            }
        }
    }
    
    
    $endTime = microtime(true);
    $elapsed = $endTime - $startTime;
    //echo "Execution time : $elapsed seconds"; // Uncomment for debugging