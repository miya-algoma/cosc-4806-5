<?php

class App
{
    protected $controller = 'login';   // Default controller
    protected $method = 'index';       // Default method
    protected $params = [];            // Parameters from URL

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $url = $this->parseUrl();

        // Set controller if it exists
        if (isset($url[0]) && file_exists(__DIR__ . '/../controllers/' . $url[0] . '.php')) {
            require_once __DIR__ . '/../controllers/' . $url[0] . '.php';
            $this->controller = $url[0];
            unset($url[0]);
        } else {
            // fallback
            $this->controller = isset($_SESSION['auth']) ? 'home' : 'login';
            require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        }

        // Capitalize controller class name to match class in file
        $controllerClass = ucfirst($this->controller);

        $this->controller = new $controllerClass;

        // Set method if it exists
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
