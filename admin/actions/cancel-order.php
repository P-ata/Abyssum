<?php
declare(strict_types=1);

require_once __DIR__ . '/../../classes/Order.php';
require_once __DIR__ . '/../classes/Toast.php';

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=admin&page=orders');
    exit;
}

$orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

if ($orderId <= 0) {
    Toast::error('Orden inválida');
    header('Location: /?sec=admin&page=orders');
    exit;
}

$order = Order::find($orderId);

if (!$order) {
    Toast::error('Orden no encontrada');
    header('Location: /?sec=admin&page=orders');
    exit;
}

// solo se puede cancelar si está pagado
if ($order->status !== 'paid') {
    Toast::error('Esta orden no puede ser cancelada');
    header('Location: /?sec=admin&page=orders');
    exit;
}

$order->cancel('Cancelada por el administrador');
Toast::warning("Orden #{$orderId} cancelada");

header('Location: /?sec=admin&page=orders');
exit;
