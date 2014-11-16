<?php
/**
 * Class to manage settings
 *
 * There is only one setting. Basic CRUD operations. Site title, site description and footer copyright.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */
namespace Midori\Cms;

/**
 * Class Settings
 *
 * @package Midori\Cms
 */
class Settings extends Assets
{

    /**
     * Adds settings.
     * If there is a setting in the system, does not add a new setting.
     *
     * @param string $title            
     * @param string $description            
     * @param string $copyright            
     * @return bool
     */
    public function add($title = null, $description = null, $copyright = null)
    {
        if (! $this->checkLogin()) {
            return false;
        }
        
        $settings = $this->view();
        if (! empty($settings['setting'])) {
            
            return array(
                'template' => 'admin',
                'render' => true,
                'setting' => $settings['setting'],
                'renderFile' => 'edit'
            );
        }
        
        if ($title != null) {
            $settings = $this->show();
            
            if (! empty($settings['settings'])) {
                return false;
            }
            
            // insert
            $insert = $this->db->insert('settings')->set(array(
                'title' => $title,
                'description' => $description,
                'copyright' => $copyright
            ));
            
            if ($insert) {
                return true;
            } else {
                return false;
            }
        } else {
            return array(
                'render' => true,
                'template' => 'admin'
            );
        }
    }

    /**
     * Used at edit method.
     * Is not rendered.
     *
     * @param int $id            
     * @return array
     */
    public function view($id = null)
    {
        $query = $this->db->select('settings')
            ->limit(0, 1)
            ->run();
        if ($query) {
            $setting = $query[0];
            
            $result = array(
                'template' => 'admin',
                'render' => true,
                'setting' => $setting,
                'renderFile' => 'edit'
            );
            return $result;
        }
        
        return false;
    }

    /**
     * List the system setting in admin context
     *
     * @return array|bool
     */
    public function show()
    {
        if (! $this->checkLogin()) {
            return false;
        }
        $oldData = $this->view();
        return array(
            'template' => 'admin',
            'render' => true,
            'setting' => $oldData['setting'],
            'renderFile' => 'edit'
        );
    }

    /**
     * Lists settings in public context
     *
     * @return array|bool
     */
    public function index()
    {
        if (! $this->checkLogin()) {
            return false;
        }
        return $this->show();
    }

    /**
     * Edit the setting in the app
     *
     * @param null $title            
     * @param null $description            
     * @param null $copyright            
     * @return array|bool
     */
    public function edit($title = null, $description = null, $copyright = null)
    {
        if (! $this->checkLogin()) {
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
            return array(
                'template' => 'admin',
                'render' => true,
                'setting' => $oldData['setting']
            );
        }
    }

    /**
     * Delete method.
     * Not valid here.
     *
     * TODO, Liskov's substitution principle is violated again I guess. Need a deletableInterface I think.
     *
     * @param int $id            
     * @return array
     */
    public function delete($id = null)
    {
        return array(
            'template' => 'admin',
            'render' => false,
            'message' => "Can't delete setting!"
        );
    }
}

?>

