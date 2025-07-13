<?php

class User {

    public string $username;
    public string $password;
    public bool $auth = false;

    public function __construct() {}

    /**
     * Test connection to database.
     * 
     * @return array|null
     */
    public function test(): ?array {
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM users;");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Authenticate a user and start session if valid.
     * 
     * @param string $username
     * @param string $password
     * @return void
     */
    public function authenticate(string $username, string $password): void {
        $username = strtolower($username);
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);

        if ($this->isLockedOut($username)) {
            $_SESSION['failedAuth'] = 0;
            $_SESSION['auth_error'] = "Too many failed attempts. Please wait 60 seconds.";
            header('Location: /login');
            exit;
        }

        if ($rows && password_verify($password, $rows['password'])) {
            $_SESSION['auth'] = 1;
            $_SESSION['username'] = 'admin';
            $_SESSION['user_id'] = $rows['id'];
            unset($_SESSION['failedAuth']);
            $this->logAttempt($username, 'good');
            header('Location: /home');
            exit;
        } else {
            $_SESSION['failedAuth'] = ($_SESSION['failedAuth'] ?? 0) + 1;
            $_SESSION['auth_error'] = "Invalid username or password.";
            $this->logAttempt($username, 'bad');
            header('Location: /login');
            exit;
        }
    }

    /**
     * Create a new user in the database.
     * 
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function create_user(string $username, string $password): bool {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $statement->execute([
            ':username' => $username,
            ':password' => $password
        ]);
    }

    /**
     * Check if a username already exists.
     * 
     * @param string $username
     * @return bool
     */
    public function userExists(string $username): bool {
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindValue(':username', $username);
        $statement->execute();
        return $statement->rowCount() > 0;
    }

    /**
     * Log a login attempt (good or bad).
     * 
     * @param string $username
     * @param string $status
     * @return void
     */
    public function logAttempt(string $username, string $status): void {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO log (username, attempt) VALUES (:username, :attempt)");
        $statement->execute([
            ':username' => $username,
            ':attempt' => $status
        ]);
    }

    /**
     * Check if a user is locked out due to failed attempts.
     * 
     * @param string $username
     * @return bool
     */
    public function isLockedOut(string $username): bool {
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

    /**
     * Check if current user is admin.
     * 
     * @return bool
     */
    public function isAdmin(): bool {
        return isset($_SESSION['username']) && strtolower($_SESSION['username']) === 'admin';
    }
}