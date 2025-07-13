<?php

class Reports extends Controller {

    public function index() {
        session_start();

        // Restrict to admin only
        if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
            header('Location: /home');
            exit;
        }

        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM log ORDER BY timestamp DESC");
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->view('reports/index', $rows);
    }
}
