<div class="profile-container">
    <h1>Your Profile</h1>
    
    <div class="user-info">
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </div>

    <h2>Your Reserved Books</h2>
    <?php if (empty($reservations)): ?>
        <p>You have no reservations at the moment.</p>
    <?php else: ?>
        <ul class="reservations-list">
        <?php foreach ($reservations as $reservation): ?>
            <?php if (isset($reservation['status']) && $reservation['status'] == 'reserved'): ?>
                <li>
                    <strong><?= htmlspecialchars($reservation['title']) ?></strong> by <?= htmlspecialchars($reservation['author']) ?>
                    <br>
                    Reserved on: <?= htmlspecialchars($reservation['reservation_date']) ?>
                    <br>
                    <form method="POST" action="/cancel-reservation">
                        <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['id']) ?>">
                        <button type="submit">Cancel Reservation</button>
                    </form>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Your Borrowed Books</h2>
    <?php if (empty(array_filter($reservations, fn($r) => $r['status'] == 'borrowed'))): ?>
        <p>You have no borrowed books at the moment.</p>
    <?php else: ?>
        <ul class="reservations-list">
            <?php foreach ($reservations as $reservation): ?>
                <?php if ($reservation['status'] == 'borrowed'): ?>
                    <li>
                        <strong><?= htmlspecialchars($reservation['title']) ?></strong> by <?= htmlspecialchars($reservation['author']) ?>
                        <br>
                        Borrowed on: <?= htmlspecialchars($reservation['borrow_date']) ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
