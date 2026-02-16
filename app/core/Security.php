<?php

class Security
{
    public static function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function currentUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            $_SESSION['flash_error'] = 'Vous devez être connecté pour accéder à cette page.';
            header('Location: ' . BASE_URL . '?controller=auth&action=login');
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        if (!self::isAdmin()) {
            http_response_code(403);
            echo 'Accès refusé.';
            exit;
        }
    }
}

