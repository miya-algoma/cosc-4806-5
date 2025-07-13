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
        $user_id = $_SESSION['auth']['user_id'] ?? null;
        $model = $this->model('Reminder');
        $reminders = $model->getAllByUser($user_id);

        // Pass data to view
        $this->view('home/index', ['data' => $reminders]);
    }
}
