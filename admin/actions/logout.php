<?php
declare(strict_types=1);

// Asegurarse de que la sesión esté activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// limpiar todas las variables de sesión
$_SESSION = [];

// destruir la sesión
session_destroy();

// destruir la cookie de sesión si existe
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

// redirigir al login
header('Location: /?sec=admin&page=login');
exit;
