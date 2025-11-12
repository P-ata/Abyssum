<?php
declare(strict_types=1);

// ACCIÓN de login (solo POST) — PRG pattern
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/login');
    exit;
}

// Si ya está logueado, redirigir al dashboard
if (isAdmin()) {
    header('Location: /admin/dashboard');
    exit;
}

$email = trim($_POST['email'] ?? '');
$pass  = trim($_POST['password'] ?? '');

// Credenciales de ejemplo (TODO: mover a DB)
$validEmail = 'admin@demons.test';
$validPass  = 'secreto123';

if ($email === $validEmail && $pass === $validPass) {
    // Login exitoso
    // Regenerar session ID PRIMERO por seguridad
    session_regenerate_id(true);
    
    // Luego setear datos
    $_SESSION['admin_id'] = 1;
    $_SESSION['admin_email'] = $email;
    
    // Redirect a dashboard (PRG)
    header('Location: /admin/dashboard');
    exit;
} else {
    // Login fallido — guardar error en sesión (flash message)
    $_SESSION['login_error'] = 'Credenciales inválidas. Verifica tu email y contraseña.';
    
    // Redirect de vuelta al formulario (PRG)
    header('Location: /admin/login');
    exit;
}
