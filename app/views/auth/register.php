<h1>Inscription</h1>

<form method="post" action="<?php echo BASE_URL; ?>?controller=auth&action=register">
    <div>
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="password_confirm">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" id="password_confirm" required>
    </div>
    <button type="submit">Créer le compte</button>
</form>

