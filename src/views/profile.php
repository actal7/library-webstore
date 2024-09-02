<div class="profile-container">
    <h1>Your Profile</h1>
    
    <div class="user-info">
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </div>

    <h2>Your Reservations</h2>
    <?php if (empty($reservations)): ?>
        <p>You have no reservations at the moment.</p>
    <?php else: ?>
        <ul class="reservations-list">
            <?php foreach ($reservations as $reservation): ?>
                <li>
                    <strong><?= htmlspecialchars($reservation['title']) ?></strong> by <?= htmlspecialchars($reservation['author']) ?>
                    <br>
                    Reserved on: <?= htmlspecialchars($reservation['reservation_date']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
