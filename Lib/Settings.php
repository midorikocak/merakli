<?php
/**
 * The class which administers the settings in the system.
 *
 * The class which sets up the system and settings. Only a single setting should be allowed.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;

use \PDO;

class Settings extends Assets
{


    /**
     * Site title
     *
     * @var string
     */
    public $title;

    /**
     * Site description
     *
     * @var string
     */
    public $description;

    /**
     * Site copyright
     *
     * @var string
     */
    public $copyright;

    /**
     * Sisteme ayar ekleyen metod. The method which adds a setting to the system. It can also be called the installation.
     * It should check if a setting already exists, if so it should return an error.
     *
     * @param string $title Site title
     * @param string $description Administrator password
     * @param string $copyright Administrator e-mail
     * @return bool if added return true, if not return false
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
                // If the database action is successful, let's change the variables belonging to the class object
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
     * The method which edits a single setting and which sends to the settings page. Should not render
     *
     * @param int $id Unique index of setting
     * @return array if it renders properly return array data, if not return false
     */
    public function view($id = null)
    {

        // If an query is sent, the class object has been written.
        if ($id != null && $id == $this->id) {
            return array("id" => $this->id, "title" => $this->title, "description" => $this->description, "copyright" => $this->copyright);
        } else {

            // From here we understand that data is pulled yet. Let's start pulling the data
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

        // If both actions fail, return false.
        return false;
    }

    /**
     * The method which lists all settings. Uses the edit theme.
     *
     * @return bool if it lists return true, if not return false
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
     * The method which lists users. This method must be empty
     *
     * @return bool if it lists return true, if not return false
     */
    public function index()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        return $this->show();
    }


    /**
     * Ayarı düzenlemeye yarar. With the given id and information it edits
     * the information in the system.
     *
     * @param int $id Unique index of the category
     * @param string $username Administrator user name
     * @param string $username Administrator password
     * @param string $username Administrator e-mail
     * @return bool if edited return true, if not return false
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
     * Ayar silinemeyeceği için içi boş. The method which deleted a setting, deltes data.
     * This is not reversable.
     *
     * @param int $id Unique index of category
     * @return bool if it's deleted return true, if not return false
     */
    public function delete($id = null)
    {
        return array('template' => 'admin', 'render' => false, 'message' => 'Ayar silinemez!');
    }

}

?>
