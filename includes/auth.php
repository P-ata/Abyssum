<?php
declare(strict_types=1);

function isAdmin(): bool
{
    return isset($_SESSION['admin_id']);
}

function requireAdmin(): void
{
    if (!isAdmin()) {
        header('Location: /admin/login');
        exit;
    }
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: /login');
        exit;
    }
}

function getCurrentUser(): ?array
{
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'],
        'email' => $_SESSION['email'] ?? '',
        'name' => $_SESSION['name'] ?? '',
        'is_admin' => $_SESSION['is_admin'] ?? false
    ];
}