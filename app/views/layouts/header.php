<?php
use Security as Sec;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cinéma - Réservations</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
<header>
    <nav>
        <a href="<?php echo BASE_URL; ?>">Accueil</a>
        <a href="<?php echo BASE_URL; ?>?controller=reservation&action=index">Mes réservations</a>
        <?php if (\Security::isLoggedIn()): ?>
            <span>Connecté en tant que <?php echo \Security::e($_SESSION['user_name'] ?? ''); ?></span>
            <a href="<?php echo BASE_URL; ?>?controller=auth&action=account">Mon compte</a>
            <?php if (\Security::isAdmin()): ?>
                <a href="<?php echo BASE_URL; ?>?controller=admin&action=films">Admin films</a>
                <a href="<?php echo BASE_URL; ?>?controller=admin&action=seances">Admin séances</a>
                <a href="<?php echo BASE_URL; ?>?controller=admin&action=users">Admin utilisateurs</a>
            <?php endif; ?>
            <a href="<?php echo BASE_URL; ?>?controller=auth&action=logout">Déconnexion</a>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>?controller=auth&action=login">Connexion</a>
            <a href="<?php echo BASE_URL; ?>?controller=auth&action=register">Inscription</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="flash error">
            <?php echo \Security::e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="flash success">
            <?php echo \Security::e($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
        </div>
    <?php endif; ?>

