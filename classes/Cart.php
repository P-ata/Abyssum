<?php
declare(strict_types=1);

require_once __DIR__ . '/DbConnection.php';
require_once __DIR__ . '/Pact.php';

class Cart
{
    /**
     * Obtener items del carrito desde sesión
     * @return array Array de pact_ids
     */
    public static function getItems(): array
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        return $_SESSION['cart'];
    }

    /**
     * Agregar pacto al carrito (solo si no existe ya)
     * Los pactos son únicos, no se pueden agregar duplicados
     */
    public static function add(int $pactId): bool
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Verificar que el pacto existe
        $pact = Pact::find($pactId);
        if (!$pact) {
            return false;
        }

        // No agregar si ya está en el carrito (pactos únicos)
        if (in_array($pactId, $_SESSION['cart'])) {
            return false;
        }

        $_SESSION['cart'][] = $pactId;
        return true;
    }

    /**
     * Eliminar pacto del carrito
     */
    public static function remove(int $pactId): void
    {
        if (!isset($_SESSION['cart'])) {
            return;
        }

        $key = array_search($pactId, $_SESSION['cart']);
        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
            // Reindexar el array
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    /**
     * Vaciar carrito completo
     */
    public static function clear(): void
    {
        $_SESSION['cart'] = [];
    }

    /**
     * Obtener cantidad de items en carrito
     */
    public static function count(): int
    {
        return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    }

    /**
     * Obtener objetos Pact del carrito
     * @return Pact[]
     */
    public static function getPacts(): array
    {
        $items = self::getItems();
        if (empty($items)) {
            return [];
        }

        $pacts = [];
        foreach ($items as $pactId) {
            $pact = Pact::find($pactId);
            if ($pact) {
                $pacts[] = $pact;
            }
        }

        return $pacts;
    }

    /**
     * Calcular total en créditos
     */
    public static function getTotal(): int
    {
        $pacts = self::getPacts();
        $total = 0;
        foreach ($pacts as $pact) {
            $total += $pact->price_credits;
        }
        return $total;
    }

    /**
     * Verificar si un pacto está en el carrito
     */
    public static function has(int $pactId): bool
    {
        return in_array($pactId, self::getItems());
    }

    /**
     * Sincronizar carrito de sesión con base de datos
     * Crea o actualiza el carrito "pending" del usuario
     */
    public static function syncToDatabase(int $userId): void
    {
        $items = self::getItems();
        
        // Si el carrito está vacío, cancelar carrito pendiente si existe
        if (empty($items)) {
            self::cancelPendingCart($userId);
            return;
        }

        $pdo = DbConnection::get();
        
        // Buscar carrito pendiente existente
        $stmt = $pdo->prepare('SELECT id FROM carts WHERE user_id = ? AND status = "pending" ORDER BY created_at DESC LIMIT 1');
        $stmt->execute([$userId]);
        $existingCart = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $pacts = self::getPacts();
        $total = self::getTotal();
        
        if ($existingCart) {
            // Actualizar carrito existente
            $cartId = (int)$existingCart['id'];
            
            $stmt = $pdo->prepare('UPDATE carts SET total_credits = ?, updated_at = NOW() WHERE id = ?');
            $stmt->execute([$total, $cartId]);
            
            // Eliminar items antiguos y agregar nuevos
            $stmt = $pdo->prepare('DELETE FROM cart_items WHERE cart_id = ?');
            $stmt->execute([$cartId]);
        } else {
            // Crear nuevo carrito
            $stmt = $pdo->prepare('INSERT INTO carts (user_id, status, total_credits) VALUES (?, "pending", ?)');
            $stmt->execute([$userId, $total]);
            $cartId = (int)$pdo->lastInsertId();
        }
        
        // Insertar items actuales
        foreach ($pacts as $pact) {
            $price = $pact->price_credits;
            $stmt = $pdo->prepare('INSERT INTO cart_items (cart_id, pact_id, quantity, unit_price_credits, subtotal_credits) VALUES (?, ?, 1, ?, ?)');
            $stmt->execute([$cartId, $pact->id, $price, $price]);
        }
    }

    /**
     * Cancelar carrito pendiente del usuario
     */
    public static function cancelPendingCart(int $userId): void
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('UPDATE carts SET status = "cancelled", updated_at = NOW() WHERE user_id = ? AND status = "pending"');
        $stmt->execute([$userId]);
    }

    /**
     * Marcar carritos abandonados (más de X horas sin actualizar)
     */
    public static function markAbandoned(int $hoursInactive = 24): int
    {
        $pdo = DbConnection::get();
        $sql = 'UPDATE carts 
                SET status = "abandoned", updated_at = NOW() 
                WHERE status = "pending" 
                AND updated_at < DATE_SUB(NOW(), INTERVAL ? HOUR)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$hoursInactive]);
        return $stmt->rowCount();
    }

    /**
     * Cargar carrito pendiente desde BD a sesión
     * Útil al iniciar sesión para recuperar carrito
     */
    public static function loadFromDatabase(int $userId): bool
    {
        $pdo = DbConnection::get();
        
        // Buscar carrito pendiente más reciente
        $stmt = $pdo->prepare('SELECT id FROM carts WHERE user_id = ? AND status = "pending" ORDER BY updated_at DESC LIMIT 1');
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$cart) {
            return false;
        }
        
        // Obtener items
        $stmt = $pdo->prepare('SELECT pact_id FROM cart_items WHERE cart_id = ?');
        $stmt->execute([(int)$cart['id']]);
        $items = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'pact_id');
        
        // Cargar en sesión
        $_SESSION['cart'] = array_map('intval', $items);
        
        return true;
    }
}

