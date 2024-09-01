<?php

require_once '../config/config.php';
require_once '../vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];

echo "TEST DEPLOY";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    case '/login' :
        require __DIR__ . '/../src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
        break;
    case '/logout' :
        require __DIR__ . '/../src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->logout();
        break;
    case '/book' :
        require __DIR__ . '/../src/controllers/BookController.php';
        $controller = new BookController($pdo);
        $controller->viewBook();
        break;
    case '/dashboard' :
        require __DIR__ . '/../src/controllers/DashboardController.php';
        $controller = new DashboardController($pdo);
        $controller->index();
        break;
    case '/dashboard/manage-books' :
        require __DIR__ . '/../src/controllers/DashboardController.php';
        $controller = new DashboardController($pdo);
        $controller->manageBooks();
        break;
    case '/dashboard/manage-users' :
        require __DIR__ . '/../src/controllers/DashboardController.php';
        $controller = new DashboardController($pdo);
        $controller->manageUsers();
        break;        
    default:
        http_response_code(404);
        echo '404 - Not Found';
        break;
}
