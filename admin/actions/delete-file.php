<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../classes/File.php';
require_once __DIR__ . '/../classes/Toast.php';

// return a la pagina de donde vino
$returnTo = isset($_GET['return_to']) ? htmlspecialchars($_GET['return_to']) : 'dashboard';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    Toast::error('ID de archivo inválido');
    header('Location: /?sec=admin&page=' . $returnTo);
    exit;
}

try {
    $deleted = File::deleteById($id);
    
    if ($deleted) {
        Toast::success('Archivo eliminado exitosamente');
    } else {
        Toast::error('Archivo no encontrado');
    }
} catch (Throwable $e) {
    Toast::error('Error al eliminar el archivo: ' . $e->getMessage());
}

header('Location: /?sec=admin&page=' . $returnTo);
exit;
