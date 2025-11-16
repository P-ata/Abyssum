<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../../classes/Pact.php';
require_once __DIR__ . '/../classes/Toast.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    Toast::error('ID de pacto requerido');
    header('Location: /?sec=admin&page=dashboard');
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

header('Location: /?sec=admin&page=dashboard');
exit;
