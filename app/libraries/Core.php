<?php
/* 
App Core Class
Creates URL & loads core controller
URL format: /controller/method/params 
 */
class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        //   Looks in the returned $url array for the first index -> the controller

        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // If exits, set as controller
            $this->currentController = ucwords($url[0]);
            // Unset 0 index
            unset($url[0]);
        }

        // require the controller
        require_once "../app/controllers/{$this->currentController}.php";

        // instantiate controller class
        $this->currentController = new $this->currentController();

        // Checks for second value of $url array
        if (isset($url[1])) {
            // checks to see if method exists in the controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // unset second index of array $url[1]
                unset($url[1]);
            }
        }

        // get the params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with an array of parameters
        call_user_func_array(
            [$this->currentController, $this->currentMethod],
            $this->params
        );
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
?>
