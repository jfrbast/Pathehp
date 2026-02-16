<h1>Administration - Séances</h1>

<h2>Ajouter une séance</h2>
<form method="post" action="<?php echo BASE_URL; ?>?controller=admin&action=seances">
    <div>
        <label for="film_id">Film</label>
        <select name="film_id" id="film_id" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($films as $film): ?>
                <option value="<?php echo (int)$film['id']; ?>">
                    <?php echo \Security::e($film['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="start_time">Date & heure (YYYY-MM-DD HH:MM:SS)</label>
        <input type="text" name="start_time" id="start_time" required>
    </div>
    <div>
        <label for="seats_total">Nombre total de places</label>
        <input type="number" name="seats_total" id="seats_total" min="1" required>
    </div>
    <button type="submit">Ajouter</button>
</form>

<h2>Liste des séances</h2>
<?php if (empty($seances)): ?>
    <p>Aucune séance.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Film</th>
            <th>Début</th>
            <th>Places totales</th>
            <th>Places restantes</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($seances as $seance): ?>
            <?php $remaining = Seance::remainingSeats((int)$seance['id']); ?>
            <tr>
                <td><?php echo (int)$seance['id']; ?></td>
                <td><?php echo \Security::e($seance['film_title']); ?></td>
                <td><?php echo \Security::e($seance['start_time']); ?></td>
                <td><?php echo (int)$seance['seats_total']; ?></td>
                <td><?php echo (int)$remaining; ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>?controller=admin&action=seances&delete=<?php echo (int)$seance['id']; ?>"
                       onclick="return confirm('Supprimer cette séance ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

