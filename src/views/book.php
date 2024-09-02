<div class="book-details-container">
    <?php if ($book): ?>
        <h1><?= htmlspecialchars($book['title']) ?></h1>
        <h2>by <?= htmlspecialchars($book['author']) ?></h2>
        <img src="<?= htmlspecialchars($book['image_url']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-cover">
        <p class="book-description"><?= nl2br(htmlspecialchars($book['description'])) ?></p>
        <p><strong>Available Copies:</strong> <?= htmlspecialchars($book['available_copies']) ?> out of <?= htmlspecialchars($book['total_copies']) ?></p>

        <?php if ($book['available_copies'] > 0): ?>
            <?php if (isset($_SESSION['username'])): ?>
                <form method="POST" action="/reserve">
                    <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['id']) ?>">
                    <button type="submit" class="reserve-button">Reserve a Copy</button>
                </form>
            <?php else: ?>
                <a href="/register" class="reserve-button">Register to Reserve a Copy</a>
            <?php endif; ?>
        <?php else: ?>
            <p class="no-copies">Sorry, this book is currently unavailable.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Sorry, we couldn't find the book you're looking for.</p>
    <?php endif; ?>
</div>
