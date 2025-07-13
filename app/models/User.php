<?php

class User
{
    public $id;
    public $username;
    public $password;
    public $role; // optional, if you want to expand roles

    public function __construct($id = null, $username = null, $password = null, $role = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    // Load user from database by username
    public function loadByUsername($username)
    {
        $db = db_connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->password = $user['password'];
            if (isset($user['role'])) {
                $this->role = $user['role'];
            }
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        // If you have a role column, use: return $this->role === 'admin';
        return isset($this->username) && $this->username === 'admin';
    }
}
