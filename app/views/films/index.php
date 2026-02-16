<h1>Films à l'affiche</h1>

<?php if (empty($films)): ?>
    <p>Aucun film pour le moment.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Titre</th>
            <th>Durée (min)</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($films as $film): ?>
            <tr>
                <td><?php echo \Security::e($film['title']); ?></td>
                <td><?php echo (int)$film['duration']; ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>?controller=film&action=show&id=<?php echo (int)$film['id']; ?>">
                        Voir les séances
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

