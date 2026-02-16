<h1>Administration - Utilisateurs</h1>

<?php if (empty($users)): ?>
    <p>Aucun utilisateur.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Date de création</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo (int)$user['id']; ?></td>
                <td><?php echo \Security::e($user['name']); ?></td>
                <td><?php echo \Security::e($user['email']); ?></td>
                <td><?php echo \Security::e($user['role']); ?></td>
                <td><?php echo \Security::e($user['created_at']); ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>?controller=admin&action=users&delete=<?php echo (int)$user['id']; ?>"
                       onclick="return confirm('Supprimer cet utilisateur et ses réservations ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

