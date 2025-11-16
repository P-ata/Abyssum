<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Cart.php';
require_once __DIR__ . '/../admin/classes/Toast.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=cart');
    exit;
}

$pactId = isset($_POST['pact_id']) ? (int)$_POST['pact_id'] : 0;

if ($pactId <= 0) {
    Toast::error('Pacto inválido');
    header('Location: /?sec=cart');
    exit;
}

Cart::remove($pactId);

// Sincronizar con BD si hay usuario logueado
if (isset($_SESSION['user_id'])) {
    Cart::syncToDatabase((int)$_SESSION['user_id']);
}

Toast::info('Pacto eliminado del carrito');

header('Location: /?sec=cart');
exit;

