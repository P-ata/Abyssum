<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/DbConnection.php';
require_once __DIR__ . '/../classes/Toast.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=profile');
    exit;
}

$userId = $_SESSION['user_id'];
$email = trim($_POST['email'] ?? '');
$displayName = trim($_POST['display_name'] ?? '');

// validaciones
if (empty($email) || empty($displayName)) {
    Toast::error('Todos los campos son obligatorios');
    header('Location: /?sec=profile');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    Toast::error('Email inválido');
    header('Location: /?sec=profile');
    exit;
}

// se verifica si el email ya existe (y no es el del usuario actual)
$existingUser = User::findByEmail($email);
if ($existingUser && $existingUser->id !== $userId) {
    Toast::error('Este email ya está en uso por otra cuenta');
    header('Location: /?sec=profile');
    exit;
}

try {
    $pdo = DbConnection::get();
    $stmt = $pdo->prepare('UPDATE users SET email = ?, display_name = ? WHERE id = ?');
    $stmt->execute([$email, $displayName, $userId]);
    
    // actualizamos la sesión
    $_SESSION['email'] = $email;
    $_SESSION['user_name'] = $displayName;
    
    Toast::success('Perfil actualizado correctamente');
    header('Location: /?sec=profile');
    exit;
    
} catch (Exception $e) {
    Toast::error('Error al actualizar el perfil');
    header('Location: /?sec=profile');
    exit;
}
