<?php

require_once '../config/config.php';
require_once '../vendor/autoload.php';

echo "Hello, World!";

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/../src/controllers/BookController.php';
        $controller = new BookController($pdo);
        $controller->home();
        break;
    case '/register' :
        require __DIR__ . '/../src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->register();
        break;
    case '/book' :
        require __DIR__ . '/../src/controllers/BookController.php';
        $controller = new BookController($pdo);
        $controller->viewBook();
        break;
    case '/login' :
        require __DIR__ . '/../src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
        break;
    default:
        http_response_code(404);
        echo '404 - Not Found';
        break;
}
