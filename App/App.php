<?php
/**
* The class that starts our application.
*
* Works as dependency injector.
 * TODO Have to check solid principle violations.
 * TODO Have to convert the class to static and use registry pattern for instantiated classes
*
* @author   Midori Kocak <mtkocak@mtkocak.net>
*/
namespace Midori\Cms;

use Midori\Cms;
use erbilen;

/**
 * Class App
 * 
 * @package Midori\Cms
 *         
 */
class App
{

    /**
     * The variable that holds database connection.
     *
     * @var PDO
     */
    private $db = false;

    /**
     * Holds application wide settings
     *
     * @var mixed
     */
    protected $settings = false;

    /**
     * Holds request params, coming from uri.
     *
     * @var mixed
     */
    private $params = array();

    /**
     * Extracted params for request generation
     *
     * @var array
     */
    private $request;

    /**
     * The data that comes from forms or classes
     *
     * @var mixed
     */
    private $data = null;


    /**
     * Function that starts application using config vars
     *
     * @param $config
     * @return void
     */
    public function __construct($config)
    {
        $this->startSession();
        $this->getRequests();
        $this->startDB($config);
        
        // /posts/add gibi bir request geldi.
        $this->params = explode("/", $this->request);
        
        $params = $this->params;
        
        $className = __NAMESPACE__ . '\\' . $this->params[1];
        $extension = explode('.', end($this->params));
        
        $class = new $className($this->db);
        $class->getRelatedData($this->getCategories());
        
        if (! isset($params[2]) || ! $params[2]) {
            $this->params[2] = 'index';
        } else {
            if (isset($params[3])) {
                $this->data = $class->$params[2]($params[3]);
            } else {
                $this->data = $class->$params[2]();
            }
        }
        
        if (empty($this->data)) {
            $this->data = $class->index();
        }
        
        try {
            $this->startDB($config);
        } catch (Exception $e) {
            if ($e->getCode() == 1049) {
                $this->startDatabaseInstaller();
            }
        }
        
        if ($this->getUsers() == false) {
            $this->startUserInstaller();
        } elseif (! $this->getSettings()) {
            $this->startSettingInstaller();
        } else {
            $this->startCategoryAndPostInstaller($this->request, $this->data);
        }
    }

    /**
     * Instantiates database connection
     * TODO has to be static.
     *
     * @param $config
     * @return void
     */
    public function startDB($config)
    {
        $db = new erbilen\BasicDB($config['db']['host'], $config['db']['dbname'], $config['db']['username'], $config['db']['password']);
        $this->getDb($db);
    }

    /**
     * Session starter function for the whole app
     *
     * @return void
     */
    public function startSession()
    {
        $sess_name = session_name();
        if (session_start()) {
            setcookie($sess_name, session_id(), null, '/', null, null, true);
        }
    }

    /**
     * If the application has no user registered, visitor is forced to create an user.
     *
     */
    public function startUserInstaller()
    {
        if (! isset($_POST['user'])) {
            echo $this->installUser();
        } else {
            if (isset($_POST['user']['username']) && preg_match('/^\w{5,}$/', $_POST['user']['username']) && filter_var($_POST['user']['email'], FILTER_VALIDATE_EMAIL)) {
                $_POST['user']['username'] = filter_var($_POST['user']['username'], FILTER_SANITIZE_MAGIC_QUOTES);
                
                if (isset($_POST['user']['password1']) && isset($_POST['user']['password2']) && ($_POST['user']['password1'] == $_POST['user']['password2'])) {
                    echo $this->installUser($_POST['user']);
                } else {
                    echo $this->installUser();
                }
            } else {
                echo $this->installUser();
            }
        }
    }

    /**
     * If the application has no settings created, visitor is forced to create the setting.
     *
     */
    public function startSettingInstaller()
    {
        if (isset($_POST['setting'])) {
            echo $this->installSettings($_POST['setting']);
        } else {
            echo $this->installSettings();
        }
    }

    /**
     * If the application has no post or category created, user is forced to create one, after login.
     *
     * @param $request
     * @param $data
     */
    public function startCategoryAndPostInstaller($request, $data)
    {
        $noCategories = $this->getCategories() == null;
        $noPosts = $this->getPosts() == null;
        if ($noCategories || $noPosts) {
            if (isset($_SESSION['id']) || (isset($_POST['username']) && isset($_POST['password']))) {
                if ((isset($_SESSION['id']) || $this->login($_POST) != false)) {
                    if ($noCategories && mb_strtolower($_SERVER['REQUEST_URI']) != '/' . $directoryName . '/categories/add' && mb_strtolower($_SERVER['REQUEST_URI']) != '/' . DIRECTORY_NAME . '/users/logout') {
                        header('Location:' . LINK_PREFIX . '/categories/add');
                    }
                    echo $this->calculate($this->request, $this->data);
                }
            } else {
                echo $this->login();
            }
        } else {
            echo $this->calculate($this->request, $this->data);
        }
    }

