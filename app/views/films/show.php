<?php
/** @var array $film */
/** @var array $seances */
?>

<h1><?php echo \Security::e($film['title']); ?></h1>

<p><?php echo nl2br(\Security::e($film['description'] ?? '')); ?></p>
<p>Durée : <?php echo (int)$film['duration']; ?> minutes</p>

<h2>Séances</h2>

<?php if (empty($seances)): ?>
    <p>Aucune séance à venir pour ce film.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Date & heure</th>
            <th>Places restantes</th>
            <th>Réserver</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($seances as $seance): ?>
            <?php $remaining = Seance::remainingSeats((int)$seance['id']); ?>
            <tr>
                <td><?php echo \Security::e($seance['start_time']); ?></td>
                <td><?php echo (int)$remaining; ?></td>
                <td>
                    <?php if ($remaining > 0): ?>
                        <form method="post"
                              action="<?php echo BASE_URL; ?>?controller=reservation&action=create"
                              class="inline">
                            <input type="hidden" name="seance_id"
                                   value="<?php echo (int)$seance['id']; ?>">
                            <input type="number" name="seats" value="1" min="1"
                                   max="<?php echo (int)$remaining; ?>">
                            <button type="submit">Réserver</button>
                        </form>
                    <?php else: ?>
                        Complet
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

