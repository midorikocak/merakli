<?php

namespace Midori\Cms;


class Router  
{
    private $data = array();
    private $message = null;
    private $template = 'public';
    private $renderFile = 'show';
    private $render = false;
    private $related = null;
    private $settings = null;
    private $params = null;
    
    private $result = null;
    
    public function __construct($classData=null,$related=null,$settings=null,$params=null){
        
        if(isset($classData['template'])){
            $this->template = $classData['template'];
        }
        
        if(isset($classData['renderFile'])){
            $this->renderFile = $classData['renderFile'];
        }
        
        if(isset($classData['message'])){
            $this->message = $classData['message'];
        }
        
        if(isset($classData['render'])){
            $this->render = $classData['render'];
        }
        
        if($related!=null)
        {
            $this->related=$related;
        }
        
        if($settings!=null)
        {
            $this->settings=$settings;
        }
        
        if($classData!=null)
        {
            $this->data=$classData;
        }
        
        if($params!=null)
        {
            $this->params=$params;
        }
    }
    
    public function __toString(){
        $content = $this->createContent();
        return $this->wrapTemplate($content);
    }
    
    
    private function createContent(){
        $content = array('message' => $this->message, 'related' => $this->related, 'content' => $this->render('./View/' . $this->params[1] . '/' . mb_strtolower($this->params[2]) . '.php', $this->data));
        return $content;
    }
    
    private function wrapTemplate($content){
        return $this->render('./www/' . $this->template . '.php', $content);
    }
    
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

