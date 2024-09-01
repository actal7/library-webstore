<h2>Manage Books</h2>
<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Total Copies</th>
        <th>Available Copies</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= htmlspecialchars($book['title']); ?></td>
            <td><?= htmlspecialchars($book['author']); ?></td>
            <td><?= htmlspecialchars($book['total_copies']); ?></td>
            <td><?= htmlspecialchars($book['available_copies']); ?></td>
            <td>
                <a href="/dashboard/edit-book?id=<?= $book['id']; ?>">Edit</a>
                <a href="/dashboard/delete-book?id=<?= $book['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
