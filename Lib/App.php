<?php
/**
 * The class which is going to run our application
 *
 * The class which holds database and other information which is used in all classes in the system.
 *
 * @author   Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;

use Midori\Cms;
use \PDO;

/**
 * Class App
 * @package Midori\Cms
 */
class App
{

    /**
     * The variable which holds the database connection.
     *
     * @var PDO
     */
    private $db = false;

    /**
     * The variable which pulls the system settings.
     *
     * @var array
     */
    private $settings = false;


    /**
     * The contruct method which helps connect to the database
     *
     * @param BasicDBObject $dbConnection Database actions list
     * @return BasicDB object or False.
     */
    public function getDb($dbConnection)
    {
        if(!$dbConnection){
            return false;
        }
        else
        {
            $this->db = $dbConnection;
            return $this->db;
        }
    }

    /**
     * Nesnelere bağlı olan bilgileri çektiğimiz metod
     *
     * @return array
     */
    public function injectRelatedData()
    {
        $categories = new Categories($this->db);
        return $categories->index();
    }

    /**
     * The method which we pull all settings for the whole site
     *
     * @return array
     */
    public function getSettings()
    {
        $settings = new Settings($this->db);
        $setting = $settings->view();
        $this->settings = $setting['setting'];
    }

    /**
     * The method which processes all view calculations in the system
     *
     * @param $request
     * @param $data
     * @return string
     */
    public function calculate($request, $data)
    {
        // a request like /posts/add is requested.
        $params = split("/", $request);
        $className = __NAMESPACE__ . '\\' . $params[1];
        $extension =  explode('.',end($params));

        //call_user_func_array
        $class = new $className($this->db);
        $class->getRelatedData($this->injectRelatedData());

        // We have to completely change this class. It has to check if the user is
        // logged in, if so it should render the view based on the session information.
        // Messages were flying it's fixed now

        if (empty($data)) {
            if ($params[2] != null) {
                if (isset($params[3])) {
                    $data = $class->$params[2]($params[3]);
                } else {
                    $data = $class->$params[2]();
                }
                if (isset($data['message'])) {
                    $message = $data['message'];
                } else {
                    $message = null;
                }

                if (isset($data['renderFile'])) {
                    $params[2] = $data['renderFile'];
                    $renderFile = $data['renderFile'];
                } else {
                    $renderFile = 'show';
                }

                if (isset($data['render']) && $data['render'] != false) {
                    $content = array('message' => $message, 'related' => $this->injectRelatedData(), 'content' => $this->render('./View/' . $params[1] . '/' . mb_strtolower($params[2]) . '.php', $data));
                    return $this->render('./www/' . $data['template'] . '.php', $content);
                } else {
                    if (isset($data['message'])) {
                        $message = $data['message'];
                    } else {
                        $message = null;
                    }
                    if ($class->show() != false) {
                        // render the login page
                        $data = $class->show();
                        $content = array('message' => $message, 'related' => $this->injectRelatedData(), 'content' => $this->render('./View/' . $params[1] . '/' . $renderFile . '.php', $data));
                        return $this->render('./www/' . $data['template'] . '.php', $content);
                    } else {
                        $content = array('message' => $message, 'related' => $this->injectRelatedData(), 'content' => $this->render('./View/Users/login.php', $data));
                        return $this->render('./www/public.php', $content);
                    }
                }
            } else {


                $data = $class->index();

                if (isset($data['renderFile'])) {
                    $params[2] = $data['renderFile'];
                    $renderFile = $data['renderFile'];
                } else {
                    $renderFile = 'index';
                }


                if (isset($data['message'])) {
                    $message = $data['message'];
                } else {
                    $message = null;
                }
                $content = array('message' => $message, 'related' => $this->injectRelatedData(), 'content' => $this->render('./View/' . $params[1] . '/' . $renderFile . '.php', $data));
                return $this->render('./www/' . $data['template'] . '.php', $content);
            }
        } else {
            $data = call_user_func_array(array($class, $params[2]), $data);

            if (isset($data['renderFile'])) {
                $params[2] = $data['renderFile'];
                $renderFile = $data['renderFile'];
            } else {
                $renderFile = 'show';
            }

            if (isset($data['message'])) {
                $message = $data['message'];
            } else {
                $message = null;
            }

            if ($class->show() != false) {
                // render the login page
                $data = $class->show();
                $content = array('message' => $message, 'related' => $this->injectRelatedData(), 'content' => $this->render('./View/' . $params[1] . '/' . $renderFile . '.php', $data));
            } else {
                $content = array('message' => $message, 'related' => $this->injectRelatedData(), 'content' => $this->render('./View/Users/login.php', $data));
            }
            return $this->render('./www/' . $data['template'] . '.php', $content);
        }
    }

    /**
     * The method which reveals the theme files with the necessary variables
     *
     * @param $file
     * @param $vars
     * @return string
     */
    public function render($file, $vars)
    {
        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }

        if ($this->settings != false && !isset($title)) {
            extract($this->settings);
        }

        ob_start();
        include $file;
        return ob_get_clean();
    }

}


?>