    /**
     * Requests are handled by this method
     *
     * @return void
     */
    public function getRequests()
    {
        if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) !== false) {
            $request = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']);
        } else {
            $requests = explode('/', $_SERVER['REQUEST_URI']);
            
            if ($requests[1] == DIRECTORY_NAME) {
                unset($requests[1]);
                
                $request = implode('/', $requests);
                
                if ($request == "/") {
                    $request .= "posts";
                }
            }
        }
        if (! empty($_POST)) {
            $this->data = $_POST;
        } elseif (! empty($_FILES)) {
            $this->data = $_FILES;
        } else {
            $this->data = "";
        }
        if (empty($request)) {
            $this->request = "/Posts/";
        }
        $this->request = $request;
    }

    /**
     * Method starts database connection
     *
     * @param BasicDBObject $dbConnection
     * @return BasicDB object or False.
     */
    public function getDb($dbConnection)
    {
        if (! $dbConnection) {
            return false;
        } else {
            $this->db = $dbConnection;
            return $this->db;
        }
    }

    /**
     * Categories are shown everywhere. So we need to get them to an array.
     *
     * @return array
     */
    public function getCategories()
    {
        $categories = new Categories($this->db);
        return $categories->index();
    }

    /**
     * We need to check posts to redirect user to create some posts if there are not.
     *
     * @return array
     */
    public function getPosts()
    {
        $posts = new Posts($this->db);
        return $posts->index();
    }

    /**
     * Renders login form if authorized user actions are needed
     *
     * @param null $data
     */
    public function login($data = null)
    {
        $users = new Users($this->db);
        if ($data != null) {
            return $users->login($data['username'], $data['password']);
        } else {
            echo $this->render('./View/Install/login.php', '');
        }
    }

    /**
     * Basic settings are also needed everywhere.
     *
     * @return bool.
     */
    public function getSettings()
    {
        $settings = new Settings($this->db);
        $setting = $settings->view();
        $this->settings = $setting['setting'];
        if ($this->settings != null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Database creation form is handled here.
     *
     * @return void
     */
    public function startDatabaseInstaller()
    {
        if (isset($_POST['db']['host'])) {
            $_POST['db']['host'] = filter_var(gethostbyname($_POST['db']['host']), FILTER_VALIDATE_IP);
        }
        
        if (isset($_POST['db']['dbname']) && preg_match('/^\w{5,}$/', $_POST['db']['dbname'])) {
            $_POST['db']['dbname'] = filter_var($_POST['db']['dbname'], FILTER_SANITIZE_MAGIC_QUOTES);
        }
        
        if (isset($_POST['db']['username']) && preg_match('/^\w{5,}$/', $_POST['db']['username'])) {
            $_POST['db']['username'] = filter_var($_POST['db']['username'], FILTER_SANITIZE_MAGIC_QUOTES);
        }
        
        if (isset($_POST['db']['password'])) {
            $_POST['db']['password'] = filter_var($_POST['db']['password'], FILTER_SANITIZE_MAGIC_QUOTES);
        }
        if (isset($_POST['db'])) {
            $config['db'] = $_POST['db'];
            echo $this->installDatabase($config);
        } else {
            echo $this->installDatabase();
        }
    }

    /**
     * Form to create setting is rendered and created.
     *
     * @param null $settings
     */
    public function installSettings($settings = null)
    {
        if ($settings == null) {
            return $this->render('./View/Install/settings.php', '');
        } else {
            $insert = $this->db->insert('settings')->set(array(
                'title' => $settings['title'],
                'description' => $settings['description'],
                'copyright' => $settings['copyright']
            ));
            
            if ($insert) {
                header('Location:' . LINK_PREFIX);
            } else {
                return $this->render('./View/Install/setting.php', '');
            }
        }
    }

    /**
     * Method to check system has any registered user
     *
     * @return bool
     */
    public function getUsers()
    {
        $user = $this->db->select('users')->run();
        if (! $user) {
            return false;
        }
        return true;
    }

    /**
     * Method for installing database config to config.php
     *
     * @param null $config
     */
    public function installDatabase($config = null)
    {
        $comments = "";
        $tokens = token_get_all(file_get_contents('./Config/config.inc.php'));
        foreach ($tokens as $token) {
            if ($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
                $comments .= $token[1] . "\n";
            }
        }
        
        if ($config != null) {
            file_put_contents('./Config/config.inc.php', '<?php' . "\n" . $comments . "\n" . '$config = ' . var_export($config, true) . ';');
            header('Location:' . LINK_PREFIX);
        } else {
            return $this->render('./View/Install/database.php', '');
        }
    }

    /**
     * Handles user registration form.
     *
     * @param null $userInfo
     */
    public function installUser($userInfo = null)
    {
        if ($userInfo == null) {
            return $this->render('./View/Install/user.php', '');
        } else {
            $insert = $this->db->insert('users')->set(array(
                "username" => $userInfo['username'],
                "password" => md5($userInfo['password1']),
                "email" => $userInfo['email']
            ));
            
            if ($insert) {
                header('Location:' . LINK_PREFIX);
            } else {
                return $this->render('./View/Install/user.php', '');
            }
        }
    }

    /**
     * Renders requests and handles data from visitor.
     * @return void
     */
    public function calculate()
    {
        echo new Router($this->data, $this->getCategories(), $this->settings, $this->params);
    }

    /**
     * Renders file and variables
     *
     * @param $file
     * @param $vars
     */
    public function render($file, $vars)
    {
        $renderer = new Router();
        echo $renderer->render($file, $vars);
        
    }


}


?>
