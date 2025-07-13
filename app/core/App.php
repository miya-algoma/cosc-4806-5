<?php

class App {

    protected $controller = 'login';
    protected $method = 'index';
    protected $special_url = ['apply'];
    protected $params = [];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
            $this->controller = 'home';
        }

        $url = $this->parseUrl();

        if (isset($url[1])) {
            $controllerName = ucfirst(strtolower($url[1]));
            if (file_exists('app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                $_SESSION['controller'] = $this->controller;

                if (in_array(strtolower($url[1]), $this->special_url)) {
                    $this->method = 'index';
                }

                unset($url[1]);
            } else {
                header('Location: /home');
                exit;
            }
        }

        require_once 'app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        if (isset($url[2]) && method_exists($this->controller, $url[2])) {
            $this->method = $url[2];
            $_SESSION['method'] = $this->method;
            unset($url[2]);
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        $u = "{$_SERVER['REQUEST_URI']}";
        $url = explode('/', filter_var(rtrim($u, '/'), FILTER_SANITIZE_URL));
        unset($url[0]); // remove first empty element from leading slash
        return $url;
    }
}
