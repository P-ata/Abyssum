<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Cart.php';
require_once __DIR__ . '/../classes/Order.php';
require_once __DIR__ . '/../admin/classes/Toast.php';
require_once __DIR__ . '/../includes/auth.php';

// Requiere estar logueado para agregar al carrito
if (!isLoggedIn()) {
    Toast::warning('Debes iniciar sesión para agregar pactos al carrito');
    header('Location: /login?return=' . urlencode('/pacts'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pacts');
    exit;
}

$pactId = isset($_POST['pact_id']) ? (int)$_POST['pact_id'] : 0;
$userId = (int)$_SESSION['user_id'];

if ($pactId <= 0) {
    Toast::error('Pacto inválido');
    header('Location: /pacts');
    exit;
}

// Verificar si ya fue comprado
if (Order::hasPurchased($userId, $pactId)) {
    Toast::warning('Ya has adquirido este pacto anteriormente');
    header('Location: /pacts');
    exit;
}

// Intentar agregar al carrito
$added = Cart::add($pactId);

if ($added) {
    // Sincronizar con base de datos
    Cart::syncToDatabase($userId);
    Toast::success('Pacto agregado al carrito');
} else {
    Toast::warning('El pacto ya está en tu carrito');
}if ($added) {
    Toast::success('Pacto agregado al carrito');
} else {
    // Verificar si ya estaba en el carrito
    if (Cart::has($pactId)) {
        Toast::warning('Este pacto ya está en tu carrito');
    } else {
        Toast::error('No se pudo agregar el pacto');
    }
}

header('Location: /pacts');
exit;
