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
    * Sistemdeki bağlı bilgileri içeren dizi
    *
    * @var array
    */
    private $related;
    
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
    public function add($title=null){
		
        if($title!=null)
        {
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
        else{
            return array('render'=>true,'template'=>'admin');            
        }
    }

    /**
    * Tek bir kategordeki girdileri göstereceğiz
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
            $query = $this->db->prepare("SELECT * FROM categories WHERE id=:id");
            $query->execute(array(':id'=>$id));
		
            if($query){
                $category = $query->fetch(PDO::FETCH_ASSOC);
                
                $result = array('category'=>$category);
                
                $this->id = $category['id'];
                $this->title = $category['title'];
                
                // Yeni bir sorgu yapacağız ve o kategoriye ait girdileri alacağız.
                // Buradan anlıyoruz ki veri henüz çekilmemiş. Veriyi çekmeye başlayalım
                $postQuery = $this->db->prepare("SELECT * FROM posts WHERE category_id=:category_id");
                $postQuery->execute(array(':category_id'=>$id));
		
                if($postQuery){
                    $categoryPosts = $postQuery->fetchAll(PDO::FETCH_ASSOC);
                
                    $result = array('posts'=>$categoryPosts,'render'=>true,'template'=>'public');
                    return $result;
                    // Yeni bir sorgu yapacağız ve o kategoriye ait girdileri alacağız.
                
                }
            }
        }
	
        // Eğer iki işlem de başarısız olduysa, false, yanlış değer döndürelim.
        return false;
    }
    
    /**
    * Tüm girdilerin listelenmesini sağlayan metod.
    *
    * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
    */
    public function show(){
		$query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        if($query){
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            $result = array('render'=>true,'template'=>'admin','categories'=>  $query->fetchAll(PDO::FETCH_ASSOC));
            return $result;
        }
        else
        {
            return false;
        }
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
    public function edit($id=null, $title=null){
        if($title!=null)
        {
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
        else{
            $oldData = $this->view($id);
            return  array('template'=>'admin','render'=>true,'category'=>$oldData['category']);
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
        return array('template'=>'admin','render'=>false);
    }
	
}
?>

