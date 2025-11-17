<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../classes/Toast.php';

requireAdmin();

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: /?sec=admin&page=users');
	exit;
}

$userId = (int)($_POST['user_id'] ?? 0);
$active = (int)($_POST['active'] ?? 0);

if ($userId === 0) {
	Toast::error('ID de usuario inválido');
	header('Location: /?sec=admin&page=users');
	exit;
}

// no desactivarnos a nosotros mismos
if ($userId === $_SESSION['admin_id']) {
	Toast::error('No puedes desactivar tu propia cuenta');
	header('Location: /?sec=admin&page=users');
	exit;
}

User::setActive($userId, (bool)$active);

Toast::success($active ? 'Usuario activado correctamente' : 'Usuario desactivado correctamente');
header('Location: /?sec=admin&page=users');
exit;
