<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/User.php';

// Solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /register');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$displayName = trim($_POST['display_name'] ?? '');

// Validaciones
if (empty($email) || empty($password) || empty($displayName)) {
    $_SESSION['error'] = 'Todos los campos son obligatorios';
    header('Location: /register');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Email inválido';
    header('Location: /register');
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres';
    header('Location: /register');
    exit;
}

// Verificar si el email ya existe
if (User::findByEmail($email)) {
    $_SESSION['error'] = 'Este email ya está registrado';
    header('Location: /register');
    exit;
}

try {
    // Crear usuario
    $userId = User::create($email, $password, $displayName);
    
    // Actualizar último login inmediatamente después de crear la cuenta
    User::updateLastLogin($userId);
    
    // Auto-login
    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $displayName;
    $_SESSION['is_admin'] = false;
    
    $_SESSION['success'] = '¡Cuenta creada exitosamente!';
    header('Location: /');
    exit;
    
} catch (Exception $e) {
    $_SESSION['error'] = 'Error al crear la cuenta. Intentá de nuevo.';
    header('Location: /register');
    exit;
}
