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
            SELECT reservations.id, reservations.status, reservations.reservation_date, reservations.borrow_date, 
                  books.title, books.author
            FROM reservations
            JOIN books ON reservations.book_id = books.id
            WHERE reservations.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $_SESSION['user_id']]);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->loadView('profile', ['user' => $user, 'reservations' => $reservations]);
    }

    public function cancelReservation()
    {
        $reservationId = $_POST['reservation_id'] ?? null;

        if ($reservationId && isset($_SESSION['user_id'])) {
            $stmt = $this->pdo->prepare("SELECT book_id FROM reservations WHERE id = :id AND user_id = :user_id AND status = 'reserved'");
            $stmt->execute(['id' => $reservationId, 'user_id' => $_SESSION['user_id']]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id AND user_id = :user_id AND status = 'reserved'");
                $stmt->execute(['id' => $reservationId, 'user_id' => $_SESSION['user_id']]);

                $stmt = $this->pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = :book_id");
                $stmt->execute(['book_id' => $book['book_id']]);

                $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/profile';
                header("Location: $redirectUrl");
                exit();
            } else {
                header("Location: /profile?status=error");
                exit();
            }
        } else {
            header("Location: /profile?status=error");
            exit();
        }
    }
}
