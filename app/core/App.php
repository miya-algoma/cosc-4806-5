<?php

class App {

protected $controller = 'login';
protected $method = 'index';
protected $params = [];

public function __construct() {
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
$this->controller = 'home';
}

$url = $this->parseUrl();

if (isset($url[1]) && file_exists('app/controllers/' . $url[1] . '.php')) {
$this->controller = $url[1];
unset($url[1]);
}

require_once 'app/controllers/' . $this->controller . '.php';

$this->controller = new $this->controller;

if (isset($url[2]) && method_exists($this->controller, $url[2])) {
$this->method = $url[2];
unset($url[2]);
}

$this->params = $url ? array_values($url) : [];

call_user_func_array([$this->controller, $this->method], $this->params);
}

public function parseUrl() {
$url = rtrim($_SERVER['REQUEST_URI'], '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
return explode('/', $url);
}
}