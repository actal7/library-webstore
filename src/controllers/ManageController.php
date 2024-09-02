<?php
require_once 'BaseController.php';

class ManageController extends BaseController
{
    public function confirmReservation()
    {
        $reservationId = $_POST['reservation_id'] ?? null;

        if ($reservationId && ($_SESSION['role'] === 'clerk' || $_SESSION['role'] === 'admin')) {
            $stmt = $this->pdo->prepare("UPDATE reservations SET status = 'borrowed', borrow_date = CURRENT_TIMESTAMP WHERE id = :id AND status = 'reserved'");
            $stmt->execute(['id' => $reservationId]);

            $stmt = $this->pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = (SELECT book_id FROM reservations WHERE id = :id)");
            $stmt->execute(['id' => $reservationId]);

            header("Location: /dashboard/manage-reservations?status=confirmed");
            exit();
        } else {
            header("Location: /dashboard/manage-reservations?status=error");
            exit();
        }
    }

    public function manageReservations()
    {
        if ($_SESSION['role'] !== 'clerk' && $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo "403 - Forbidden";
            exit();
        }

        // Fetch all reservations
        $stmt = $this->pdo->query("
            SELECT reservations.id, reservations.status, reservations.reservation_date, reservations.borrow_date, 
                  books.title, books.author, users.username
            FROM reservations
            JOIN books ON reservations.book_id = books.id
            JOIN users ON reservations.user_id = users.id
            ORDER BY reservations.status ASC, reservations.reservation_date DESC
        ");
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->loadView('manage_reservations', ['reservations' => $reservations]);
    }

    public function markAsReturned()
    {
        $reservationId = $_POST['reservation_id'] ?? null;

        if ($reservationId && ($_SESSION['role'] === 'clerk' || $_SESSION['role'] === 'admin')) {
            $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id AND status = 'borrowed'");
            $stmt->execute(['id' => $reservationId]);

            // Increase the available copies
            $stmt = $this->pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = (SELECT book_id FROM reservations WHERE id = :id)");

            $stmt->execute(['id' => $reservationId]);

            header("Location: /dashboard/manage-reservations?status=returned");
            exit();
        } else {
            header("Location: /dashboard/manage-reservations?status=error");
            exit();
        }
    }
}
