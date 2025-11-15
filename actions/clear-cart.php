<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Cart.php';
require_once __DIR__ . '/../admin/classes/Toast.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /cart');
    exit;
}

Cart::clear();

// Marcar carrito en BD como cancelado si hay usuario logueado
if (isset($_SESSION['user_id'])) {
    Cart::cancelPendingCart((int)$_SESSION['user_id']);
}

Toast::info('Carrito vaciado');

header('Location: /cart');
exit;

