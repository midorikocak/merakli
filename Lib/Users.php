<?php
/**
 * Tüm sistemdeki kullanıcıları yönetecek olan kategori sınıfıdır.
 *
 * Sistemdeki yöneticilerin oturum açmalarını, parola değiştirmelerini sağlayan sınıf.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;

use \PDO;

/**
 * Class Users
 * @package Midori\Cms
 */
class Users extends Assets
{


    /**
     * Yönetici kullanıcı adı
     *
     * @var string
     */
    public $username;

    /**
     * Yönetici e-postası
     *
     * @var string
     */
    public $email;

    /**
     * Yönetici parolası
     *
     * @var string
     */
    private $password;

    /**
     * Kullanıcı ekleyen metod, verilerin kaydedilmesini sağlar. Sistemde hiç kullanıcı yoksa
     * public olsun, kullanıcı varsa admin temasını işlesin. (render etsin)
     *
     * @param string $username Yönetici kullanıcı adı
     * @param string $password Yönetici parola
     * @param string $password2 Yönetici parola kontrol değeri
     * @param string $email Yönetici e-posta
     * @return bool eklendiyse doğru, eklenemediyse yanlış değer döndürsün
     */
    public function add($username = null, $email = null, $password = null, $password2 = null)
    {
        $users = $this->index();
        // Login olup olmadığımızı ve sistemde kullanıcı olup olmadığını kontrol eden metod.
        if (!$this->checkLogin()) {
            return false;
        }

        if ($password != $password2) {
            return false;
        }

        // 3 değişkenin de boş olmaması gerekiyor
        if ($username != null && $email != null && $password != null) {
            // Önce veritabanı sorgumuzu hazırlayalım.
            

            // insert
            $insert = $this->db->insert('users')
                        ->set(array(
                            "username" => $username,
                            "password" => md5($password),
                            "email" => $email,
                        ));

            if ($insert) {
                // Veritabanı işlemi başarılı ise sınıfın objesine ait değişkenleri değiştirelim
                $this->id = $this->db->lastId();
                $this->username = $username;
                $this->password = $password;
                $this->email = $email;

                return true;
            } else {
                return false;
            }
        } else {
            return array('render' => true, 'template' => 'admin');
        }
    }

    /**
     * Tek bir kullanıcı verisini edit işlemine yani profil sayfasına gönderen metod. Render edilmesin
     *
     * @param int $id Kullanıcının benzersiz index'i
     * @return array gösterilebildyise dizi türünde verileri döndürsün, gösterilemediyse false, yanlış değeri döndürsün
     */
    public function view($id)
    {

        // Login olup olmadığımızı ve sistemde kullanıcı olup olmadığını kontrol eden metod.
        if (!$this->checkLogin()) {
            return false;
        }
        // Eğer daha önceden sorgu işlemi yapıldıysa, sınıf objesine yazılmıştır.
        if ($id == $this->id) {
            return array("id" => $this->id, "username" => $this->username, "email" => $this->email, "password" => $this->password,);
        } else {
            // Buradan anlıyoruz ki veri henüz çekilmemiş. Veriyi çekmeye başlayalım
            
            $query = $this->db->select('users')
                        ->where('id', $id)
                        ->run();
            
            if ($query) {
                $user = $query;

                $this->id = $user['id'];
                $this->username = $user['username'];
                $this->password = $user['password'];

                $result = array('template' => 'admin', 'user' => $user, 'render' => true);
                return $result;
            }
        }

        // Eğer iki işlem de başarısız olduysa, false, yanlış değer döndürelim.
        return false;
    }

    /**
     * Tüm kullanıcıların listelenmesini sağlayan metod.
     *
     * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
     */
    public function show()
    {

        // Login olup olmadığımızı ve sistemde kullanıcı olup olmadığını kontrol eden metod.
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->select('users')
                    ->run();

        if ($query) {
            // Buradaki fetchAll metoduyla tüm değeleri diziye çektik.
            $result = array('render' => true, 'template' => 'admin', 'users' => $query);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Kullanıcıların listelenmesini sağlayan metod. Bu metodu liste çekmek için kullandık
     * Bu metod da view metodu gibi render edilmiyor.
     *
     * @return bool listelenebildiyse doğru, listelenemediyse yanlış değer döndürsün
     */
    public function index()
    {
        return $this->show();
    }


    /**
     * Kullanıcıyı düzenlemeye yarar. Verilen Id bilginse göre, alınan bilgi ile sistemdeki bilgiyi değiştiren
     * güncelleyen metod. Bu sayfa aynı zamanda kullanıcının profil sayfası olarak da görünmeli. View metodundan
     * hazır verileri alıp göstersin.
     *
     * @param int $id Kategorinin benzersiz index'i
     * @param string $username Yönetici kullanıcı adı
     * @param string $password Yönetici parola
     * @param string $password2 Yönetici parola kontrol değeri
     * @param string $email Yönetici e-posta
     * @return bool düzenlendiyse doğru, eklenemediyse yanlış değer döndürsün
     */
    public function edit($id = null, $username = null, $password = null, $password2 = null, $email = null)
    {
        // Login olup olmadığımızı ve sistemde kullanıcı olup olmadığını kontrol eden metod.
        if (!$this->checkLogin()) {
            return false;
        }

        if ($password != $password2) {
            return false;
        }

        if ($id != null && $username != null && $password != null && $email != null) {
            
            $update = $this->db->update('user')
                        ->where('id', $id)
                        ->set(array(
                            "username" => $username,
                            "password" => md5($password),
                            "email" => $email
                        ));

            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            $oldData = $this->view($id);
            return array('template' => 'admin', 'render' => true, 'user' => $oldData['user']);
        }
    }


    /**
     * Kullanıcı girişi yapan metod
     *
     * @param $username
     * @param $password
     * @return array
     */
    public function login($username = null, $password = null)
    {
        if (!$this->checkLogin()) {
            // Buradan anlıyoruz ki veri henüz oturum açılmamış.
            
            $query = $this->db->select('users')
                        ->where('username', $username)
                        ->where('password', md5($password))
                        ->run();

            if ($query) {
                $user = $query;
                // Kullanıcı adı veya parolası hatalıysa
                if (!$user) {
                    return array('template' => 'public', 'render' => true, 'message' => 'Hatalı kullanıcı adı veya parola.');
                }

                $this->id = $user['id'];
                $this->$username = $user['username'];
                $this->$password = $user['password'];

                // Session işlerini hallediyoruz.

                $_SESSION['username'] = $user['username'];
                $_SESSION['id'] = $user['id'];

                return array('template' => 'admin', 'render' => false, 'message' => 'Oturum açıldı', 'user' => $user);
            }
        } else {
            return array('template' => 'admin', 'render' => false, 'message' => 'Zaten oturum açıldı!');
        }
        return false;
    }


    /**
     * Kullanıcının sistemden çıkmasını sağlayan metod
     *
     */
    public function logout()
    {
        unset($_SESSION['username']);
        return array('template' => 'public', 'render' => false, 'message' => 'Sistemden çıktınız');
    }

    /**
     * Kullanıcı silen metod, verilerin silinmesini sağlar.
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
        
        $query = $this->db->delete('users')
                    ->where('id', $id)
                    ->done();
        
        return array('template' => 'admin', 'render' => false);
    }

}

?>

