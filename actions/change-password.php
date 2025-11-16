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
$currentPassword = trim($_POST['current_password'] ?? '');
$newPassword = trim($_POST['new_password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');

// Validaciones
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    Toast::error('Todos los campos son obligatorios');
    header('Location: /?sec=profile');
    exit;
}

if (strlen($newPassword) < 6) {
    Toast::error('La nueva contraseña debe tener al menos 6 caracteres');
    header('Location: /?sec=profile');
    exit;
}

if ($newPassword !== $confirmPassword) {
    Toast::error('Las contraseñas no coinciden');
    header('Location: /?sec=profile');
    exit;
}

try {
    // Verificar contraseña actual
    $pdo = DbConnection::get();
    $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$row || !password_verify($currentPassword, $row['password_hash'])) {
        Toast::error('La contraseña actual es incorrecta');
        header('Location: /?sec=profile');
        exit;
    }
    
    // Actualizar contraseña
    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
    $stmt->execute([$newHash, $userId]);
    
    Toast::success('Contraseña actualizada correctamente');
    header('Location: /?sec=profile');
    exit;
    
} catch (Exception $e) {
    Toast::error('Error al cambiar la contraseña');
    header('Location: /?sec=profile');
    exit;
}
