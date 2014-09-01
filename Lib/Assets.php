<?php
/**
* Tüm sistemdeki kategorileri yönetecek olan kategori sınıfıdır.
*
* Sistemdeki kategorilerin düzenlenmesini, silinmesini, görüntülenmesini, 
* listelenmesini ve eklenmesini kontrol eden sınıftır.
*
* @author     Midori Kocak <mtkocak@mtkocak.net>
*/

namespace Midori\Cms;

use \PDO;

/**
 * Class Assets
 * @package Midori\Cms
 */
abstract class Assets{
	
    /**
    * Kategorinin tekil id'sini tutan değişken. Başka kategorilerle karışmamasını sağlar
    *
    * @var int
    */
    public $id;
 		
    /**
    * Veritabanı bağlantısını tutacak olan değişken.
    *
    * @var PDO
    */
    protected $db = false;
    
    /**
    * Bağlantı yapmaya yarayan metod
    *
    * @param PDO $db Bağlantı objesi
    * @return void
    */
    protected function connect($db){
        $this->db = $db;
    }
    
    /**
    * Sistemdeki bağlı bilgileri içeren dizi
    *
    * @var array
    */
    public $related;

    /**
     * Sınıftan nesne oluşturulduğunda otomatik çalışan metod
     * Burada sınıfın çalışması için veritabanı sınıfı isteniyor.
     *
     * @param $db
     */
    public function __construct($db){
        $this->db = $db;
    }

    /**
     * Sistemde oturum açılıp açılmadığını gösteren metod
     *
     * @return bool
     */
    public function checkLogin()
    {
        // Burada tekrar oturum kontrolü yapıyoruz:
        if(!isset($_SESSION['username'])){
            return false;
            //return array('render'=>false,'template'=>'public','message'=>'Lütfen oturum açınız!');
        }
        else{
            return true;
        }
    }
    
    /**
    * Bağlı
    *
    * @param PDO $db Bağlantı objesi
    * @return void
    */
    public function getRelatedData($related){
        $this->related = $related;
    }
 
    /**
    * Kategori ekleyen metod, verilerin kaydedilmesini sağlar.
    *
    * @param string $title Kategori başlığı
    * @param string $content Kategori içeriği
    * @param int $category_id Kategori kategorisinin benzersiz kimliği
    * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    abstract public function add();

    /**
    * Tek bir kategordeki girdileri göstereceğiz
    *
    * @param int $id Kategorinin benzersiz index'i
    * @return array gösterilebildyise dizi türünde verileri döndürsün, gösterilemediyse false, yanlış değeri döndürsün
    */
    abstract public function view($id);
    
    /**
    * Tüm girdilerin listelenmesini sağlayan metod.
    *
    * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
    */
    abstract public function show();
	
    /**
    * Tüm kategorilerin listelenmesini sağlayan metod.
    *
    * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
    */
    abstract public function index();


    /**
    * Kategori düzenleyen metod. Verilen Id bilginse göre, alınan bilgi ile sistemdeki bilgiyi değiştiren
    * güncelleyen metod.
    *
    * @param int $id Kategorinin benzersiz index'i
    * @return bool düzenlendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    abstract public function edit();
    

    /**
    * Kategori silen metod, verilerin silinmesini sağlar.
    * Geri dönüşü yoktur.
    *
    * @param int $id Kategorinin benzersiz index'i
    * @return bool silindiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    abstract public function delete($id);
	
}
?>

