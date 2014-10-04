<?php
/**
 * The category class which will administer all categories in the system.
 *
 * The class which edits, deletes, renders, lists and adds categories to the system.
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
     * Category title
     *
     * @var string
     */
    public $title;

    /**
     * The method which adds a category, saves the data.
     *
     * @param string $title Category title
     * @param string $content Category content
     * @param int $category_id The category categories unique identity
     * @return bool if added return true, if not return false
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
                // If the database action is successful, let's change the variables belonging to the class object
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
     * We are going to show all inputs in a single category
     *
     * @param int $id Unique index of category
     * @return array if it renders properly return array data, if not return false
     */
    public function view($id)
    {
        // If an query is sent, the class object has been written.
        if ($id == $this->id) {
            return array("id" => $this->id, "title" => $this->title);
        } else {
            // From here we can understand that the data isn't pulled yet. Let's start pulling the data

            $query = $this->db->select('categories')
                        ->where('id', $id)
                        ->run();

            if ($query) {
                $category = $query[0];

                $this->id = $category['id'];
                $this->title = $category['title'];

                // We're going to make a new query and recieve all inputs of the given category.
                // From here we can understand that the data isn't pulled yet. Let's start pulling the data

                $postQuery = $this->db->select('posts')
                            ->where('category_id', $id)
                            ->run();

                if ($postQuery) {
                    $categoryPosts = $postQuery;

                    // We're going to make a new query and recieve all inputs of the given category.

                }
                else{
                    $categoryPosts=array();
                }
                $result = array('posts' => $categoryPosts, 'render' => true, 'template' => 'public', 'category' => $category);
                return $result;
            }
        }

        // If both actions fail, return false
        return false;
    }

    /**
     * The method which lists all the inputs.
     *
     * @return bool if it lists return true, if not return false
     */
    public function show()
    {
        if (!$this->checkLogin()) {
            return false;
        }

        $query = $this->db->select('categories')
                    ->run();

        if ($query) {
            // With the fetchAll method we pull all the values to the array.
            $result = array('render' => true, 'template' => 'admin', 'categories' => $query);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * The method which lists all the categories.
     *
     * @return bool if it lists return true, if not return false
     */
    public function index()
    {
        $query = $this->db->select('categories')
                    ->run();
        if ($query) {
            // With the fetchAll method we pull all the values to the array.
            $categories = $query;
            $result = array('categories' => $categories, 'render' => false, 'template' => 'public');
            return $result;
        } else {
            return false;
        }
    }


    /**
     * The method which updates categories. With the given id and information it
     * changes and updates the information in the system.
     *
     * @param int $id Kategorinin benzersiz index'i Unique index of category
     * @return bool if updated return true, if not return false
     */
    public function edit($id = null, $title = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        if ($title != null) {
            // Let's first prepare our database query.

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
     * The method which deleted the category, deleted the data.
     * This is not reversable.
     *
     * @param int $id Unique index of category
     * @return bool if deleted return true, if not return false
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
