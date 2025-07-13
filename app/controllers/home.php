<?php

class Home extends Controller
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['auth'])) {
            header('Location: /login');
            exit;
        }

        // Load reminders for the logged-in user
        $model = $this->model('Reminder');
        $reminders = $model->getAllByUser($_SESSION['user_id']);

        // Pass data to view
        $this->view('home/index', ['data' => $reminders]);
    }
}