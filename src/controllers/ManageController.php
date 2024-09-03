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

            header("Location: /manage-reservations?status=confirmed");
            exit();
        } else {
            header("Location: /manage-reservations?status=error");
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
            $stmt = $this->pdo->prepare("SELECT book_id FROM reservations WHERE id = :id AND status = 'borrowed'");
            $stmt->execute(['id' => $reservationId]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id AND status = 'borrowed'");
                $stmt->execute(['id' => $reservationId]);

                $stmt = $this->pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = :book_id");
                $stmt->execute(['book_id' => $book['book_id']]);

                header("Location: /manage-reservations?status=returned");
                exit();
            } else {
                header("Location: /manage-reservations?status=error");
                exit();
            }
        } else {
            header("Location: /manage-reservations?status=error");
            exit();
        }
    }

    public function manageUsers()
    {
        $search = $_GET['search'] ?? '';
        $searchTerm = '%' . $search . '%';

        $stmt = $this->pdo->prepare("
            SELECT * FROM users 
            WHERE username LIKE :searchTerm 
            OR email LIKE :searchTerm 
            OR CAST(id AS TEXT) LIKE :searchTerm
        ");
        $stmt->execute(['searchTerm' => $searchTerm]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->loadView('manage_users', ['users' => $users, 'search' => $search]);
    }

    public function showEditUserForm()
    {
        $userId = $_GET['id'] ?? null;

        if ($userId) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $this->loadView('edit_user', ['user' => $user]);
            } else {
                echo "User not found.";
            }
        } else {
            echo "Invalid user ID.";
        }
    }

    public function editUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            $stmt = $this->pdo->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'role' => $role,
                'id' => $userId
            ]);

            header("Location: /dashboard/manage-users?status=edited");
            exit();
        }
    }

    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['id'];

            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $userId]);

            header("Location: /dashboard/manage-users?status=deleted");
            exit();
        } else {
            echo "Invalid request method.";
        }
    }

    public function banUser()
    {
        $userId = $_GET['id'] ?? null;

        if ($userId) {
            $stmt = $this->pdo->prepare("UPDATE users SET role = 'banned' WHERE id = :id");
            $stmt->execute(['id' => $userId]);

            header("Location: /dashboard/manage-users?status=banned");
            exit();
        } else {
            echo "Invalid user ID.";
        }
    }

    public function manageBooks()
    {
        $search = $_GET['search'] ?? '';
        $page = $_GET['page'] ?? 1;
        $query = "SELECT * FROM books WHERE title LIKE :search OR author LIKE :search LIMIT 20 OFFSET :offset";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['search' => '%' . $search . '%', 'offset' => ($page - 1) * 20]);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM books WHERE title LIKE :search OR author LIKE :search");
        $stmt->execute(['search' => '%' . $search . '%']);
        $totalBooks = $stmt->fetchColumn();

        $this->loadView('manage_books', ['books' => $books, 'search' => $search, 'totalBooks' => $totalBooks, 'currentPage' => $page]);
    }

    public function addBook()
    {
        $stmt = $this->pdo->prepare("INSERT INTO books (title, author, description, total_copies, available_copies, image_url) VALUES (:title, :author, :description, :total_copies, :total_copies, :image_url)");
        $stmt->execute([
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'description' => $_POST['description'],
            'total_copies' => (int)$_POST['total_copies'],  // Convert to integer
            'image_url' => $_POST['image_url']
        ]);
        header("Location: /dashboard/manage-books");
        exit();
    }

    public function showEditForm()
    {
        $bookId = $_GET['id'] ?? null;

        if ($bookId) {
            $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = :id");
            $stmt->execute(['id' => $bookId]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                $this->loadView('edit_book', ['book' => $book]);
            } else {
                echo "Book not found.";
            }
        } else {
            echo "Invalid book ID.";
        }
    }

    public function editBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookId = $_POST['id'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $description = $_POST['description'];
            $totalCopies = $_POST['total_copies'];
            $availableCopies = $_POST['available_copies'];

            $stmt = $this->pdo->prepare("UPDATE books SET title = :title, author = :author, description = :description, total_copies = :total_copies, available_copies = :available_copies, image_url = :image_url WHERE id = :id");
            $stmt->execute([
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'description' => $_POST['description'],
                'total_copies' => (int)$_POST['total_copies'], 
                'available_copies' => (int)$_POST['available_copies'],  
                'image_url' => $_POST['image_url'],
                'id' => $_POST['id']
            ]);
            header("Location: /dashboard/manage-books");
            exit();
        }
    }


    public function deleteBook()
    {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookId = $_POST['id'];

        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = :id");
        $stmt->execute(['id' => $bookId]);

        header("Location: /dashboard/manage-books?status=deleted");
        exit();
    }
    }


}
