<?php

class Reminders extends Controller {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth'])) {
            header("Location: /login");
            exit;
        }

        $model = $this->model('Reminder');
        $reminders = $model->getAllByUser($_SESSION['user_id']);
        $this->view('reminders/index', $reminders);
    }

    public function create() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth'])) {
            header("Location: /login");
            exit;
        }

        $this->view('reminders/create');
    }

    public function store() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth'])) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject'])) {
            $subject = trim($_POST['subject']);
            $this->model('Reminder')->create($_SESSION['user_id'], $subject);
            header("Location: /reminders");
            exit;
        }

        header("Location: /reminders/create");
        exit;
    }

    public function edit($id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth'])) {
            header("Location: /login");
            exit;
        }

        $model = $this->model('Reminder');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = trim($_POST['subject']);
            $model->update($id, $_SESSION['user_id'], $subject);
            header("Location: /reminders");
            exit;
        }

        $reminder = $model->getOne($id, $_SESSION['user_id']);
        $this->view('reminders/edit', $reminder);
    }

    public function delete($id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth'])) {
            header("Location: /login");
            exit;
        }

        $this->model('Reminder')->delete($id, $_SESSION['user_id']);
        header("Location: /reminders");
        exit;
    }

    public function complete($id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth'])) {
            header("Location: /login");
            exit;
        }

        $this->model('Reminder')->markCompleted($id, $_SESSION['user_id']);
        header("Location: /home");
        exit;
    }
}
