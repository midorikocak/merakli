<?php
/**
 * The category class which administers all categories in the system.
 *
 * The class which edits, deletes, renders, lists and adds categories to
 * to the system.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;

use \PDO;

/**
 * Class Assets
 * @package Midori\Cms
 */
abstract class Assets
{

    /**
     * The variable which holds the category singular id. It prevents interference with other
     * categories.
     *
     * @var int
     */
    public $id;

    /**
     * The variable which is going to hold the database connection.
     *
     * @var PDO
     */
    protected $db = false;

    /**
     * The method which provides the connection
     *
     * @param BasicDb $db Bağlantı objesi
     * @return void
     */
    protected function getDb($db)
    {
        $this->db = $db;
    }

    /**
     * An array which holds all information in the system
     *
     * @var array
     */
    public $related;

    /**
     * The method which automatically runs after the class is initialized as an object
     * Over here, the class asks for the database class before it runs.
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * The method which reveals if the user is logged in or not in the system
     *
     * @return bool
     */
    public function checkLogin()
    {
        // We recheck if the user is logged in:
        if (!isset($_SESSION['username'])) {
            return false;
            //return array('render'=>false,'template'=>'public','message'=>'Lütfen oturum açınız!');
        } else {
            return true;
        }
    }

    /**
     * Connected
     *
     * @param PDO $db Bağlantı objesi
     * @return void
     */
    public function getRelatedData($related)
    {
        $this->related = $related;
    }

    /**
     * The method which adds categories, saves the data.
     *
     * @param string $title Category title
     * @param string $content Category content
     * @param int $category_id The category categories unique identity
     * @return bool if added true, if not returns false
     */
    abstract public function add();

    /**
     * We are going to show all inputs in a single category
     *
     * @param int $id Unique index of category
     * @return array if it renders properly return array data, if not return false
     */
    abstract public function view($id);

    /**
     * The method which lists all inputs.
     *
     * @return bool if it's listed return true, if not return false
     */
    abstract public function show();

    /**
     * The method which lists all categories.
     *
     * @return bool if it's listed return true, if not return false
     */
    abstract public function index();


    /**
     * The method which updates categories. With the given id and information it
     * changes and updates the information in the system.
     *
     * @param int $id Unique index of category
     * @return bool if changed return true, if not return false
     */
    abstract public function edit();


    /**
     * The method which deleted categories, helps removing data.
     * This is not reversable.
     *
     * @param int $id Unique index of category
     * @return bool if deleted return true, if not return false
     */
    abstract public function delete($id);

}

?>
