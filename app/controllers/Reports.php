<?php

class Reports extends Controller
{
    private function checkAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Check for username admin (change if you use a different key)
        if (!isset($_SESSION['auth']) || strtolower($_SESSION['auth']['username']) !== 'admin') {
            header('Location: /home');
            exit;
        }
    }

    public function index(): void
    {
        $this->checkAdmin();

        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM log ORDER BY timestamp DESC");
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->view('reports/index', $rows);
    }

    public function allReminders(): void
    {
        $this->checkAdmin();

        $db = db_connect();
        $stmt = $db->prepare("
            SELECT u.username, n.subject, n.created_at
            FROM users u
            JOIN notes n ON u.id = n.user_id
            ORDER BY n.created_at DESC
        ");
        $stmt->execute();
        $reminders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('reports/all_reminders', ['reminders' => $reminders]);
    }

    public function mostReminders(): void
    {
        $this->checkAdmin();

        $db = db_connect();
        $stmt = $db->prepare("
            SELECT u.username, COUNT(n.id) AS total
            FROM users u
            LEFT JOIN notes n ON u.id = n.user_id
            GROUP BY u.id
            ORDER BY total DESC
            LIMIT 1
        ");
        $stmt->execute();
        $topUser = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->view('reports/most_reminders', $topUser);
    }

    public function loginCounts(): void
    {
        $this->checkAdmin();

        $db = db_connect();
        $stmt = $db->prepare("
            SELECT username, COUNT(*) AS total
            FROM log
            WHERE status = 'good'
            GROUP BY username
            ORDER BY total DESC
        ");
        $stmt->execute();
        $loginCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('reports/login_counts', ['loginCounts' => $loginCounts]);
    }
}
