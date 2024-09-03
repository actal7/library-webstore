

<div class="register-container">
<h2>Register</h2>
<form method="POST" action="/register">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <input type="submit" value="Register">

  
</form>
</div>