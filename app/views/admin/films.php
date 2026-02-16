<h1>Administration - Films</h1>

<h2>Ajouter un film</h2>
<form method="post" action="<?php echo BASE_URL; ?>?controller=admin&action=films">
    <div>
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" required>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>
    </div>
    <div>
        <label for="duration">Durée (min)</label>
        <input type="number" name="duration" id="duration" min="1" required>
    </div>
    <button type="submit">Ajouter</button>
</form>

<h2>Liste des films</h2>
<?php if (empty($films)): ?>
    <p>Aucun film.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Durée</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($films as $film): ?>
            <tr>
                <td><?php echo (int)$film['id']; ?></td>
                <td><?php echo \Security::e($film['title']); ?></td>
                <td><?php echo (int)$film['duration']; ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>?controller=admin&action=films&delete=<?php echo (int)$film['id']; ?>"
                       onclick="return confirm('Supprimer ce film ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

