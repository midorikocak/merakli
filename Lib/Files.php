<?php
/**
 * The class which administers all files in the system.
 *
 * The class which edits, deletes, renders, lists and adds files in the system.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;

use \PDO;

class Files extends Assets
{

    /**
     * File name
     *
     * @var string
     */
    public $filename;


    /**
     * The method which adds the file, saves the data.
     *
     * @param string $title File title
     * @param string $content File content
     * @param int $category_id Unique identity of file category
     * @return bool if added return true, if not return false
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
                        // Let's first prepare our database query.


                        // insert
                        $insert = $this->db->insert('files')
                                    ->set(array(
                                         'filename' => $rand . '.' . $file["name"],
                                    ));

                        if ($insert) {
                            // If the database action is successful, let's change the variables belonging to the class object
                            $this->id = $this->db->lastId();
                            $this->filename = $file["name"];

                            return array('render'=>false, 'file'=> $file["name"]);
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
     * The method which renders a single file
     *
     * @param int $id Unique index of file
     * @return array if it renders properly return array data, if not return false
     */
    public function view($id)
    {

        // If an query is sent, the class object has been written.
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

        // If both actions fail, return false
        return false;
    }

    /**
     * The method which lists all files.
     *
     * @return bool if it's listed return true, if not return false
     */
    public function index()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->select('files')
                    ->run();
        if ($query) {
            // With the fetchAll method we pull all the values to the array.
            return array('files' => $query);
        } else {
            return false;
        }
    }

    /**
     * The method which lists all the inputs.
     *
     * @return bool if it's listed return true, if not return false
     */
    public function show()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->select('files')
                    ->run();
        if ($query) {
            // With the fetchAll method we pull all the values to the array.
            $result = array('render' => true, 'template' => 'admin', 'files' => $query);
        } else {
            $result = array('render' => true, 'template' => 'admin', 'files' => array());
        }
        return $result;
    }

    /**
     * The method which edits thhe file
     *
     * We don't want to edit the files. That's wht our method is empty.
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
     * The method which deletes the file, deletes the data.
     * This is not reversable.
     *
     * @param int $id Unique index of file
     * @return bool if deleted return true, if not return false
     */
    public function delete($id)
    {
        $oldData = $this->view($id);

        unlink('./www/images/' . $oldData['file']['filename']);

        $query = $this->db->delete('files')
                    ->where('id', $id)
                    ->done();

        return array('template' => 'admin', 'render' => false);
    }

}

?>
