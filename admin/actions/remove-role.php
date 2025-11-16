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
$roleId = (int)($_POST['role_id'] ?? 0);

if ($userId === 0 || $roleId === 0) {
	Toast::error('Datos inválidos');
	header('Location: /?sec=admin&page=users');
	exit;
}

User::removeRole($userId, $roleId);

Toast::success('Rol removido correctamente');
header('Location: /?sec=admin&page=users');
exit;
