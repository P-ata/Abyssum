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