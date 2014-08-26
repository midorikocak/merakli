<?php
/**
* Tüm sistemdeki dosyaları yönetecek olan dosya sınıfıdır.
*
* Sistemdeki dosyaların düzenlenmesini, silinmesini, görüntülenmesini, 
* listelenmesini ve eklenmesini kontrol eden sınıftır.
*
* @author     Midori Kocak <mtkocak@mtkocak.net>
*/

namespace Midori\Cms;

class Files{
	
    /**
    * Dosyanın tekil id'sini tutan değişken. Başka dosyalarle karışmamasını sağlar
    *
    * @var int
    */
    public $id;
 
    /**
    * Dosya ismi
    *
    * @var string
    */
    public $filename;
	
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
    * Dosya ekleyen metod, verilerin kaydedilmesini sağlar.
    *
    * @param string $title Dosya başlığı
    * @param string $content Dosya içeriği
    * @param int $category_id Dosya kategorisinin benzersiz kimliği
    * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function add($filename=null){
		if($filename!=null)
        {
            // Önce veritabanı sorgumuzu hazırlayalım.
            $query = $this->db->prepare("INSERT INTO posts SET filename=:dosyaadi");
	
            $insert = $query->execute(array(
                "dosyaadi"=>$filename,
            ));
	
            if($insert){
                // Veritabanı işlemi başarılı ise sınıfın objesine ait değişkenleri değiştirelim
                $this->id = $this->db->lastInsertId();
                $this->filename = $filename;
            
                return true;
            }
            else{
                return false;
            }  
        }
        else
        {
            return array('render'=>true,'template'=>'admin');
        }
    }

    /**
    * Tek bir dosyanın gösterilmesini sağlayan method
    *
    * @param int $id Dosyanın benzersiz index'i
    * @return array gösterilebildyise dizi türünde verileri döndürsün, gösterilemediyse false, yanlış değeri döndürsün
    */
    public function view($id){

        // Eğer daha önceden sorgu işlemi yapıldıysa, sınıf objesine yazılmıştır.
        if($id == $this->id){
            return array("id"=>$this->id,"filename"=>$this->filename);
        }
        else{
            // Buradan anlıyoruz ki veri henüz çekilmemiş. Veriyi çekmeye başlayalım
            $query = $this->db->prepare("SELECT * FROM files WHERE id=:id");
            $query->execute(array(':id'=>$id));
		
            if($query){
                $file = $query->fetch(PDO::FETCH_ASSOC);
                
                $this->id = $file['id'];
                $this->title = $file['filename'];
                
                $result = array('file'=>$file)
                return $result;
            }
        }
	
        // Eğer iki işlem de başarısız olduysa, false, yanlış değer döndürelim.
        return false;
    }
	
    /**
    * Tüm dosyaların listelenmesini sağlayan metod.
    *
    * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
    */
    public function index(){
		$query = $this->db->prepare("SELECT * FROM files");
        $query->execute();
        if($query){
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            return array('files'=>$query->fetchAll(PDO::FETCH_ASSOC));
        }
        else
        {
            return false;
        }
    }


    /**
    * Dosya düzenleyen metod. Verilen Id bilginse göre, alınan bilgi ile sistemdeki bilgiyi değiştiren
    * güncelleyen metod.
    *
    * @param int $id Dosyanın benzersiz index'i
    * @return bool düzenlendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function edit($id, $filename){
        
        // Tarih içeren alanları elle girmiyoruz. Sistemden doğrudan isteyen fonksiyonumuz var.
        $date = $this->getDate();
		
        // Önce veritabanı sorgumuzu hazırlayalım.
        $query = $this->db->prepare("UPDATE files SET filename=:filename WHERE id=:id");
	
        $update = $query->execute(array(
            "filename"=>$filename,
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
    * Dosya silen metod, verilerin silinmesini sağlar.
    * Geri dönüşü yoktur.
    *
    * @param int $id Dosyanın benzersiz index'i
    * @return bool silindiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function delete($id){
        $query = $this->db->prepare("DELETE FROM files WHERE id = :id");
        $delete = $query->execute(array(
           'id' => $id
        ));
    }
	
}
?>

