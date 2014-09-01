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

/**
 * Class App
 * @package Midori\Cms
 */
class App{
    
    /**
    * Veritabanı bağlantısını tutacak olan değişken.
    *
    * @var PDO
    */
    private $db = false;

    /**
     * Sistem ayarlarını çeken değişken.
     *
     * @var array
     */
    private $settings = false;

    
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

    /**
     * Nesnelere bağlı olan bilgileri çektiğimiz metod
     *
     * @return array
     */
    public function injectRelatedData(){
        $categories = new Categories($this->db);
        return $categories->index();
    }

    /**
     * Tüm sitedeki ayarları çektiğimiz metod
     *
     * @return array
     */
    public function getSettings(){
        $settings = new Settings($this->db);
        $setting = $settings->view();
        $this->settings = $setting['setting'];
    }

    /**
     * Sistemdeki bütün görüntüleme hesaplama işlemlerini yapan metod
     *
     * @param $request
     * @param $data
     * @return string
     */
    public function calculate($request, $data)
    {
        // /posts/add gibi bir request geldi.
        $params = split("/", $request);
        $className = __NAMESPACE__.'\\'.$params[1];
        //call_user_func_array
        $class = new $className($this->db);
        $class->getRelatedData($this->injectRelatedData());

        // Bu sınıfı tamamen değiştirmemiz gerek. Kullanıcının oturum açıp açmadığını
        // açtıysa, oturum bilgilerine göre neyin nasıl görüntüleneceğini belirlemeliyiz.
        //  Mesajlar uçuyordu halloldu

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
                if(isset($data['message']))
                {
                    $message=$data['message'];
                }
                else{
                    $message = null;
                }

                if(isset($data['renderFile'])){
                    $params[2] = $data['renderFile'];
                    $renderFile = $data['renderFile'];
                }
                else{
                    $renderFile = 'show';
                }

                if(isset($data['render']) && $data['render']!=false)
                {
                    $content = array('message'=>$message,'related'=>$this->injectRelatedData(),'content'=>$this->render('./View/'.$params[1].'/'.mb_strtolower($params[2]).'.php',$data));
                    return $this->render('./www/'.$data['template'].'.php', $content);
                }
                else
                {
                    if(isset($data['message']))
                    {
                        $message=$data['message'];
                    }
                    else{
                        $message = null;
                    }
                    if($class->show()!=false){
                        // login sayfasına gitsin
                        $data = $class->show();
                        $content =  array('message'=>$message,'related'=>$this->injectRelatedData(),'content'=>$this->render('./View/'.$params[1].'/'.$renderFile.'.php',$data));
                        return $this->render('./www/'.$data['template'].'.php', $content);
                    }
                    else{
                        $content =  array('message'=>$message,'related'=>$this->injectRelatedData(),'content'=>$this->render('./View/Users/login.php',$data));
                        return $this->render('./www/public.php', $content);
                    }
                }
            }
            else{


                $data = $class->index();

                if(isset($data['renderFile'])){
                    $params[2] = $data['renderFile'];
                    $renderFile = $data['renderFile'];
                }
                else{
                    $renderFile = 'index';
                }


                if(isset($data['message']))
                {
                    $message=$data['message'];
                }
                else{
                    $message = null;
                }
                $content =  array('message'=>$message,'related'=>$this->injectRelatedData(),'content'=>$this->render('./View/'.$params[1].'/'.$renderFile.'.php',$data));
                return $this->render('./www/'.$data['template'].'.php', $content);
            }
        }
        else{
            $data = call_user_func_array ( array($class, $params[2]), $data );

            if(isset($data['renderFile'])){
                $params[2] = $data['renderFile'];
                $renderFile = $data['renderFile'];
            }
            else{
                $renderFile = 'show';
            }

            if(isset($data['message']))
            {
                $message=$data['message'];
            }
            else{
                $message=null;
            }

            if($class->show()!=false){
                // login sayfasına gitsin
                $data = $class->show();
                $content =  array('message'=>$message,'related'=>$this->injectRelatedData(),'content'=>$this->render('./View/'.$params[1].'/'.$renderFile.'.php',$data));
            }
            else
            {
                $content =  array('message'=>$message,'related'=>$this->injectRelatedData(),'content'=>$this->render('./View/Users/login.php',$data));
            }
            return $this->render('./www/'.$data['template'].'.php', $content);
        }
    }

    /**
     * Tema dosyalarının ihtiyaç duyulan değişkenlerle gösterilmesini sağlayan metod
     *
     * @param $file
     * @param $vars
     * @return string
     */
    public function render($file, $vars){
        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }

        if($this->settings!=false && !isset($title))
        {
            extract($this->settings);
        }
        
        ob_start();
        include $file;
        return ob_get_clean();
    }
    
}


?>

