<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Cart.php';
require_once __DIR__ . '/../classes/DbConnection.php';
require_once __DIR__ . '/../classes/Toast.php';
require_once __DIR__ . '/../includes/auth.php';

// logueado para carrito
if (!isLoggedIn()) {
    Toast::error('Debes iniciar sesión para completar la compra');
    header('Location: /?sec=login&return=' . urlencode('/?sec=cart'));
    exit;
}

//solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=cart');
    exit;
}

$userId = $_SESSION['user_id'];
$pacts = Cart::getPacts();
$total = Cart::getTotal();

if (empty($pacts)) {
    Toast::error('El carrito está vacío');
    header('Location: /?sec=cart');
    exit;
}

try {
    $pdo = DbConnection::get();
    $pdo->beginTransaction();

    // se crea el cart 
    $stmtCart = $pdo->prepare('
        INSERT INTO carts (user_id, status, total_credits, currency)
        VALUES (?, ?, ?, ?)
    ');
    $stmtCart->execute([$userId, 'completed', $total, 'CREDITOS']);
    $cartId = (int)$pdo->lastInsertId();

    // se crea la orden
    $stmtOrder = $pdo->prepare('
        INSERT INTO orders (user_id, cart_id, status, total_credits, currency, placed_at, paid_at)
        VALUES (?, ?, ?, ?, ?, NOW(), NOW())
    ');
    $stmtOrder->execute([$userId, $cartId, 'paid', $total, 'CREDITOS']);
    $orderId = (int)$pdo->lastInsertId();

    // se insertan items del carrito
    $stmtCartItem = $pdo->prepare('
        INSERT INTO cart_items (cart_id, pact_id, quantity, unit_price_credits, subtotal_credits)
        VALUES (?, ?, 1, ?, ?)
    ');

    // se insertan items de la orden (con snapshot del pacto para que no se cambie)
    $stmtOrderItem = $pdo->prepare('
        INSERT INTO order_items (order_id, pact_id, unit_price_credits, subtotal_credits, snapshot)
        VALUES (?, ?, ?, ?, ?)
    ');

    foreach ($pacts as $pact) {
        $price = $pact->price_credits;
        
        // se insertan en cart_items
        $stmtCartItem->execute([$cartId, $pact->id, $price, $price]);
        
        // se obtiene el nombre del demonio
        $stmtDemon = $pdo->prepare('SELECT name FROM demons WHERE id = ?');
        $stmtDemon->execute([$pact->demon_id]);
        $demonName = $stmtDemon->fetchColumn();
        
        // aca se crea la snapshot JSON del pacto
        $snapshot = json_encode([
            'name' => $pact->name,
            'summary' => $pact->summary,
            'duration' => $pact->duration,
            'cooldown' => $pact->cooldown,
            'limitations' => $pact->limitations,
            'demon_id' => $pact->demon_id,
            'demon_name' => $demonName,
            'image_file_id' => $pact->image_file_id
        ]);
        
        // se inserta ahora si en order_items
        $stmtOrderItem->execute([$orderId, $pact->id, $price, $price, $snapshot]);
    }

    $pdo->commit();

    // se vacia el carrito de la sesion
    Cart::clear();

    Toast::success("¡Compra completada! Orden #{$orderId} - Total: {$total} ⛧");
    header('Location: /?sec=orders');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    
    Toast::error('Error al procesar la compra: ' . $e->getMessage());
    header('Location: /?sec=cart');
    exit;
}
