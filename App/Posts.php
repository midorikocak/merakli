<?php
/**
 * Class that manages posts in the content management system
 *
 * Basic CRUD operations and a date helper
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */
namespace Midori\Cms;

class Posts extends Assets
{

    /**
     * Helper method that returns current date
     *
     * @return string in mysql format
     */
    public function getDate()
    {
        date_default_timezone_set('Europe/Istanbul');
        $currentDate = date("Y-m-d H:i:s");

        return $currentDate;
    }

    /**
     * Adds a new post to database
     *
     * @param string $title
     * @param string $content
     * @param int $category_id
     * @return mixed
     */
    public function add($title = null, $content = null, $category_id = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        if ($title != null) {
            $date = $this->getDate();

            $insert = $this->db->insert('posts')->set(array(
                "title" => $title,
                "content" => $content,
                "category_id" => $category_id,
                "created" => $date,
                "updated" => $date
            ));

            if ($insert) {
                return true;
            } else {
                return false;
            }
        } else {
            $files = $this->db->select('files')->run();
            if (empty($files)) {
                $files = array();
            }
            return array(
                'render' => true,
                'template' => 'admin',
                'files' => $files,
                'categories' => $this->related['categories']
            );
        }
    }

    /**
     * Show a post in public and admin context
     *
     * @param int $id
     * @return array
     */
    public function view($id)
    {
        $query = $this->db->select('posts')
            ->where('id', $id)
            ->run();

        if ($query) {
            $post = $query[0];

            $result = array(
                'template' => 'public',
                'post' => $post,
                'render' => true
            );

            return $result;
        }
        $result = array(
            'template' => 'public',
            'post' => array(),
            'render' => true
        );

        return $result;
    }

    /**
     * List all posts in public context
     *
     * @return array
     */
    public function index()
    {
        $query = $this->db->select('posts')->run();

        if ($query) {
            $result = array(
                'render' => true,
                'template' => 'public',
                'posts' => $query
            );
            return $result;
        } else {
            $result = array(
                'render' => true,
                'template' => 'public',
                'posts' => array()
            );
            return $result;
        }
    }

    /**
     * List all posts in admin context.
     * If not logged in, returns false;
     *
     * @return mixed
     */
    public function show()
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->select('posts')->run();
        if ($query) {
            $result = array(
                'render' => true,
                'template' => 'admin',
                'posts' => $query
            );
            return $result;
        } else {
            return array(
                'render' => true,
                'template' => 'admin',
                'posts' => array()
            );
        }
    }

    /**
     * Edit the post by it's unique id.
     *
     * @param null $id
     * @param null $title
     * @param null $content
     * @param null $category_id
     * @return array|bool
     */
    public function edit($id = null, $title = null, $content = null, $category_id = null)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        if ($title != null) {

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
            return array(
                'template' => 'admin',
                'render' => true,
                'categories' => $this->related['categories'],
                'post' => $oldData['post']
            );
        }
    }

    /**
     * Delete method by id
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->delete('posts')
            ->where('id', $id)
            ->done();
        return array(
            'template' => 'admin',
            'render' => false
        );
    }
}

?>

