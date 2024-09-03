<?php

require_once '../config/config.php';
require_once '../vendor/autoload.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

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
    case '/library':
        require __DIR__ . '/../src/controllers/BookController.php';
        $controller = new BookController($pdo);
        $controller->library();
        break;
    case '/book':
        require __DIR__ . '/../src/controllers/BookController.php';
        $controller = new BookController($pdo);
        $controller->viewBook();
        break;
    case '/profile':
        require __DIR__ . '/../src/controllers/ProfileController.php';
        $controller = new ProfileController($pdo);
        $controller->index();
        break;
    case '/dashboard' :
        require __DIR__ . '/../src/controllers/DashboardController.php';
        $controller = new DashboardController($pdo);
        $controller->index();
        break;
    case '/reserve':
        require __DIR__ . '/../src/controllers/BookController.php';
        $controller = new BookController($pdo);
        $controller->reserveBook();
        break;
    case '/dashboard/manage-users' :
        require __DIR__ . '/../src/controllers/DashboardController.php';
        $controller = new DashboardController($pdo);
        $controller->manageUsers();
        break;      
    case '/dashboard/delete-user':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        $controller->deleteUser();
        break;        
    case '/dashboard/ban-user':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        $controller->banUser();
        break;
    case '/dashboard/manage-books':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        $controller->manageBooks();
        break;
    case '/dashboard/add-book':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        $controller->addBook();
        break;
    case '/dashboard/delete-book':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        $controller->deleteBook();
        break;
    case '/manage-reservations':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        $controller->manageReservations();  
        break;
    case '/confirm-reservation':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        $controller->confirmReservation();
        break;
    case '/mark-as-returned':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        $controller->markAsReturned();
        break;
    case '/cancel-reservation':
        require __DIR__ . '/../src/controllers/ProfileController.php';
        $controller = new ProfileController($pdo);
        $controller->cancelReservation();
        break;
    case '/dashboard/edit-book':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->editBook();
        } else {
            $controller->showEditForm();
        }
        break;
    case '/dashboard/edit-user':
        require __DIR__ . '/../src/controllers/ManageController.php';
        $controller = new ManageController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->editUser();
        } else {
            $controller->showEditUserForm();
        }
        break;
        
    default:
        http_response_code(404);
        echo '404 - Not Found';
        break;
}
