<h2>Edit Book</h2>
<form method="POST" action="/dashboard/edit-book">
    <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']); ?>">

    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']); ?>" required>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']); ?>" required>

    <label for="description">Description:</label>
    <input type="text" id="description" name="description" value="<?= htmlspecialchars($book['description']); ?>">

    <label for="total_copies">Total Copies:</label>
    <input type="text" id="total_copies" name="total_copies" value="<?= htmlspecialchars($book['total_copies']); ?>" required>

    <label for="available_copies">Available Copies:</label>
    <input type="text" id="available_copies" name="available_copies" value="<?= htmlspecialchars($book['available_copies']); ?>" required>

    <label for="image_url">Image URL:</label>
    <input type="text" id="image_url" name="image_url" value="<?= htmlspecialchars($book['image_url']); ?>" required>

    <button type="submit">Save Changes</button>
</form>
