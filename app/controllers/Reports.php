<?php

class Reports extends Controller {

    public function index() {
        session_start();

        // Restrict to admin only
        if (!isset($_SESSION['auth']) || strtolower($_SESSION['username']) !== 'admin') {
            header('Location: /home');
            exit;
        }

        $db = db_connect();

        // 1. View all reminders
        $stmt1 = $db->prepare("SELECT users.username, notes.subject, notes.created_at FROM notes JOIN users ON notes.user_id = users.id ORDER BY notes.created_at DESC");
        $stmt1->execute();
        $allReminders = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        // 2. Who has the most reminders
        $stmt2 = $db->prepare("SELECT users.username, COUNT(*) AS reminder_count FROM notes JOIN users ON notes.user_id = users.id GROUP BY users.username ORDER BY reminder_count DESC LIMIT 1");
        $stmt2->execute();
        $topUser = $stmt2->fetch(PDO::FETCH_ASSOC);

        // 3. Total login attempts by username
        $stmt3 = $db->prepare("SELECT username, COUNT(*) as attempts FROM log GROUP BY username");
        $stmt3->execute();
        $loginCounts = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        $this->view('reports/index', [
            'allReminders' => $allReminders,
            'topUser' => $topUser,
            'loginCounts' => $loginCounts
        ]);
    }
}
