<?php
require_once 'BaseController.php';

class ProfileController extends BaseController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['user_id'];

        $stmt = $this->pdo->prepare("SELECT username, email FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("
            SELECT books.title, books.author, reservations.reservation_date 
            FROM reservations 
            JOIN books ON reservations.book_id = books.id 
            WHERE reservations.user_id = :id
        ");
        $stmt->execute(['id' => $userId]);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->loadView('profile', ['user' => $user, 'reservations' => $reservations]);
    }
}
