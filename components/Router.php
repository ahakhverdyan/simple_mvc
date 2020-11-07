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

    /**
     *  Its return controller name  action name  and params
     * @param String $internalRoute
     * @return array
     */
    private function parseSegments(String $internalRoute) {
        $segments = explode('/', $internalRoute);
        $controllerName = ucfirst(array_shift($segments)) . 'Controller';
        $action = 'action' . ucfirst(array_shift($segments));
        return [$controllerName, $action, $segments];
    }

    public function run() {

        $uri = $this->getUri();

        foreach ($this->routes as $url => $path) {
            if(preg_match("~{$url}~", $uri)) {
                // replace for $1 $2 routes
                $internalRoute = preg_replace("~{$url}~", $path, $uri);

                list($controllerName, $action, $params) = $this->parseSegments($internalRoute);

                include_once($this->getControllerClassFile($controllerName));

                $controllerObject = new $controllerName;
                $result = call_user_func_array([$controllerObject, $action], $params);

                if(!is_null($result)) {
                    break;
                }

            }
        }

    }
}