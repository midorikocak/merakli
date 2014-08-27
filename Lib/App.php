<?php
/**
* Uygulamamızı çalıştıracak olan sınıf
*
* Sistemdeki tüm sınıfların içermeleri gereken veritabanı ve diğer bilgileri tutan sınıf.
*
* @author   Midori Kocak <mtkocak@mtkocak.net>
*/

namespace Midori\Cms;

use Midori\Cms;
use \PDO;

class App{
    
    /**
    * Veritabanı bağlantısını tutacak olan değişken.
    *
    * @var PDO
    */
    private $db = false;

    
    /**
    * Veritabanına bağlanmaya yarayan kurucu metod
    *
    * @param string host Veritabanı sunucusunun adresi
    * @param string dbname Veritabanı adı
    * @param string username Kullanıcı adı
    * @param string password Parola
    * @return string bağlanılabildiyse doğru, bağlanamadıysa hata mesajı döndürsün.
    */
    public function connect($host, $username, $password, $dbname){ 
        try {
            return $this->db = new PDO("mysql:host=".$host.";dbname=".$dbname."", "".$username."", "".$password."", array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
        } catch ( PDOException $e ){
            return $e->getMessage();
        }
    }
    
    public function injectRelatedData(){
        $categories = new Categories($this->db);
        return $categories->index();
    }
    
    public function calculate($request, $data)
    {
        // /posts/add gibi bir request geldi.
        $params = split("/", $request);;
        $className = __NAMESPACE__.'\\'.$params[1];
        //call_user_func_array
        $class = new $className($this->db);
        $class->getRelatedData($this->injectRelatedData());
        
        if(empty($data))
        {
            if($params[2]!=null)
            {
                if(isset($params[3]))
                {
                    $data = $class->$params[2]($params[3]);
                }
                else
                {
                    $data = $class->$params[2]();
                }
                if($data['render']!=false)
                {
                    $content = array('related'=>$this->injectRelatedData(),'content'=>$this->render('./View/'.$params[1].'/'.mb_strtolower($params[2]).'.php',$data));
                    return $this->render('./www/'.$data['template'].'.php', $content);  
                }
                else
                {
                    $data = $class->show();
                    $content =  array('related'=>$this->injectRelatedData(),'content'=>$this->render('./View/'.$params[1].'/show.php',$data));
                    return $this->render('./www/'.$data['template'].'.php', $content);
                }
            }
            else{
                $data = $class->index();
                $content =  array('related'=>$this->injectRelatedData(),'content'=>$this->render('./View/'.$params[1].'/index.php',$data));
                return $this->render('./www/'.$data['template'].'.php', $content);
            }
        }
        else{
            call_user_func_array ( array($class, $params[2]), $data );
            $data = $class->show();
            $content =  array('related'=>$this->injectRelatedData(),'content'=>$this->render('./View/'.$params[1].'/show.php',$data));
            return $this->render('./www/'.$data['template'].'.php', $content);
        }
    }
    
    public function render($file, $vars){
        
        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }
        
        ob_start();
        include $file;
        return ob_get_clean();
    }
    
}


?>

