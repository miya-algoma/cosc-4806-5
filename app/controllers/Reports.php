<?php

class Reports extends Controller {

    /**
     * Display login report from the log table.
     *
     * @return void
     */
    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Temporarily allow access for testing
        // if (!isset($_SESSION['auth']) || strtolower($_SESSION['username']) !== 'admin') {
        //     header('Location: /home');
        //     exit;
        // }

        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM log ORDER BY timestamp DESC");
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->view('reports/index', $rows);
    }

    /**
     * Show all reminders from all users.
     *
     * @return void
     */
    public function allReminders(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

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

    /**
     * Display user with the most reminders.
     *
     * @return void
     */
    public function mostReminders(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

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

    /**
     * Show login attempt counts per user (only 'good' attempts).
     *
     * @return void
     */
    public function loginCounts(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $db = db_connect();
        $stmt = $db->prepare("
            SELECT username, COUNT(*) AS login_count
            FROM log
            WHERE attempt = 'good'
            GROUP BY username
            ORDER BY login_count DESC
        ");
        $stmt->execute();
        $counts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('reports/login_counts', $counts);
    }
}