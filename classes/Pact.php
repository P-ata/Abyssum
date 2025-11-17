<?php
declare(strict_types=1);

require_once __DIR__ . '/DbConnection.php';
require_once __DIR__ . '/Category.php';

class Pact
{
    public int $id;
    public ?string $slug = null;
    public int $demon_id;
    public string $name;
    public ?string $summary = null;
    public ?string $duration = null;
    public ?string $cooldown = null;
    public ?array $limitations = null; // JSON array
    public int $price_credits = 0;
    public ?int $image_file_id = null;
    public string $created_at;
    public string $updated_at;

    /**
     * @param array<string, mixed> $row
     */
    public static function fromRow(array $row): self
    {
        $p = new self();
        $p->id = (int)$row['id'];
        $p->slug = $row['slug'] ?? null;
        $p->demon_id = (int)$row['demon_id'];
        $p->name = $row['name'];
        $p->summary = $row['summary'] ?? null;
        $p->duration = $row['duration'] ?? null;
        $p->cooldown = $row['cooldown'] ?? null;
        $p->limitations = isset($row['limitations']) ? json_decode($row['limitations'], true) : null;
        $p->price_credits = (int)$row['price_credits'];
        $p->image_file_id = isset($row['image_file_id']) ? (int)$row['image_file_id'] : null;
        $p->created_at = $row['created_at'] ?? '';
        $p->updated_at = $row['updated_at'] ?? '';
        return $p;
    }

    /**
     * @return Pact[]
     */
    public static function all(): array
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->query('SELECT id, slug, demon_id, name, summary, duration, cooldown, limitations, price_credits, image_file_id, created_at, updated_at FROM pacts ORDER BY created_at DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * filtrar pactos por varios criterios
     * @param array<string, mixed> $filters
     * @return Pact[]
     */
    public static function filter(array $filters = []): array
    {
        $pdo = DbConnection::get();
        
        $sql = 'SELECT DISTINCT p.id, p.slug, p.demon_id, p.name, p.summary, p.duration, p.cooldown, p.limitations, p.price_credits, p.image_file_id, p.created_at, p.updated_at FROM pacts p';
        $where = [];
        $params = [];
        $joins = [];

        // filtrar por demonio
        if (!empty($filters['demon_id'])) {
            $where[] = 'p.demon_id = ?';
            $params[] = (int)$filters['demon_id'];
        }

        // filtrar por categoría
        if (!empty($filters['category'])) {
            $joins[] = 'INNER JOIN pact_categories pc ON p.id = pc.pact_id';
            $where[] = 'pc.category_slug = ?';
            $params[] = $filters['category'];
        }

        // rango de precios
        if (isset($filters['min_price'])) {
            $where[] = 'p.price_credits >= ?';
            $params[] = (int)$filters['min_price'];
        }
        if (isset($filters['max_price'])) {
            $where[] = 'p.price_credits <= ?';
            $params[] = (int)$filters['max_price'];
        }

        // construir SQL
        if (!empty($joins)) {
            $sql .= ' ' . implode(' ', $joins);
        }
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        // ordenar
        $orderBy = 'p.created_at DESC'; // por defecto
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $orderBy = 'p.price_credits ASC, p.name ASC';
                    break;
                case 'price_desc':
                    $orderBy = 'p.price_credits DESC, p.name ASC';
                    break;
                case 'name_asc':
                    $orderBy = 'p.name ASC';
                    break;
                case 'name_desc':
                    $orderBy = 'p.name DESC';
                    break;
                case 'newest':
                    $orderBy = 'p.created_at DESC';
                    break;
                case 'oldest':
                    $orderBy = 'p.created_at ASC';
                    break;
            }
        }
        $sql .= ' ORDER BY ' . $orderBy;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    public static function find(int $id): ?self
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT id, slug, demon_id, name, summary, duration, cooldown, limitations, price_credits, image_file_id, created_at, updated_at FROM pacts WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::fromRow($row) : null;
    }

    /**
     * @return Category[]
     */
    public function categories(): array
    {
        return Category::forPact((string)$this->id);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function create(array $data): int
    {
        $pdo = DbConnection::get();
        $sql = 'INSERT INTO pacts (slug, demon_id, name, summary, duration, cooldown, limitations, price_credits, image_file_id)
                VALUES (:slug, :demon_id, :name, :summary, :duration, :cooldown, :limitations, :price_credits, :image_file_id)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':slug' => $data['slug'] ?? null,
            ':demon_id' => (int)$data['demon_id'],
            ':name' => $data['name'],
            ':summary' => $data['summary'] ?? null,
            ':duration' => $data['duration'] ?? null,
            ':cooldown' => $data['cooldown'] ?? null,
            ':limitations' => isset($data['limitations']) ? json_encode($data['limitations']) : null,
            ':price_credits' => (int)($data['price_credits'] ?? 0),
            ':image_file_id' => isset($data['image_file_id']) ? (int)$data['image_file_id'] : null,
        ]);
        
        return (int)$pdo->lastInsertId();
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function update(int $id, array $data): void
    {
        $pdo = DbConnection::get();
        
        // construir UPDATE dinámico 
        $setClauses = [];
        $values = [':id' => $id];

        // Todos los campos posibles
        $fields = [
            'slug', 'demon_id', 'name', 'summary', 'duration', 
            'cooldown', 'price_credits', 'image'
        ];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $setClauses[] = "$field = :$field";
                if ($field === 'demon_id' || $field === 'price_credits') {
                    $values[":$field"] = (int)$data[$field];
                } else {
                    $values[":$field"] = $data[$field];
                }
            }
        }

        // manejar campo JSON de limitaciones
        if (isset($data['limitations'])) {
            $setClauses[] = 'limitations = :limitations';
            $values[':limitations'] = json_encode($data['limitations']);
        }

        // Image file ID
        if (isset($data['image_file_id'])) {
            $setClauses[] = 'image_file_id = :image_file_id';
            $values[':image_file_id'] = (int)$data['image_file_id'];
        }

        if (empty($setClauses)) {
            throw new Exception('No fields to update');
        }

        $sql = sprintf(
            'UPDATE pacts SET %s WHERE id = :id',
            implode(', ', $setClauses)
        );

        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
    }

    public function delete(): void
    {
        // eliminar imagen asociada si existe
        if ($this->image_file_id !== null) {
            require_once __DIR__ . '/../admin/classes/File.php';
            File::deleteById($this->image_file_id);
        }
        
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('DELETE FROM pacts WHERE id = ?');
        $stmt->execute([$this->id]);
    }
}
