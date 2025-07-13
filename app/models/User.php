<?php

class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {}

    public function test() {
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM users;");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function authenticate($username, $password) {
        $username = strtolower($username);
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);

        // Check lockout status
        if ($this->isLockedOut($username)) {
            $_SESSION['failedAuth'] = 0;
            $_SESSION['auth_error'] = "Too many failed attempts. Please wait 60 seconds.";
            header('Location: /login');
            exit;
        }

        if ($rows && password_verify($password, $rows['password'])) {
            $_SESSION['auth'] = 1;
            $_SESSION['username'] = ucwords($username);
            $_SESSION['user_id'] = $rows['id']; 
            unset($_SESSION['failedAuth']);
            $this->logAttempt($username, 'good');
            header('Location: /home');
            exit;
        } else {
            if (isset($_SESSION['failedAuth'])) {
                $_SESSION['failedAuth']++;
            } else {
                $_SESSION['failedAuth'] = 1;
            }
            $_SESSION['auth_error'] = "Invalid username or password.";
            $this->logAttempt($username, 'bad');
            header('Location: /login');
            exit;
        }
    }

    public function create_user($username, $password) {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $statement->execute([
            ':username' => $username,
            ':password' => $password
        ]);
    }

    public function userExists($username) {
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindValue(':username', $username);
        $statement->execute();
        return $statement->rowCount() > 0;
    }

    public function logAttempt($username, $status) {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO log (username, attempt) VALUES (:username, :attempt)");
        $statement->execute([
            ':username' => $username,
            ':attempt' => $status
        ]);
    }

    public function isLockedOut($username) {
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM log WHERE username = :username ORDER BY timestamp DESC LIMIT 3");
        $statement->execute([':username' => $username]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) < 3) return false;

        foreach ($rows as $row) {
            if ($row['attempt'] !== 'bad') return false;
        }

        $lastTime = strtotime($rows[0]['timestamp']);
        return (time() - $lastTime) < 60;
    }
}
