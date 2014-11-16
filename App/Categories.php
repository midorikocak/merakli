<?php
/**
 * The class who manages categories in the application
 *
 * Basic CRUD operations using PDO class. Extends Assets abstract class.
 * The only difference at crud is that when category is requested with id, related posts are
 * retrieved.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */
namespace Midori\Cms;

/**
 * Class Categories
 * 
 * @package Midori\Cms
 */
class Categories extends Assets
{

    /**
     * Method to add a category
     *
     * @param string $title
     *            Category Title
     * @return mixed
     */
    public function add($title = null)
    {
        if (! $this->checkLogin()) {
            return false;
        }
        
        if ($title != null) {
            
            // insert
            $insert = $this->db->insert('categories')->set(array(
                'title' => $title
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
     * Get all categories as an array
     *
     * @return array
     */
    public function show()
    {
        if (! $this->checkLogin()) {
            return false;
        }
        
        $query = $this->db->select('categories')->run();
        
        if ($query) {
            $result = array(
                'render' => true,
                'template' => 'admin',
                'categories' => $query
            );
            return $result;
        } else {
            return array(
                'render' => true,
                'template' => 'admin',
                'categories' => array()
            );
        }
    }

    /**
     * Method to list all categories in a public view
     *
     * @return array
     */
    public function index()
    {
        $query = $this->db->select('categories')->run();
        if ($query) {
            $categories = $query;
            $result = array(
                'categories' => $categories,
                'render' => false,
                'template' => 'public'
            );
            return $result;
        } else {
            return array(
                'categories' => array(),
                'render' => false,
                'template' => 'public'
            );
        }
    }

    /**
     * Method to edit categories using unique id of the category.
     *
     * @param int $id
     *            Unique index of the category
     * @param string $title
     *            Title of the category
     * @return mixed
     */
    public function edit($id = null, $title = null)
    {
        if (! $this->checkLogin()) {
            return false;
        }
        if ($title != null) {
            
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
            return array(
                'template' => 'admin',
                'render' => true,
                'category' => $oldData['category']
            );
        }
    }

    /**
     * Show posts in a category
     *
     * @param int $id
     *            Category id
     * @return array
     */
    public function view($id)
    {
        $query = $this->db->select('categories')
            ->where('id', $id)
            ->run();
        
        if ($query) {
            $category = $query[0];
            
            $postQuery = $this->db->select('posts')
                ->where('category_id', $id)
                ->run();
            
            if ($postQuery) {
                $categoryPosts = $postQuery;
            } else {
                $categoryPosts = array();
            }
            $result = array(
                'posts' => $categoryPosts,
                'render' => true,
                'template' => 'public',
                'category' => $category
            );
            return $result;
        }
        
        return array(
            'posts' => array(),
            'render' => true,
            'template' => 'public',
            'category' => array()
        );
    }

    /**
     * Method that delete categories.
     *
     * TODO Has to have an "are you sure?" prompt
     *
     * @param int $id
     *            unique index of the category
     * @return mixed
     */
    public function delete($id)
    {
        if (! $this->checkLogin()) {
            return false;
        }
        
        $query = $this->db->delete('categories')
            ->where('id', $id)
            ->done();
        
        return array(
            'template' => 'admin',
            'render' => false
        );
    }
}

?>

