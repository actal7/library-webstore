<h2>Manage Users</h2>
<table>
    <tr>
        <th>Username</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']); ?></td>
            <td><?= htmlspecialchars($user['role']); ?></td>
            <td>
                <a href="/dashboard/edit-user?id=<?= $user['id']; ?>">Edit</a>
                <a href="/dashboard/ban-user?id=<?= $user['id']; ?>">Ban</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
