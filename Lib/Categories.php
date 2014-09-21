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
 * Class Categories
 * @package Midori\Cms
 */
class Categories extends Assets
{


    /**
     * Kategori başlığı
     *
     * @var string
     */
    public $title;

    /**
     * Kategori ekleyen metod, verilerin kaydedilmesini sağlar.
     *
     * @param string $title Kategori başlığı
     * @param string $content Kategori içeriği
     * @param int $category_id Kategori kategorisinin benzersiz kimliği
     * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
     */
    public function add($title = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }

        if ($title != null) {
            

            // insert
            $insert = $this->db->insert('categories')
                        ->set(array(
                             'title' => $title,
                        ));

            if ($insert) {
                // Veritabanı işlemi başarılı ise sınıfın objesine ait değişkenleri değiştirelim
                $this->id = $this->db->lastId();
                $this->title = $title;

                return true;
            } else {
                return false;
            }
        } else {
            return array('render' => true, 'template' => 'admin');
        }
    }

    /**
     * Tek bir kategordeki girdileri göstereceğiz
     *
     * @param int $id Kategorinin benzersiz index'i
     * @return array gösterilebildyise dizi türünde verileri döndürsün, gösterilemediyse false, yanlış değeri döndürsün
     */
    public function view($id)
    {

        // Eğer daha önceden sorgu işlemi yapıldıysa, sınıf objesine yazılmıştır.
        if ($id == $this->id) {
            return array("id" => $this->id, "title" => $this->title);
        } else {
            // Buradan anlıyoruz ki veri henüz çekilmemiş. Veriyi çekmeye başlayalım
            
            $query = $this->db->select('categories')
                        ->where('id', $id)
                        ->run();
            
            if ($query) {
                $category = $query[0];

                $this->id = $category['id'];
                $this->title = $category['title'];

                // Yeni bir sorgu yapacağız ve o kategoriye ait girdileri alacağız.
                // Buradan anlıyoruz ki veri henüz çekilmemiş. Veriyi çekmeye başlayalım
                
                $postQuery = $this->db->select('posts')
                            ->where('category_id', $id)
                            ->run();

                if ($postQuery) {
                    $categoryPosts = $postQuery;

                    $result = array('posts' => $categoryPosts, 'render' => true, 'template' => 'public', 'category' => $category);
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
    public function show()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        
        $query = $this->db->select('categories')
                    ->run();
        
        if ($query) {
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            $result = array('render' => true, 'template' => 'admin', 'categories' => $query);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Tüm kategorilerin listelenmesini sağlayan metod.
     *
     * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
     */
    public function index()
    {
        $query = $this->db->select('categories')
                    ->run();
        if ($query) {
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            $categories = $query;
            $result = array('categories' => $categories, 'render' => false, 'template' => 'public');
            return $result;
        } else {
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
    public function edit($id = null, $title = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        if ($title != null) {
            // Önce veritabanı sorgumuzu hazırlayalım.
            
            $update = $this->db->update('categories')
                        ->where('id', $id)
                        ->set(array(
                             'title' => $title
                        ));

            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            $oldData = $this->view($id);
            return array('template' => 'admin', 'render' => true, 'category' => $oldData['category']);
        }
    }

    /**
     * Kategori silen metod, verilerin silinmesini sağlar.
     * Geri dönüşü yoktur.
     *
     * @param int $id Kategorinin benzersiz index'i
     * @return bool silindiyse doğru, eklenemediyse yanlış değer döndürsün
     */
    public function delete($id)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        
        $query = $this->db->delete('categories')
                    ->where('id', $id)
                    ->done();
        
        return array('template' => 'admin', 'render' => false);
    }

}

?>

