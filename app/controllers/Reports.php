<?php

class Reports extends Controller {

public function index() {
if (session_status() === PHP_SESSION_NONE) session_start();

// Restrict to admin only
if (!isset($_SESSION['auth']) || strtolower($_SESSION['username']) !== 'admin') {
header('Location: /home');
exit;
}

$db = db_connect();
$statement = $db->prepare("SELECT * FROM log ORDER BY timestamp DESC");
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

// Pass data to view
$this->view('reports/index', $rows);
}
}