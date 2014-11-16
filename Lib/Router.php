<?php
/**
 * Router class that gets requests from app and render a response.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;


/**
 * Class Router
 * @package Midori\Cms
 */
class Router
{
    /**
     * Data generated from request
     *
     * @var array|null
     */
    private $data = array();

    /**
     * Flash messages
     *
     * @var null
     */
    private $message = null;

    /**
     * If isset, template file is rendered for layout. public|admin
     *
     * @var string
     */
    private $template = 'public';

    /**
     * If isset, an action can render a custom view file than it's default show|index|add|edit
     *
     * @var string
     */
    private $renderFile = 'show';

    /**
     * If false response is not rendered, else default render file for action is rendered
     *
     * @var bool
     */
    private $render = false;

    /**
     * Related data is saved here. For now, application wide categories are hold here.
     * TODO Static
     *
     * @var null
     */
    private $related = null;

    /**
     * Application wide settings are here.
     * TODO Static
     *
     * @var null
     */
    private $settings = null;

    /**
     * Request parameters
     *
     * @var null
     */
    private $params = null;

    /**
     * Constructor that gets data from App class. Class, post and other data already injected here.
     *
     * @param null $classData
     * @param null $related
     * @param null $settings
     * @param null $params
     */
    public function __construct($classData = null, $related = null, $settings = null, $params = null)
    {

        if (isset($classData['template'])) {
            $this->template = $classData['template'];
        }

        if (isset($classData['renderFile'])) {
            $this->renderFile = $classData['renderFile'];
        }

        if (isset($classData['message'])) {
            $this->message = $classData['message'];
        }

        if (isset($classData['render'])) {
            $this->render = $classData['render'];
        }

        if ($related != null) {
            $this->related = $related;
        }

        if ($settings != null) {
            $this->settings = $settings;
        }

        if ($classData != null) {
            $this->data = $classData;
        }

        if ($params != null) {
            $this->params = $params;
        }
    }

    /**
     * Class is printed at App class. When class is printed, this function is called magically.
     *
     * @return string
     */
    public function __toString()
    {
        $content = $this->createContent();
        return $this->wrapTemplate($content);
    }


    /**
     * Class actions rendered here together all variables.
     *
     * @return array
     */
    private function createContent()
    {
        $content = array('message' => $this->message, 'related' => $this->related, 'content' => $this->render('./View/' . $this->params[1] . '/' . mb_strtolower($this->params[2]) . '.php', $this->data));
        return $content;
    }

    /**
     * All render operations are handled here. Output buffer and include.
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

    /**
     * Context template is rendered and wrapped to class actions.
     *
     * @param $content
     * @return string
     */
    private function wrapTemplate($content)
    {
        return $this->render('./www/' . $this->template . '.php', $content);
    }

}

?>

