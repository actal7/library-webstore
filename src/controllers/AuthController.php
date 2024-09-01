<?php

require_once 'BaseController.php';

class AuthController extends BaseController
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize user inputs
            $username = htmlspecialchars(trim($_POST['username']));
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                $error = "Username and password are required.";
                $this->loadView('register', ['error' => $error]);
                return;
            }

            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            if ($stmt->fetch()) {
                $error = "Username already taken. Please choose another one.";
                $this->loadView('register', ['error' => $error]);
                return;
            }

            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
            $result = $stmt->execute([
                'username' => $username,
                'password' => $passwordHash,
                'role' => 'member'
            ]);

            if ($result) {
                // Optionally start a session and log the user in
                session_start();
                $_SESSION['user_id'] = $this->pdo->lastInsertId();
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'member';

                // Redirect to home page or dashboard
                header("Location: /");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
                $this->loadView('register', ['error' => $error]);
            }
        } else {
            $this->loadView('register');
        }
    }
}
