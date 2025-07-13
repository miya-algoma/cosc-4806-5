<?php

class Reports extends Controller {

    public function index() {
        session_start();

        if (!isset($_SESSION['auth']) || strtolower($_SESSION['username']) !== 'admin') {
            header('Location: /home');
            exit;
        }

        $db = db_connect();

        // Get all login attempts
        $stmt = $db->prepare("SELECT username, COUNT(*) as attempts FROM log GROUP BY username");
        $stmt->execute();
        $loginCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get all reminders (with usernames)
        $stmt = $db->prepare("
            SELECT users.username, notes.subject, notes.created_at 
            FROM notes 
            JOIN users ON notes.user_id = users.id
        ");
        $stmt->execute();
        $allReminders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get top user with most reminders
        $stmt = $db->prepare("
            SELECT users.username, COUNT(*) as reminder_count 
            FROM notes 
            JOIN users ON notes.user_id = users.id 
            GROUP BY users.username 
            ORDER BY reminder_count DESC 
            LIMIT 1
        ");
        $stmt->execute();
        $topUser = $stmt->fetch(PDO::FETCH_ASSOC);

        // Pass everything into the view
        $this->view('reports/index', [
            'loginCounts' => $loginCounts,
            'allReminders' => $allReminders,
            'topUser' => $topUser
        ]);
    }
}
