<?php

/**
 * Main application class for routing controllers and methods.
 */
class App {
    protected object|string $controller = 'login';
    protected string $method = 'index';
    protected array $params = [];

    /**
     * App constructor: starts session and handles routing.
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $url = $this->parseUrl();

        // Set controller
        if (isset($url[1]) && file_exists('app/controllers/' . $url[1] . '.php')) {
            $this->controller = $url[1];
            unset($url[1]);
        } elseif (!isset($_SESSION['auth'])) {
            $this->controller = 'login';
        } else {
            $this->controller = 'home';
        }

        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Set method
        if (isset($url[2]) && method_exists($this->controller, $url[2])) {
            $this->method = $url[2];
            unset($url[2]);
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parses the current request URL into an array of route segments.
     *
     * @return array<int, string> Parsed URL segments
     */
    private function parseUrl(): array {
        $u = $_SERVER['REQUEST_URI'] ?? '/';
        $url = explode('/', filter_var(rtrim($u, '/'), FILTER_SANITIZE_URL));
        unset($url[0]);
        return array_values($url);
    }
}