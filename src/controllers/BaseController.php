<?php

class BaseController
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    protected function loadView($view, $data = [])
    {
        extract($data);
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . "/../views/$view.php";
        require_once __DIR__ . '/../views/footer.php';
    }
}
