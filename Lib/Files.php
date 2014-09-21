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

class Files extends Assets
{

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
    public function add($file = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        if ($file != null) {

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
                && in_array($extension, $allowedExts)
            ) {
                if ($file["error"] > 0) {
                    return false;
                } else {
                    if (file_exists("./www/images/" . $file["name"])) {
                        return $file["name"] . " already exists. ";
                    } else {
                        $rand = substr(md5(microtime()), rand(0, 26), 5);
                        move_uploaded_file($file["tmp_name"],
                            "./www/images/" . $rand . '.' . $file["name"]);
                        chmod("./www/images/" . $rand . '.' . $file["name"], 0777);
                        // Önce veritabanı sorgumuzu hazırlayalım.
                        
                        
                        // insert
                        $insert = $this->db->insert('files')
                                    ->set(array(
                                         'filename' => $rand . '.' . $file["name"],
                                    ));

                        if ($insert) {
                            // Veritabanı işlemi başarılı ise sınıfın objesine ait değişkenleri değiştirelim
                            $this->id = $this->db->lastId();
                            $this->filename = $file["name"];

                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            } else {
                return "Invalid file";
            }
        } else {
            return array('render' => true, 'template' => 'admin');
        }
    }

    /**
     * Tek bir dosyanın gösterilmesini sağlayan method
     *
     * @param int $id Dosyanın benzersiz index'i
     * @return array gösterilebildyise dizi türünde verileri döndürsün, gösterilemediyse false, yanlış değeri döndürsün
     */
    public function view($id)
    {

        // Eğer daha önceden sorgu işlemi yapıldıysa, sınıf objesine yazılmıştır.
        if ($id == $this->id) {
            return array("id" => $this->id, "filename" => $this->filename);
        } else {
            
            
            $query = $this->db->select('files')
                        ->where('id', $id)
                        ->run();
            
            if ($query) {
                $file = $query;

                $this->id = $file['id'];
                $this->filename = $file['filename'];

                $result = array('file' => $file);
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
    public function index()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->select('files')
                    ->run();
        if ($query) {
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            return array('files' => $query);
        } else {
            return false;
        }
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
        $query = $this->db->select('files')
                    ->run();
        if ($query) {
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            $result = array('render' => true, 'template' => 'admin', 'files' => $query);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Dosya düzenleyen metod
     *
     * Dosyaların düzenlenmesini istemiyoruz. Bu yüzden metodumuzun içi boş.
     *
     * @return bool
     */
    public function edit()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        return true;
    }


    /**
     * Dosya silen metod, verilerin silinmesini sağlar.
     * Geri dönüşü yoktur.
     *
     * @param int $id Dosyanın benzersiz index'i
     * @return bool silindiyse doğru, eklenemediyse yanlış değer döndürsün
     */
    public function delete($id)
    {
        $oldData = $this->view($id);

        unlink('./www/images/' . $oldData['file']['filename']);
        
        $query = $db->delete('files')
                    ->where('id', $id)
                    ->done();

        return array('template' => 'admin', 'render' => false);
    }

}

?>

