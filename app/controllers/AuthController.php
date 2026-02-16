<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Reservation.php';

class AuthController extends Controller
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = !empty($_POST['remember']);

            $user = User::findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $expiresAt = date('Y-m-d H:i:s', time() + REMEMBER_ME_DURATION);
                    User::setRememberToken((int)$user['id'], $token, $expiresAt);
                    setcookie(REMEMBER_ME_COOKIE, $token, time() + REMEMBER_ME_DURATION, BASE_URL, '', false, true);
                }

                $_SESSION['flash_success'] = 'Connexion réussie.';
                header('Location: ' . BASE_URL);
                exit;
            }

            $_SESSION['flash_error'] = 'Identifiants invalides.';
        }

        $this->render('auth/login');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if ($password !== $passwordConfirm) {
                $_SESSION['flash_error'] = 'Les mots de passe ne correspondent pas.';
                $this->render('auth/register');
                return;
            }

            if (strlen($password) < 6) {
                $_SESSION['flash_error'] = 'Le mot de passe doit contenir au moins 6 caractères.';
                $this->render('auth/register');
                return;
            }

            $created = User::create($name, $email, $password);

            if (!$created) {
                $_SESSION['flash_error'] = 'Impossible de créer le compte (email déjà utilisé ?).';
                $this->render('auth/register');
                return;
            }

            $_SESSION['flash_success'] = 'Compte créé, vous pouvez vous connecter.';
            header('Location: ' . BASE_URL . '?controller=auth&action=login');
            exit;
        }

        $this->render('auth/register');
    }

    public function logout(): void
    {
        if (!empty($_SESSION['user_id'])) {
            User::clearRememberToken((int)$_SESSION['user_id']);
        }

        setcookie(REMEMBER_ME_COOKIE, '', time() - 3600, BASE_URL);
        session_unset();
        session_destroy();

        session_start();
        $_SESSION['flash_success'] = 'Vous avez été déconnecté.';

        header('Location: ' . BASE_URL);
        exit;
    }

    public function account(): void
    {
        Security::requireLogin();

        $user = User::findById((int)Security::currentUserId());
        if (!$user) {
            $_SESSION['flash_error'] = 'Utilisateur introuvable.';
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $updated = User::updateUser((int)$user['id'], $name, $email, $password ?: null);

            if ($updated) {
                $_SESSION['user_name'] = $name;
                $_SESSION['flash_success'] = 'Compte mis à jour.';
                header('Location: ' . BASE_URL . '?controller=auth&action=account');
                exit;
            }

            $_SESSION['flash_error'] = 'Erreur lors de la mise à jour du compte.';
        }

        $this->render('auth/account', ['user' => $user]);
    }

    public function delete(): void
    {
        Security::requireLogin();

        $userId = (int)Security::currentUserId();
        Reservation::deleteByUser($userId);
        User::deleteUser($userId);

        setcookie(REMEMBER_ME_COOKIE, '', time() - 3600, BASE_URL);
        session_unset();
        session_destroy();

        session_start();
        $_SESSION['flash_success'] = 'Compte supprimé.';

        header('Location: ' . BASE_URL);
        exit;
    }
}

