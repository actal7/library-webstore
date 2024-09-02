<div class="library-container">
    <h1>Library</h1>
    
    <form method="GET" action="/library" class="search-form">
        <input type="text" name="search" placeholder="Search by title or author..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <?php if (empty($books)): ?>
        <p class="no-results">Sorry, we couldn't find a book that matches your search.</p>
    <?php else: ?>
        <div class="books-grid">
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <img src="<?= htmlspecialchars($book['image_url']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p><?= htmlspecialchars($book['author']) ?></p>
                    <p><?= htmlspecialchars($book['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/library?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>" class="<?= $i == $currentPage ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</div>
