<?php

class Create extends Controller {

    public function index() {
        $this->view('create/index');
    }

    public function register() {
        $user = $this->model('User');

        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];

        // Basic validation
        if ($password !== $confirm) {
            $_SESSION['create_error'] = "Passwords do not match.";
            header("Location: /create");
            exit;
        }

        if (strlen($password) < 10) {
            $_SESSION['create_error'] = "Password must be at least 10 characters.";
            header("Location: /create");
            exit;
        }

        if ($user->userExists($username)) {
            $_SESSION['create_error'] = "Username already exists.";
            header("Location: /create");
            exit;
        }

      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $user->create_user($username, $hashed);


        $_SESSION['create_success'] = "Account created. You may now login.";
        header("Location: /login");
        exit;
    }
}
