<?php

class Login extends Controller
{
		public function index()
		{
				if (session_status() === PHP_SESSION_NONE) {
						session_start();
				}

				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						$username = trim($_POST['username']);
						$password = trim($_POST['password']);

						// Connect to the DB and fetch user info
						$db = db_connect();
						$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
						$stmt->execute([$username]);
						$user = $stmt->fetch(PDO::FETCH_ASSOC);

						// For testing: password is plain text (not hashed) in your DB
						if ($user && $password === $user['password']) {
								$_SESSION['auth'] = [
										'username' => $user['username'],
										'user_id' => $user['id']
								];
								header('Location: /home');
								exit;
						}

						// Fallback: hardcoded admin/AdminPassword123 for instructor/demo only
						if ($username === 'admin' && $password === 'AdminPassword123') {
								$_SESSION['auth'] = [
										'username' => 'admin',
										'user_id' => 5 // match your DB admin user_id!
								];
								header('Location: /home');
								exit;
						}
				}

				if (!isset($_SESSION['auth'])) {
						$this->view('templates/headerPublic');
				} else {
						$this->view('templates/header');
				}
				$this->view('login/index');
				$this->view('templates/footer');
		}
}
