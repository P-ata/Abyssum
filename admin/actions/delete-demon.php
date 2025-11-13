<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../../classes/Demon.php';
require_once __DIR__ . '/../classes/Toast.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    Toast::error('ID de demonio requerido');
    header('Location: /admin/dashboard');
    exit;
}

try {
    $demon = Demon::findBySlug($id);
    if ($demon === null) {
        Toast::error('Demonio no encontrado');
    } else {
        $demon->delete();
        Toast::success('Demonio eliminado exitosamente');
    }
} catch (Throwable $e) {
    Toast::error('Error al eliminar el demonio: ' . $e->getMessage());
}

header('Location: /admin/dashboard');
exit;
