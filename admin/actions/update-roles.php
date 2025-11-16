<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../classes/Toast.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: /?sec=admin&page=users');
	exit;
}

$userId = (int)($_POST['user_id'] ?? 0);
$isAdmin = (int)($_POST['is_admin'] ?? 0);

if ($userId === 0) {
	Toast::error('ID de usuario inválido');
	header('Location: /?sec=admin&page=users');
	exit;
}

// Si debe ser admin
if ($isAdmin === 1) {
	User::assignRole($userId, 1); // Asignar rol admin
	Toast::success('Rol de administrador asignado correctamente');
} else {
	User::removeRole($userId, 1); // Quitar rol admin
	Toast::success('Rol de administrador removido correctamente');
}

header('Location: /?sec=admin&page=users');
exit;
