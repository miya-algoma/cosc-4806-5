<?php

class App {

protected $controller = 'login';
protected $method = 'index';
protected $params = [];

public function __construct() {

if (session_status() === PHP_SESSION_NONE) {
session_start();
}


$url = $this->parseUrl();


if (isset($url[1]) && !empty($url[1])) {
$controllerName = ucfirst(strtolower($url[1])); 
$controllerPath = "app/controllers/{$controllerName}.php";

if (file_exists($controllerPath)) {

$this->controller = $controllerName;
unset($url[1]);
} else {

if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
$this->controller = 'home';
} else {
$this->controller = 'login';
}
}
} else {

if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
$this->controller = 'home';
} else {
$this->controller = 'login';
}
}


require_once "app/controllers/{$this->controller}.php";
$this->controller = new $this->controller;


if (isset($url[2]) && method_exists($this->controller, $url[2])) {
$this->method = $url[2];
unset($url[2]);
}


$this->params = $url ? array_values($url) : [];


call_user_func_array([$this->controller, $this->method], $this->params);
}

private function parseUrl() {
$u = $_SERVER['REQUEST_URI'];
$url = explode('/', filter_var(rtrim($u, '/'), FILTER_SANITIZE_URL));
unset($url[0]); 
return $url;
}
}