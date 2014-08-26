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

class Categories{
	
    /**
    * Kategorinin tekil id'sini tutan değişken. Başka kategorilerle karışmamasını sağlar
    *
    * @var int
    */
    public $id;
 
    /**
    * Kategori başlığı
    *
    * @var string
    */
    public $title;
	
	
    /**
    * Veritabanı bağlantısını tutacak olan değişken.
    *
    * @var PDO
    */
    private $db = false;
    
    /**
    * Bağlantı yapmaya yarayan metod
    *
    * @param PDO $db Bağlantı objesi
    * @return void
    */
    public function connect($db){
        $this->db = $db;
    }
    
 
    /**
    * Kategori ekleyen metod, verilerin kaydedilmesini sağlar.
    *
    * @param string $title Kategori başlığı
    * @param string $content Kategori içeriği
    * @param int $category_id Kategori kategorisinin benzersiz kimliği
    * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function add($title){
		
		
        // Önce veritabanı sorgumuzu hazırlayalım.
        $query = $this->db->prepare("INSERT INTO categories SET title=:baslik");
	
        $insert = $query->execute(array(
            "baslik"=>$title
        ));
	
        if($insert){
            // Veritabanı işlemi başarılı ise sınıfın objesine ait değişkenleri değiştirelim
            $this->id = $this->db->lastInsertId();
            $this->title = $title;
            
            return true;
        }
        else{
            return false;
        }
    }

    /**
    * Tek bir kategorinin gösterilmesini sağlayan method
    *
    * @param int $id Kategorinin benzersiz index'i
    * @return array gösterilebildyise dizi türünde verileri döndürsün, gösterilemediyse false, yanlış değeri döndürsün
    */
    public function view($id){

        // Eğer daha önceden sorgu işlemi yapıldıysa, sınıf objesine yazılmıştır.
        if($id == $this->id){
            return array("id"=>$this->id,"title"=>$this->title);
        }
        else{
            // Buradan anlıyoruz ki veri henüz çekilmemiş. Veriyi çekmeye başlayalım
            $query = $this->db->prepare("SELECT * FROM posts WHERE id=:id");
            $query->execute(array(':id'=>$id));
		
            if($query){
                $category = $query->fetch(PDO::FETCH_ASSOC);
                $result = array('category'=>$category);
                
                $this->id = $result['id'];
                $this->title = $result['title'];
                
                return $result;
            }
        }
	
        // Eğer iki işlem de başarısız olduysa, false, yanlış değer döndürelim.
        return false;
    }
	
    /**
    * Tüm kategorilerin listelenmesini sağlayan metod.
    *
    * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
    */
    public function index(){
		$query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        if($query){
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            $categories = $query->fetchAll(PDO::FETCH_ASSOC);
            $result = array('categories'=>$categories);
            return $result;
        }
        else
        {
            return false;
        }
    }


    /**
    * Kategori düzenleyen metod. Verilen Id bilginse göre, alınan bilgi ile sistemdeki bilgiyi değiştiren
    * güncelleyen metod.
    *
    * @param int $id Kategorinin benzersiz index'i
    * @return bool düzenlendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function edit($id, $title){
        
		
        // Önce veritabanı sorgumuzu hazırlayalım.
        $query = $this->db->prepare("UPDATE categories SET title=:baslik WHERE id=:id");
	
        $update = $query->execute(array(
            "baslik"=>$title,
            "id"=>$id
        ));
		
        if ( $update ){
             return true;
        }
        else
        {
            return false;
        }
    }

    /**
    * Kategori silen metod, verilerin silinmesini sağlar.
    * Geri dönüşü yoktur.
    *
    * @param int $id Kategorinin benzersiz index'i
    * @return bool silindiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function delete($id){
        $query = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        $delete = $query->execute(array(
           'id' => $id
        ));
    }
	
}
?>

