<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../classes/File.php';

header('Content-Type: application/json');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID inválido']);
    exit;
}

try {
    $deleted = File::delete($id);
    
    if ($deleted) {
        echo json_encode(['success' => true, 'message' => 'Archivo eliminado']);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Archivo no encontrado']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
