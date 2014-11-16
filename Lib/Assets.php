<?php
/**
 * Abstract class that defines methods for assets CRUD operations
 *
 * Basic CRUD and login methods
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */
namespace Midori\Cms;

use erbilen\BasicDB;

/**
 * Class Assets
 *
 * @package Midori\Cms
 */
abstract class Assets
{

    /**
     * Array holds related data.
     * TODO Categories for now.
     *
     * @var array
     */
    public $related;

    /**
     * Variable holds database connection
     *
     * @var BasicDB
     */
    protected $db = false;

    /**
     * Constructor that instantiates class.
     * Here database connection is added to protected variable database $db.
     *
     * @param
     *            $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Method that shows if user logged in or not.
     *
     * @return bool.
     */
    public function checkLogin()
    {
        // We control session here.
        if (! isset($_SESSION['username'])) {
            return false;
            // return array('render'=>false,'template'=>'public','message'=>'Please login!');
        } else {
            return true;
        }
    }

    /**
     * Get related data.
     * Categories for now.
     *
     * @param array $related            
     */
    public function getRelatedData($related)
    {
        $this->related = $related;
    }

    /**
     * Method for adding data.
     * Basic CRUD operations. (Create)
     */
    abstract public function add();

    /**
     * Method for viewing data.
     * Basic CRUD operations. (Read)
     *
     * @param int $id            
     * @return array
     */
    abstract public function view($id);

    /**
     * Method for listing all data in admin context.
     * Basic CRUD operations. (Read)
     *
     * @return array
     */
    abstract public function show();

    /**
     * Method for listing all data in public context.
     * Basic CRUD operations. (Read)
     *
     * @return array
     */
    abstract public function index();

    /**
     * Method for editing data.
     * Basic CRUD operations. (Update)
     *
     * @param int $id            
     * @return bool|array
     */
    abstract public function edit($id);

    /**
     * Method for deleting data.
     * Basic CRUD operations. (Delete)
     *
     * @param int $id            
     * @return bool|array
     */
    abstract public function delete($id);

    /**
     * Method sets database connection
     *
     * @param BasicDb $db
     *            Connection object
     */
    protected function getDb($db)
    {
        $this->db = $db;
    }
}

?>

