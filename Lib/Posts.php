<?php
/**
 * The class which administers all inputs in the system.
 *
 * The class which edits, deletes, renders, lists and adds inputs in the system.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;

use \PDO;

class Posts extends Assets
{


    /**
     * Input title
     *
     * @var string
     */
    public $title;

    /**
     * Input content
     *
     * @var string
     */
    public $content;

    /**
     * Unique category identity of the input
     *
     * @var int
     */
    public $category_id;


    /**
     * The variable which reveals the creation date of the input
     *
     * @var string
     */
    private $created;

    /**
     * The variable which reveals the update date of the input
     *
     * @var string
     */
    private $updated;

    /**
     * The helper method which return the current date
     *
     * @return string returns the date in mysql format
     */
    public function getDate()
    {
        date_default_timezone_set('Europe/Istanbul');
        $currentDate = date("Y-m-d H:i:s");

        return $currentDate;
    }

    /**
     * The method which add inputs, saves the data.
     *
     * @param string $title Input title
     * @param string $content Input content
     * @param int $category_id Unique identity of input category
     * @return bool if added return true, if not return false
     */
    public function add($title = null, $content = null, $category_id = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        if ($title != null) {
            // We don't manually add field which contain dates. We have functions which directly ask the system.
            $date = $this->getDate();

            // insert
            $insert = $this->db->insert('posts')
                        ->set(array(
                            "title" => $title,
                            "content" => $content,
                            "category_id" => $category_id,
                            "created" => $date,
                            "updated" => $date
                        ));

            if ($insert) {
                // If the database action is successful, let's change the variables belonging to the class object
                $this->id = $this->db->lastInsertId();
                $this->title = $title;
                $this->content = $content;
                $this->created = $date;
                $this->updated = $date;
                $this->category_id = $category_id;

                return true;
            } else {
                return false;
            }


        } else {
            $files = $this->db->select('files')
                ->run();
            if(empty($files)){
                $files = array();
            }
            return array('render' => true, 'template' => 'admin', 'files'=>$files ,'categories' => $this->related['categories']);
        }
    }

    /**
     * The method which renders a single input
     *
     * @param int $id Girdinin benzersiz index'i Unique index of the input
     * @return array if it renders properly return array data, if not return false
     */
    public function view($id)
    {

        //  If an query is sent, the class object has been written.
        if ($id == $this->id) {
            return array("id" => $this->id, "title" => $this->title, "content" => $this->content, "category_id" => $this->category_id, "created" => $this->created, "updated" => $this->updated);
        } else {
            // From here we understand that data is pulled yet. Let's start pulling the data
            $query = $this->db->select('posts')
                ->where('id',$id)
                    ->run();
            if ($query) {
                $post = $query[0];

                $this->id = $post['id'];
                $this->title = $post['title'];
                $this->content = $post['content'];
                $this->created = $post['created'];
                $this->updated = $post['updated'];
                $this->category_id = $post['updated'];

                $result = array('template' => 'public', 'post' => $post, 'render' => true);

                return $result;
            }
        }

        // If both actions fail, return false
        return false;
    }

    /**
     * The method which lists all inputs.
     *
     * @return bool if it lists return true, if not return false
     */
    public function index()
    {
        $query = $this->db->select('posts')
                ->run();

        if ($query) {
            // With the fetchAll method we pull all the values to the array.
            $result = array('render' => true, 'template' => 'public', 'posts' => $query);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * The method which lists all inputs.
     *
     * @return bool if it lists return true, if not return false
     */
    public function show()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->select('posts')
                ->run();
        if ($query) {
            // With the fetchAll method we pull all the values to the array.
            $result = array('render' => true, 'template' => 'admin', 'posts' => $query);
            return $result;
        } else {
            return false;
        }
    }


    /**
     * The method which edits the input. With the given id and information it edits
     * the information in the system.
     *
     * @param int $id Unique index of input
     * @return bool if edited return true, if not return false
     */
    public function edit($id = null, $title = null, $content = null, $category_id = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        if ($title != null) {

            // We don't manually add field which contain dates. We have functions which directly ask the system.
            $date = $this->getDate();

            $update = $this->db->update('posts')
                        ->where('id', $id)
                        ->set(array(
                            "title" => $title,
                            "content" => $content,
                            "category_id" => $category_id,
                            "updated" => $date,
                            "id" => $id
                        ));

            if ($update) {
                return true;
            } else {
                return false;
            }

        } else {
            $oldData = $this->view($id);
            return array('template' => 'admin', 'render' => true, 'categories' => $this->related['categories'], 'post' => $oldData['post']);
        }
    }

    /**
     * The method which deleted inputs, deletes the data.
     * This is not reversable.
     *
     * @param int $id Unique if of input
     * @return bool if deleted return true, if not return false
     */
    public function delete($id)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->delete('posts')
                    ->where('id', $id)
                    ->done();
        return array('template' => 'admin', 'render' => false);
    }

}

?>
