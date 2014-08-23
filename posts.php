<?php
/**
* Tüm sistemdeki girdileri yönetecek olan girdi sınıfıdır.
*
* Sistemdeki girdilerin düzenlenmesini, silinmesini, görüntülenmesini, 
* listelenmesini ve eklenmesini kontrol eden sınıftır.
*
* @author Midori Kocak <mtkocak@mtkocak.net>
*/
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
    * Tüm girdilerin listelenmesini sağlayan metod.
    *
    * @return bool listelenebildiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function index(){
    }
 
    /**
    * Tek bir girdinin gösterilmesini sağlayan method
    *
    * @param int $id Girdinin benzersiz index'i
    *@return bool gösterilebildiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function view($id){
    }
 
    /**
    * Girdi ekleyen metod, verilerin kaydedilmesini sağlar.
    *
    * @param string $title Girdi başlığı
    * @param string $content Girdi içeriği
    * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function add($title, $content){
    }


    /**
    * Girdi düzenleyen metod. Verilen Id bilginse göre, alınan bilgi ile sistemdeki bilgiyi değiştiren
    * güncelleyen metod.
    *
    * @param int $id Girdinin benzersiz index'i
    * @return bool düzenlendiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function edit($id){
    }

    /**
    * Girdi silen metod, verilerin silinmesini sağlar.
    * Geri dönüşü yoktur.
    *
    * @param int $id Girdinin benzersiz index'i
    * @return bool silindiyse doğru, eklenemediyse yanlış değer döndürsün
    */
    public function delete($id){
    }
 
    ?>