<h1>Mes réservations</h1>

<?php if (empty($reservations)): ?>
    <p>Vous n'avez pas encore de réservation.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Film</th>
            <th>Séance</th>
            <th>Places</th>
            <th>Date de réservation</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?php echo \Security::e($reservation['film_title']); ?></td>
                <td><?php echo \Security::e($reservation['start_time']); ?></td>
                <td><?php echo (int)$reservation['seats']; ?></td>
                <td><?php echo \Security::e($reservation['created_at']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

