<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../../classes/Pact.php';
require_once __DIR__ . '/../classes/Toast.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    Toast::error('ID de pacto requerido');
    header('Location: /admin/dashboard');
    exit;
}

try {
    $pact = Pact::find($id);
    if ($pact === null) {
        Toast::error('Pacto no encontrado');
    } else {
        $pact->delete();
        Toast::success('Pacto eliminado exitosamente');
    }
} catch (Throwable $e) {
    Toast::error('Error al eliminar el pacto: ' . $e->getMessage());
}

header('Location: /admin/dashboard');
exit;
