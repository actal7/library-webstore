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
}
