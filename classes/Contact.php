<?php
declare(strict_types=1);

require_once __DIR__ . '/DbConnection.php';

class Contact
{
    public int $id;
    public string $name;
    public string $email;
    public ?string $subject = null;
    public string $message;
    public string $status = 'new'; // new, in_progress, resolved, spam
    public string $sent_at;
    public ?string $ip_address = null;
    public ?int $handled_by = null;
    public ?string $handled_at = null;
    public string $created_at;
    public string $updated_at;
    
    // Datos relacionados
    public ?string $handler_name = null;

    public static function fromRow(array $row): self
    {
        $contact = new self();
        $contact->id = (int)$row['id'];
        $contact->name = $row['name'];
        $contact->email = $row['email'];
        $contact->subject = $row['subject'] ?? null;
        $contact->message = $row['message'];
        $contact->status = $row['status'];
        $contact->sent_at = $row['sent_at'];
        $contact->ip_address = $row['ip_address'] ?? null;
        $contact->handled_by = isset($row['handled_by']) ? (int)$row['handled_by'] : null;
        $contact->handled_at = $row['handled_at'] ?? null;
        $contact->created_at = $row['created_at'];
        $contact->updated_at = $row['updated_at'];
        
        $contact->handler_name = $row['handler_name'] ?? null;
        
        return $contact;
    }

    /**
     * Crear nuevo contacto
     */
    public static function create(array $data): int
    {
        $pdo = DbConnection::get();
        
        $sql = 'INSERT INTO contacts (name, email, subject, message, ip_address) 
                VALUES (?, ?, ?, ?, ?)';
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['subject'] ?? null,
            $data['message'],
            $data['ip_address'] ?? null
        ]);
        
        return (int)$pdo->lastInsertId();
    }

    /**
     * Obtener todos los contactos (para admin)
     */
    public static function all(): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT c.*, u.display_name as handler_name
                FROM contacts c
                LEFT JOIN users u ON u.id = c.handled_by
                ORDER BY c.sent_at DESC';
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * Obtener contactos por estado
     */
    public static function byStatus(string $status): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT c.*, u.display_name as handler_name
                FROM contacts c
                LEFT JOIN users u ON u.id = c.handled_by
                WHERE c.status = ?
                ORDER BY c.sent_at DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$status]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * Encontrar contacto por ID
     */
    public static function find(int $id): ?self
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT c.*, u.display_name as handler_name
                FROM contacts c
                LEFT JOIN users u ON u.id = c.handled_by
                WHERE c.id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::fromRow($row) : null;
    }

    /**
     * Actualizar estado del contacto
     */
    public function updateStatus(string $status, ?int $handlerId = null): void
    {
        $pdo = DbConnection::get();
        
        if ($handlerId !== null) {
            $sql = 'UPDATE contacts 
                    SET status = ?, handled_by = ?, handled_at = NOW()
                    WHERE id = ?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$status, $handlerId, $this->id]);
        } else {
            $sql = 'UPDATE contacts SET status = ? WHERE id = ?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$status, $this->id]);
        }
    }

    /**
     * Marcar como spam
     */
    public function markAsSpam(): void
    {
        $this->updateStatus('spam');
    }

    /**
     * Obtener estadísticas
     */
    public static function getStats(): array
    {
        $pdo = DbConnection::get();
        
        $stats = [
            'total' => 0,
            'new' => 0,
            'in_progress' => 0,
            'resolved' => 0,
            'spam' => 0
        ];
        
        $sql = "SELECT status, COUNT(*) as count FROM contacts GROUP BY status";
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row) {
            $stats['total'] += (int)$row['count'];
            $stats[$row['status']] = (int)$row['count'];
        }
        
        return $stats;
    }
}
