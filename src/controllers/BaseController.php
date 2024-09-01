<?php

class BaseController
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function loadView($view, $data = [])
    {
        extract($data);
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . "/../views/$view.php";
        require_once __DIR__ . '/../views/footer.php';
    }

    protected function authorize($role)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
            http_response_code(403);
            echo "403 - Forbidden";
            exit();
        }
    }
}
