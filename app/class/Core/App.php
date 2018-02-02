<?php

class App
{
    protected $currentController = 'HomeController';
    protected $currentMethod     = 'index';
    protected $params            = [];

    public function __construct()
    {
        $url = $this->getUrl();
        if(file_exists(APP_ROOT.DS.'class'.DS.'Controller'.DS.ucwords($url[0]).'Controller.php')){
            $this->currentController = ucwords($url[0]).'Controller';
            unset($url[0]);
        }
        $fullControllerName = 'ContactForm\\Controller\\'.$this->currentController;
        $this->currentController = new $fullControllerName();
        if(isset($url[1]) && (method_exists($this->currentController, $url[1]))){
            $this->currentMethod = $url[1];
            unset($url[1]);
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}