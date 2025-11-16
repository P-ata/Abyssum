<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Order.php';
require_once __DIR__ . '/../admin/classes/Toast.php';
require_once __DIR__ . '/../includes/auth.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=orders');
    exit;
}

$orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

if ($orderId <= 0) {
    Toast::error('Orden inválida');
    header('Location: /?sec=orders');
    exit;
}

$order = Order::find($orderId);

if (!$order) {
    Toast::error('Orden no encontrada');
    header('Location: /?sec=orders');
    exit;
}

// Verificar que la orden pertenece al usuario
if ($order->user_id !== $_SESSION['user_id']) {
    Toast::error('No tienes permiso para cancelar esta orden');
    header('Location: /?sec=orders');
    exit;
}

// Solo se puede cancelar si está en estado 'paid'
if ($order->status !== 'paid') {
    Toast::error('Esta orden no puede ser cancelada');
    header('Location: /?sec=orders');
    exit;
}

$order->cancel('Cancelada por el usuario');
Toast::success('Orden cancelada exitosamente');

header('Location: /?sec=orders');
exit;
