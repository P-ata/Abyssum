<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Cart.php';
require_once __DIR__ . '/../classes/DbConnection.php';
require_once __DIR__ . '/../admin/classes/Toast.php';
require_once __DIR__ . '/../includes/auth.php';

// Requiere estar logueado
if (!isLoggedIn()) {
    Toast::error('Debes iniciar sesión para completar la compra');
    header('Location: /login?return=' . urlencode('/cart'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /cart');
    exit;
}

$userId = $_SESSION['user_id'];
$pacts = Cart::getPacts();
$total = Cart::getTotal();

if (empty($pacts)) {
    Toast::error('El carrito está vacío');
    header('Location: /cart');
    exit;
}

try {
    $pdo = DbConnection::get();
    $pdo->beginTransaction();

    // 1. Crear el carrito en la tabla carts
    $stmtCart = $pdo->prepare('
        INSERT INTO carts (user_id, status, total_credits, currency)
        VALUES (?, ?, ?, ?)
    ');
    $stmtCart->execute([$userId, 'completed', $total, 'CREDITOS']);
    $cartId = (int)$pdo->lastInsertId();

    // 2. Crear la orden
    $stmtOrder = $pdo->prepare('
        INSERT INTO orders (user_id, cart_id, status, total_credits, currency, placed_at, paid_at)
        VALUES (?, ?, ?, ?, ?, NOW(), NOW())
    ');
    $stmtOrder->execute([$userId, $cartId, 'paid', $total, 'CREDITOS']);
    $orderId = (int)$pdo->lastInsertId();

    // 3. Insertar items del carrito
    $stmtCartItem = $pdo->prepare('
        INSERT INTO cart_items (cart_id, pact_id, quantity, unit_price_credits, subtotal_credits)
        VALUES (?, ?, 1, ?, ?)
    ');

    // 4. Insertar items de la orden (con snapshot del pacto)
    $stmtOrderItem = $pdo->prepare('
        INSERT INTO order_items (order_id, pact_id, unit_price_credits, subtotal_credits, snapshot)
        VALUES (?, ?, ?, ?, ?)
    ');

    foreach ($pacts as $pact) {
        $price = $pact->price_credits;
        
        // Insertar en cart_items
        $stmtCartItem->execute([$cartId, $pact->id, $price, $price]);
        
        // Crear snapshot JSON del pacto
        $snapshot = json_encode([
            'name' => $pact->name,
            'summary' => $pact->summary,
            'duration' => $pact->duration,
            'cooldown' => $pact->cooldown,
            'limitations' => $pact->limitations,
            'demon_id' => $pact->demon_id
        ]);
        
        // Insertar en order_items
        $stmtOrderItem->execute([$orderId, $pact->id, $price, $price, $snapshot]);
    }

    $pdo->commit();

    // Vaciar el carrito de la sesión
    Cart::clear();

    Toast::success("¡Compra completada! Orden #{$orderId} - Total: {$total} ⛧");
    header('Location: /profile');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    
    Toast::error('Error al procesar la compra: ' . $e->getMessage());
    header('Location: /cart');
    exit;
}
