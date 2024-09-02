<?php
require_once 'BaseController.php';

class BookController extends BaseController
{
    public function home()
    {
        $stmt = $this->pdo->query("SELECT * FROM books LIMIT 10");
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->loadView('home', ['books' => $books]);
    }

    public function viewBook()
    {
        $bookId = $_GET['id'] ?? null;

        if ($bookId) {
            $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = :id");
            $stmt->execute(['id' => $bookId]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $book = null;
        }

        $this->loadView('book', ['book' => $book]);
    }

    public function library()
    {
        $limit = 16; // Number of books per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // search. add filter
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

$query = "SELECT * FROM books WHERE 1=1";

if (!empty($search)) {
    $searchTerm = '%' . $search . '%';
    $query .= " AND (title ILIKE :search OR author ILIKE :search)";
}

$stmt = $this->pdo->prepare($query . " LIMIT :limit OFFSET :offset");

if (!empty($search)) {
    $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
}

$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);



        $countQuery = "SELECT COUNT(*) FROM books WHERE 1=1";
        if (!empty($search)) {
            $countQuery .= " AND (title ILIKE :search OR author ILIKE :search)";
        }

        $countStmt = $this->pdo->prepare($countQuery);

        if (!empty($search)) {
            $countStmt->bindParam(':search', $search, PDO::PARAM_STR);
        }

        $countStmt->execute();
        $totalBooks = $countStmt->fetchColumn();
        $totalPages = ceil($totalBooks / $limit);

        $this->loadView('library', [
            'books' => $books,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'search' => $search
        ]);
    }
}
