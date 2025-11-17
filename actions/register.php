<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Toast.php';

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=register');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$displayName = trim($_POST['display_name'] ?? '');

// validaciones
if (empty($email) || empty($password) || empty($displayName)) {
    Toast::error('Todos los campos son obligatorios');
    header('Location: /?sec=register');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    Toast::error('Email inválido');
    header('Location: /?sec=register');
    exit;
}

if (strlen($password) < 6) {
    Toast::error('La contraseña debe tener al menos 6 caracteres');
    header('Location: /?sec=register');
    exit;
}

// se verifica si el email ya existe
if (User::findByEmail($email)) {
    Toast::error('Este email ya está registrado');
    header('Location: /?sec=register');
    exit;
}

try {
    // se crea el usuario
    $userId = User::create($email, $password, $displayName);
    
    // se actualiza el último login 
    User::updateLastLogin($userId);
    
    // auto login
    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $displayName;
    $_SESSION['is_admin'] = false;
    
    Toast::success('¡Cuenta creada exitosamente!');
    header('Location: /?sec=abyssum');
    exit;
    
} catch (Exception $e) {
    $_SESSION['error'] = 'Error al crear la cuenta. Intentá de nuevo.';
    header('Location: /?sec=register');
    exit;
}
