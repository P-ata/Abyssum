<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Cart.php';
require_once __DIR__ . '/../admin/classes/Toast.php';

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=cart');
    exit;
}

Cart::clear();

// se da de baja el carrito como cancelado
if (isset($_SESSION['user_id'])) {
    Cart::cancelPendingCart((int)$_SESSION['user_id']);
}

Toast::info('Carrito vaciado');

header('Location: /?sec=cart');
exit;

