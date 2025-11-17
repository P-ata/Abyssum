<?php
declare(strict_types=1);

// aseguramos de que se inicie una sesión
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/User.php';

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=admin&page=login');
    exit;
}

// si ya logueo vamos al dashboard
if (isAdmin()) {
    header('Location: /?sec=admin&page=dashboard');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// verificar credenciales
$user = User::verifyPassword($email, $password);

if (!$user) {
    $_SESSION['login_error'] = 'Email o contraseña incorrectos';
    header('Location: /?sec=admin&page=login');
    exit;
}

// verificar si está activo
if (!$user->is_active) {
    $_SESSION['login_error'] = 'Tu cuenta está desactivada';
    header('Location: /?sec=admin&page=login');
    exit;
}

// verificar si es admin
if (!$user->isAdmin()) {
    $_SESSION['login_error'] = 'No tienes permisos de administrador';
    header('Location: /?sec=admin&page=login');
    exit;
}

// login exitoso
session_regenerate_id(true);
$_SESSION['admin_id'] = $user->id;
$_SESSION['admin_email'] = $user->email;

// actualizar último login
User::updateLastLogin($user->id);

header('Location: /?sec=admin&page=dashboard');
exit;
