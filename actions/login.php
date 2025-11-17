<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Toast.php';

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=login');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// se verifican las credenciales
$user = User::verifyPassword($email, $password);

if (!$user) {
    Toast::error('Email o contraseña incorrectos');
    header('Location: /?sec=login');
    exit;
}

// se verifica si está activo
if (!$user->is_active) {
    Toast::error('Tu cuenta está desactivada. Contactá al administrador.');
    header('Location: /?sec=login');
    exit;
}


// login exitoso
session_regenerate_id(true);
$_SESSION['user_id'] = $user->id;
$_SESSION['email'] = $user->email;
$_SESSION['user_name'] = $user->display_name;
$_SESSION['is_admin'] = $user->isAdmin();

// se actualiza el último login
User::updateLastLogin($user->id);

// se carga carrito pendiente desde BD si existe
require_once __DIR__ . '/../classes/Cart.php';
Cart::loadFromDatabase($user->id);

// login público siempre redirige al home
header('Location: /?sec=abyssum');
exit;

