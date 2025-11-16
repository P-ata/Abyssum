<?php
declare(strict_types=1);

require_once __DIR__ . '/DbConnection.php';

class Order
{
    public int $id;
    public ?int $user_id = null;
    public ?int $cart_id = null;
    public string $status; // placed, paid, fulfilled, refunded, cancelled
    public int $total_credits;
    public string $currency = 'CREDITOS';
    public string $placed_at;
    public ?string $paid_at = null;
    public ?string $fulfilled_at = null;
    public ?string $cancelled_at = null;
    public ?string $notes = null;
    public string $created_at;
    public string $updated_at;
    
    // Datos relacionados
    public ?string $user_email = null;
    public ?string $user_name = null;
    public array $items = [];

    public static function fromRow(array $row): self
    {
        $order = new self();
        $order->id = (int)$row['id'];
        $order->user_id = isset($row['user_id']) ? (int)$row['user_id'] : null;
        $order->cart_id = isset($row['cart_id']) ? (int)$row['cart_id'] : null;
        $order->status = $row['status'];
        $order->total_credits = (int)$row['total_credits'];
        $order->currency = $row['currency'];
        $order->placed_at = $row['placed_at'];
        $order->paid_at = $row['paid_at'] ?? null;
        $order->fulfilled_at = $row['fulfilled_at'] ?? null;
        $order->cancelled_at = $row['cancelled_at'] ?? null;
        $order->notes = $row['notes'] ?? null;
        $order->created_at = $row['created_at'];
        $order->updated_at = $row['updated_at'];
        
        // Datos de usuario si están disponibles
        $order->user_email = $row['user_email'] ?? null;
        $order->user_name = $row['user_name'] ?? null;
        
        return $order;
    }

    /**
     * Obtener todas las órdenes (para admin)
     */
    public static function all(): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT o.*, u.email as user_email, u.display_name as user_name
                FROM orders o
                LEFT JOIN users u ON u.id = o.user_id
                ORDER BY o.created_at DESC';
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * Obtener órdenes de un usuario específico
     */
    public static function byUser(int $userId): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT o.*, u.email as user_email, u.display_name as user_name
                FROM orders o
                LEFT JOIN users u ON u.id = o.user_id
                WHERE o.user_id = ?
                ORDER BY o.created_at DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * Contar órdenes de un usuario
     */
    public static function countByUser(int $userId): int
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT COUNT(*) FROM orders WHERE user_id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Encontrar orden por ID
     */
    public static function find(int $id): ?self
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT o.*, u.email as user_email, u.display_name as user_name
                FROM orders o
                LEFT JOIN users u ON u.id = o.user_id
                WHERE o.id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::fromRow($row) : null;
    }

    /**
     * Obtener items de la orden
     */
    public function getItems(): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT oi.*, p.name as pact_name, p.slug as pact_slug
                FROM order_items oi
                LEFT JOIN pacts p ON p.id = oi.pact_id
                WHERE oi.order_id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Cancelar orden
     */
    public function cancel(?string $reason = null): void
    {
        $pdo = DbConnection::get();
        $sql = 'UPDATE orders 
                SET status = ?, cancelled_at = NOW(), notes = ?
                WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cancelled', $reason, $this->id]);
    }

    /**
     * Marcar como completada (admin otorga los pactos)
     */
    public function fulfill(): void
    {
        $pdo = DbConnection::get();
        $sql = 'UPDATE orders 
                SET status = ?, fulfilled_at = NOW()
                WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['fulfilled', $this->id]);
    }

    /**
     * Obtener estadísticas de órdenes
     */
    public static function getStats(): array
    {
        $pdo = DbConnection::get();
        
        $stats = [
            'total' => 0,
            'paid' => 0,
            'fulfilled' => 0,
            'cancelled' => 0,
            'total_revenue' => 0
        ];
        
        // Contar por estado
        $sql = "SELECT status, COUNT(*) as count, SUM(total_credits) as revenue
                FROM orders
                GROUP BY status";
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row) {
            $stats['total'] += (int)$row['count'];
            $stats[$row['status']] = (int)$row['count'];
            if ($row['status'] === 'paid' || $row['status'] === 'fulfilled') {
                $stats['total_revenue'] += (int)$row['revenue'];
            }
        }
        
        return $stats;
    }

    /**
     * Obtener IDs de pactos ya comprados por un usuario
     * @return int[]
     */
    public static function getPurchasedPactIds(int $userId): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT DISTINCT oi.pact_id 
                FROM order_items oi
                JOIN orders o ON o.id = oi.order_id
                WHERE o.user_id = ? 
                AND o.status IN ("paid", "fulfilled")';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'pact_id');
    }

    /**
     * Verificar si un usuario ya compró un pacto específico
     */
    public static function hasPurchased(int $userId, int $pactId): bool
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT COUNT(*) as count
                FROM order_items oi
                JOIN orders o ON o.id = oi.order_id
                WHERE o.user_id = ? 
                AND oi.pact_id = ?
                AND o.status IN ("paid", "fulfilled")';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $pactId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['count'] ?? 0) > 0;
    }
}

