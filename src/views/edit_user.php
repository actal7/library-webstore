<h2 class="edit-user-title">Edit User</h2>

<form method="POST" action="/dashboard/edit-user" class="edit-user-form">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">

    <label for="username" class="edit-user-label">Username:</label>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required class="edit-user-input">

    <label for="email" class="edit-user-label">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required class="edit-user-input">

    <label for="role" class="edit-user-label">Role:</label>
    <select id="role" name="role" required class="edit-user-select">
        <option value="member" <?= $user['role'] == 'member' ? 'selected' : ''; ?>>Member</option>
        <option value="clerk" <?= $user['role'] == 'clerk' ? 'selected' : ''; ?>>Clerk</option>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
        <option value="banned" <?= $user['role'] == 'banned' ? 'selected' : ''; ?>>Banned</option>
    </select>

    <button type="submit" class="edit-user-button">Save Changes</button>
</form>
