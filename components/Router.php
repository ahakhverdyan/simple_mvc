<?php

/**
 * Class Router
 *
 * @property [] $routes
 */
class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include(ROOT . '/configs/routes.php');
    }

    /**
     * @return string
     */
    private function getUri() {
        if(!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        
        return '';
    }

    /**
     * @param string $controllerName
     * @return string
     * @throws Exception
     */
    private function getControllerClassFile($controllerName) {
        $path =  ROOT . '/controllers/' . $controllerName . '.php';

        if(file_exists($path)) {
            return $path;
        }

        throw new Exception($path . ' dont exists. PLease check');
    }

    public function run() {

        $uri = $this->getUri();

        foreach ($this->routes as $url => $path) {
            if(preg_match("~{$url}~", $uri)) {

                $segments = explode('/', $path);
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $action = 'action' . ucfirst(array_shift($segments));

                include_once($this->getControllerClassFile($controllerName));

                $controllerObject = new $controllerName;
                $result = $controllerObject->{$action}();

                if(!is_null($result)) {
                    break;
                }

            }
        }

    }
}