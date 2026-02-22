<div class="auth-card">
    <h1>Mon compte</h1>

    <form method="post" action="<?php echo BASE_URL; ?>?controller=auth&action=account">
        <div>
            <label for="name">Nom</label>
            <input type="text" name="name" id="name"
                   value="<?php echo \Security::e($user['name'] ?? ''); ?>" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                   value="<?php echo \Security::e($user['email'] ?? ''); ?>" required>
        </div>
        <div>
            <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Mettre à jour</button>
    </form>

    <form method="post" action="<?php echo BASE_URL; ?>?controller=auth&action=delete"
          onsubmit="return confirm('Supprimer définitivement votre compte ?');">
        <button type="submit" class="danger">Supprimer mon compte</button>
    </form>
</div>

