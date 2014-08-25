<?php
/**
* Uygulamamızı çalıştıracak olan sınıf
*
* Sistemdeki tüm sınıfların içermeleri gereken veritabanı ve diğer bilgileri tutan sınıf.
*
* @author   Midori Kocak <mtkocak@mtkocak.net>
*/

namespace Midori\Cms;

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
    public function __construct($host, $username, $password, $dbname){ 
        try {
            return $this->db = new PDO("mysql:host=".$host.";dbname=".$dbname."", "".$username."", "".$password."", array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
        } catch ( PDOException $e ){
            return $e->getMessage();
        }
    }
}
?>

