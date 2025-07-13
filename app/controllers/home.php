<?php

class Home extends Controller {
public function index() {
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['auth'])) {
header("Location: /login");
exit;
}

$model = $this->model('Reminder');
$reminders = $model->getAllByUser($_SESSION['user_id']);

$this->view('home/index', $reminders); // pass data to view
}
}