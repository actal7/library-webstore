<div class="book-management">
  <h2>Manage Books</h2>
    <form class="search-form" method="GET" action="/dashboard/manage-books">
        <input type="text" class="search-bar" name="search" placeholder="Search by title or author" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <form method="POST" action="/dashboard/add-book">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <input type="text" name="description" placeholder="Description">
        <input type="text" name="total_copies" placeholder="Total Copies" required>
        <input type="text" name="image_url" placeholder="Image URL" required>
        <button type="submit">Add Book</button>
    </form>


    <table class="books-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Total Copies</th>
                <th>Available Copies</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['title']); ?></td>
                    <td><?= htmlspecialchars($book['author']); ?></td>
                    <td><?= htmlspecialchars($book['total_copies']); ?></td>
                    <td><?= htmlspecialchars($book['available_copies']); ?></td>
                    <td>
                        <a href="/dashboard/edit-book?id=<?= $book['id']; ?>" class="edit-btn">Edit</a>
                        <form method="POST" action="/dashboard/delete-book" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $book['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= ceil($totalBooks / 20); $i++): ?>
            <a href="?search=<?= htmlspecialchars($search) ?>&page=<?= $i ?>" 
               class="<?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>
