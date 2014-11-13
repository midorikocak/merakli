<?php
/**
 * Tüm sistemdeki ayarları yönetecek sınıftır.
 *
 * Sistemin kurulumunu yapan ve ayarları yöneten sınıf. Sadece tek bir ayar olmasına izin vermeli.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;

use \PDO;

class Settings extends Assets
{


    /**
     * Site Başlığı
     *
     * @var string
     */
    public $title;

    /**
     * Site açıklaması
     *
     * @var string
     */
    public $description;

    /**
     * Site altbilgisi
     *
     * @var string
     */
    public $copyright;

    /**
     * Sisteme ayar ekleyen metod. Bir nevi kurulum da denilebilir.
     * Ancak önce sistemde ayar olup olmadığını kontrol etmeli, ayar varsa, hata vermelidir.
     *
     * @param string $title Site başlığı
     * @param string $description Yönetici parola
     * @param string $copyright Yönetici e-posta
     * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
     */
    public function add($title = null, $description = null, $copyright = null)
    {

        if (!$this->checkLogin()) {
            return false;
        }

        $settings = $this->view();
        if (!empty($settings['setting'])) {

            return array('template' => 'admin', 'render' => true, 'setting' => $settings['setting'], 'renderFile' => 'edit');
        }

        if ($title != null) {
            $settings = $this->show();

            if (!empty($settings['settings'])) {
                return false;
            }

            // insert
            $insert = $this->db->insert('settings')
                        ->set(array(
                             'title' => $title,
                             'description'=>$description,
                             'copyright'=>$copyright
                        ));

            if ($insert) {
                // Veritabanı işlemi başarılı ise sınıfın objesine ait değişkenleri değiştirelim
                $this->id = $this->db->lastId();
                $this->title = $title;
                $this->description = $description;
                $this->copyright = $copyright;

                return true;
            } else {
                return false;
            }
            
        } else {
            return array('render' => true, 'template' => 'admin');
        }
    }

    /**
     * Tek bir ayar verisini edit işlemine yani ayar sayfasına gönderen metod. Render edilmesin
     *
     * @param int $id ayarın benzersiz index'i
     * @return array gösterilebildyise dizi türünde verileri döndürsün, gösterilemediyse false, yanlış değeri döndürsün
     */
    public function view($id = null)
    {

        // Eğer daha önceden sorgu işlemi yapıldıysa, sınıf objesine yazılmıştır.
        if ($id != null && $id == $this->id) {
            return array("id" => $this->id, "title" => $this->title, "description" => $this->description, "copyright" => $this->copyright);
        } else {

            // Buradan anlıyoruz ki veri henüz çekilmemiş. Veriyi çekmeye başlayalım
            $query = $this->db->select('settings')
                            ->limit(0,1)
                        ->run();
            if ($query) {
                $setting = $query[0];

                $this->id = $setting['id'];
                $this->title = $setting['title'];
                $this->description = $setting['description'];
                $this->copyright = $setting['copyright'];

                $result = array('template' => 'admin', 'render' => true, 'setting' => $setting, 'renderFile' => 'edit');
                return $result;
            }
        }

        // Eğer işlem başarısız olduysa, false, yanlış değer döndürelim.
        return false;
    }

    /**
     * Tüm ayarların listelenmesini sağlayan metod. Edit temasını kullanır.
     *
     * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
     */
    public function show()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $oldData = $this->view();
        return array('template' => 'admin', 'render' => true, 'setting' => $oldData['setting'], 'renderFile' => 'edit');
    }

    /**
     * Kullanıcıların listelenmesini sağlayan metod. Bu metod boş olmalı
     *
     * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
     */
    public function index()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        return $this->show();
    }


    /**
     * Ayarı düzenlemeye yarar. Verilen Id bilginse göre, alınan bilgi ile sistemdeki bilgiyi değiştiren
     * güncelleyen metod.
     *
     * @param int $id Kategorinin benzersiz index'i
     * @param string $username Yönetici kullanıcı adı
     * @param string $username Yönetici parola
     * @param string $username Yönetici e-posta
     * @return bool düzenlendiyse doğru, eklenemediyse yanlış değer döndürsün
     */
    public function edit($title = null, $description = null, $copyright = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $oldData = $this->view();
        $id = $oldData['setting']['id'];
        if ($title != null) {
            
            $update = $this->db->update('settings')
                        ->where('id', $id)
                        ->set(array(
                            "title" => $title,
                            "description" => $description,
                            "copyright" => $copyright
                        ));

            if ($update) {
                return true;
            } else {
                return false;
            }

        } else {
            return array('template' => 'admin', 'render' => true, 'setting' => $oldData['setting']);
        }
    }

    /**
     * Ayar silen metod, verilerin silinmesini sağlar. Ayar silinemeyeceği için içi boş.
     * Geri dönüşü yoktur.
     *
     * @param int $id Kategorinin benzersiz index'i
     * @return bool silindiyse doğru, eklenemediyse yanlış değer döndürsün
     */
    public function delete($id = null)
    {
        return array('template' => 'admin', 'render' => false, 'message' => 'Ayar silinemez!');
    }

}

?>

