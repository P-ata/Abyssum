<?php
declare(strict_types=1);

// ACCIÓN de logout (destruye sesión y redirige) — PRG pattern
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Limpiar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Destruir la cookie de sesión si existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirect al login (PRG)
header('Location: /admin/login');
exit;
