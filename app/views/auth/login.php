<h1>Connexion</h1>

<form method="post" action="<?php echo BASE_URL; ?>?controller=auth&action=login">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label>
            <input type="checkbox" name="remember" value="1">
            Se souvenir de moi
        </label>
    </div>
    <button type="submit">Se connecter</button>
</form>

