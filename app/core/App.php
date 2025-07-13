<?php

class App {

    protected $controller = 'login';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // If logged in, default to home controller
        if (isset($_SESSION['auth']['username'])) {
            $this->controller = 'home';
        }

        $url = $this->parseUrl();

        // If controller exists, use it
        if (isset($url[1]) && file_exists('app/controllers/' . strtolower($url[1]) . '.php')) {
            $this->controller = strtolower($url[1]);
            unset($url[1]);
        }

        require_once 'app/controllers/' . $this->controller . '.php';

        // Capitalize class name (e.g., home -> Home)
        $className = ucfirst($this->controller);
        $this->controller = new $className;

        // If method exists, use it
        if (isset($url[2]) && method_exists($this->controller, $url[2])) {
            $this->method = $url[2];
            unset($url[2]);
        }

        // Pass remaining URL segments as params
        $this->params = $url ? array_values($url) : [];

        // Call controller/method/params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        $u = "{$_SERVER['REQUEST_URI']}";
        $url = explode('/', filter_var(rtrim($u, '/'), FILTER_SANITIZE_URL));
        unset($url[0]); // remove leading empty element
        return $url;
    }
}
