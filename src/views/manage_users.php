<h2>Manage Users</h2>

<form method="GET" action="/dashboard/manage-users" class="search-form">
    <input type="text" class="search-bar" name="search" placeholder="Search by username, email, or ID" value="<?= htmlspecialchars($search ?? '') ?>">
    <button type="submit">Search</button>
</form>

<table class="users-table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']); ?></td>
                    <td><?= htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="/dashboard/edit-user?id=<?= $user['id']; ?>" class="edit-btn">Edit</a>
                        <a href="/dashboard/ban-user?id=<?= $user['id']; ?>" class="ban-btn">Ban</a>
                        <form method="POST" action="/dashboard/delete-user" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="no-results">No users found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
