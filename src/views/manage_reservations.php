<h2>Manage Reservations</h2>
<?php if (empty($reservations)): ?>
    <p>No reservations to manage at this time.</p>
<?php else: ?>
    <ul class="reservations-list">
        <?php foreach ($reservations as $reservation): ?>
            <?php if ($reservation['status'] == 'reserved'): ?>
                <li>
                    <strong><?= htmlspecialchars($reservation['title']) ?></strong> by <?= htmlspecialchars($reservation['author']) ?>
                    <br>
                    Reserved by: <?= htmlspecialchars($reservation['username']) ?>
                    <br>
                    Reserved on: <?= htmlspecialchars($reservation['reservation_date']) ?>
                    <form method="POST" action="/confirm-reservation">
                        <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['id']) ?>">
                        <button type="submit">Confirm Reservation</button>
                    </form>
                </li>
            <?php elseif ($reservation['status'] == 'borrowed'): ?>
                <li>
                    <strong><?= htmlspecialchars($reservation['title']) ?></strong> by <?= htmlspecialchars($reservation['author']) ?>
                    <br>
                    Borrowed by: <?= htmlspecialchars($reservation['username']) ?>
                    <br>
                    Borrowed on: <?= htmlspecialchars($reservation['borrow_date']) ?>
                    <form method="POST" action="/mark-as-returned">
                        <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['id']) ?>">
                        <button type="submit">Mark as Returned</button>
                    </form>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
