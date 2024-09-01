<?php

require_once 'BaseController.php';

class DashboardController extends BaseController
{
    public function index()
    {
        $this->authorize('admin');
        $this->loadView('dashboard');
    }

    public function manageBooks()
    {
        $this->authorize('admin');

        $stmt = $this->pdo->query("SELECT * FROM books");
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->loadView('manage_books', ['books' => $books]);
    }

    public function manageUsers()
    {
        $this->authorize('admin');

        $stmt = $this->pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->loadView('manage_users', ['users' => $users]);
    }
}
