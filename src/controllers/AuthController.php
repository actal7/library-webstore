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
                session_start();
                $_SESSION['user_id'] = $this->pdo->lastInsertId();
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'member';

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

    public function login()
    { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username']));
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                $error = "Username and password are required.";
                $this->loadView('login', ['error' => $error]);
                return;
            }

            // Check if the user exists
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Start a session and log the user in
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: /");
                exit();
            } else {
                $error = "Invalid username or password.";
                $this->loadView('login', ['error' => $error]);
            }
        } else {
            $this->loadView('login');
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /");
        exit();
    }
}
