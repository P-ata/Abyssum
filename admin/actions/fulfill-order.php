<?php
declare(strict_types=1);

require_once __DIR__ . '/../../classes/Order.php';
require_once __DIR__ . '/../classes/Toast.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/orders');
    exit;
}

$orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

if ($orderId <= 0) {
    Toast::error('Orden inválida');
    header('Location: /admin/orders');
    exit;
}

$order = Order::find($orderId);

if (!$order) {
    Toast::error('Orden no encontrada');
    header('Location: /admin/orders');
    exit;
}

// Solo se puede completar si está en estado 'paid'
if ($order->status !== 'paid') {
    Toast::error('Esta orden no puede ser completada');
    header('Location: /admin/orders');
    exit;
}

$order->fulfill();
Toast::success("Orden #{$orderId} completada. Pactos otorgados al usuario.");

header('Location: /admin/orders');
exit;
