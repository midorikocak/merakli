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

use \PDO;

class Files extends Assets{
	
    /**
    * Dosya ismi
    *
    * @var string
    */
    public $filename;
	
 
    /**
    * Dosya ekleyen metod, verilerin kaydedilmesini sağlar.
    *
    * @param string $title Dosya başlığı
    * @param string $content Dosya içeriği
    * @param int $category_id Dosya kategorisinin benzersiz kimliği
    * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function add($file=null){
		if($file!=null)
        {
            
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $file["name"]);
            $extension = end($temp);

            if ((($file["type"] == "image/gif")
            || ($file["type"] == "image/jpeg")
            || ($file["type"] == "image/jpg")
            || ($file["type"] == "image/pjpeg")
            || ($file["type"] == "image/x-png")
            || ($file["type"] == "image/png"))
            && ($file["size"] < 2000000)
            && in_array($extension, $allowedExts)) {
              if ($file["error"] > 0) {
                return false;
              } else {
                if (file_exists("./www/images/" . $file["name"])) {
                  return $file["name"] . " already exists. ";
                } else {
                  $rand = substr(md5(microtime()),rand(0,26),5);
                  move_uploaded_file($file["tmp_name"],
                  "./www/images/" . $rand . '.' . $file["name"]);
                  chmod("./www/images/" . $rand . '.' . $file["name"], 0777);
                  // Önce veritabanı sorgumuzu hazırlayalım.
                  $query = $this->db->prepare("INSERT INTO files SET filename=:dosyaadi");

                  $insert = $query->execute(array(
                      "dosyaadi"=>$rand.'.'.$file["name"]
                  ));

                  if($insert){
                      // Veritabanı işlemi başarılı ise sınıfın objesine ait değişkenleri değiştirelim
                      $this->id = $this->db->lastInsertId();
                      $this->filename = $file["name"];

                      return true;
                  }
                  else{
                      return false;
                  }
                }
              }
            } else {
              return "Invalid file";
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
                
                $result = array('file'=>$file);
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
    * Tüm girdilerin listelenmesini sağlayan metod.
    *
    * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
    */
    public function show(){
		$query = $this->db->prepare("SELECT * FROM files");
        $query->execute();
        if($query){
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            $result = array('render'=>true,'template'=>'admin','files'=>  $query->fetchAll(PDO::FETCH_ASSOC));
            return $result;
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
        $oldData = $this->view($id);
        
        unlink('./www/images/'.$oldData['file']['filename']);
        
        $query = $this->db->prepare("DELETE FROM files WHERE id = :id");
        $delete = $query->execute(array(
           'id' => $id
        ));
        
        return array('template'=>'admin','render'=>false);
    }
	
}
?>

