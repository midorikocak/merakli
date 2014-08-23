<?php
/**
* Tüm sistemdeki girdileri yönetecek olan girdi sınıfıdır.
*
* Sistemdeki girdilerin düzenlenmesini, silinmesini, görüntülenmesini, 
* listelenmesini ve eklenmesini kontrol eden sınıftır.
*
* @author     Midori Kocak <mtkocak@mtkocak.net>
*/

namespace Midori\Cms;

class Posts{
	
    /**
    * Girdinin tekil id'sini tutan değişken. Başka girdilerle karışmamasını sağlar
    *
    * @var int
    */
    public $id;
 
    /**
    * Girdi başlığı
    *
    * @var string
    */
    public $title;
	
    /**
    * Girdinin içeriği
    *
    * @var string
    */
    public $content;
	
    /**
    * Girdinin ait olduğu benzersiz kategori kimliği
    *
    * @var int
    */
    public $category_id;
	
    
    /**
    * Girdinin hangi tarihte oluşturulduğunu gösteren değişken
    *
    * @var string
    */
    private $created;
	
    /**
    * Girdinin hangi tarihte güncellendiğini gösteren değişken
    *
    * @var string
    */
    private $updated;
	
    /**
    * Veritabanı bağlantısını tutacak olan değişken.
    *
    * @var PDO
    */
    private $db;

    /**
    * Veritabanına bağlanmaya yarayan yardımcı metod
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
    * Şu anki tarihi döndüren yardımcı metod
    *
    * @return string tarihi mysql formatında döndürür
    */
    public function getDate(){
        date_default_timezone_set('Europe/Istanbul');
        $currentDate = date("Y-m-d H:i:s");
		
        return $currentDate;
    }
 
    /**
    * Girdi ekleyen metod, verilerin kaydedilmesini sağlar.
    *
    * @param string $title Girdi başlığı
    * @param string $content Girdi içeriği
    * @param int $category_id Girdi kategorisinin benzersiz kimliği
    * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function add($title, $content, $category_id){
		
        // Tarih içeren alanları elle girmiyoruz. Sistemden doğrudan isteyen fonksiyonumuz var.
        $date = $this->getDate();
		
        // Önce veritabanı sorgumuzu hazırlayalım.
        $query = $this->db->prepare("INSERT INTO posts SET title=:baslik, content=:icerik, created=:created, category_id=:category, updated=:updated");
	
        $insert = $query->execute(array(
            "baslik"=>$title,
            "icerik"=>$content,
            "category"=>$category_id,
            "created"=>$date,
            "updated"=>$date
        ));
	
        if($insert){
            // Veritabanı işlemi başarılı ise sınıfın objesine ait değişkenleri değiştirelim
            $this->id = $this->db->lastInsertId();
            $this->title = $title;
            $this->content = $content;
            $this->created = $date;
            $this->updated = $date;
            $this->category_id = $category_id;
            
            return true;
        }
        else{
            return false;
        }
    }

    /**
    * Tek bir girdinin gösterilmesini sağlayan method
    *
    * @param int $id Girdinin benzersiz index'i
    * @return array gösterilebildyise dizi türünde verileri döndürsün, gösterilemediyse false, yanlış değeri döndürsün
    */
    public function view($id){

        // Eğer daha önceden sorgu işlemi yapıldıysa, sınıf objesine yazılmıştır.
        if($id == $this->id){
            return array("id"=>$this->id,"title"=>$this->title,"content"=>$this->content, "category_id"=>$this->category_id, "created"=>$this->created, "updated"=>$this->updated);
        }
        else{
            // Buradan anlıyoruz ki veri henüz çekilmemiş. Veriyi çekmeye başlayalım
            $query = $this->db->prepare("SELECT * FROM posts WHERE id=:id");
            $query->execute(array(':id'=>$id));
		
            if($query){
                $result = $query->fetch(PDO::FETCH_ASSOC);
                
                $this->id = $result['id'];
                $this->title = $result['title'];
                $this->content = $result['content'];
                $this->created = $result['created'];
                $this->updated = $result['updated'];
                $this->category_id = $result['updated'];
                
                return $result;
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
    public function index(){
		$query = $this->db->prepare("SELECT * FROM posts");
        $query->execute();
        if($query){
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }


    /**
    * Girdi düzenleyen metod. Verilen Id bilginse göre, alınan bilgi ile sistemdeki bilgiyi değiştiren
    * güncelleyen metod.
    *
    * @param int $id Girdinin benzersiz index'i
    * @return bool düzenlendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function edit($id, $title, $content, $category_id){
        
        // Tarih içeren alanları elle girmiyoruz. Sistemden doğrudan isteyen fonksiyonumuz var.
        $date = $this->getDate();
		
        // Önce veritabanı sorgumuzu hazırlayalım.
        $query = $this->db->prepare("UPDATE posts SET title=:baslik, content=:icerik, category_id=:category, updated=:updated WHERE id=:id");
	
        $update = $query->execute(array(
            "baslik"=>$title,
            "icerik"=>$content,
            "category"=>$category_id,
            "updated"=>$date,
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
    * Girdi silen metod, verilerin silinmesini sağlar.
    * Geri dönüşü yoktur.
    *
    * @param int $id Girdinin benzersiz index'i
    * @return bool silindiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function delete($id){
        $query = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        $delete = $query->execute(array(
           'id' => $id
        ));
    }
	
}
?>

