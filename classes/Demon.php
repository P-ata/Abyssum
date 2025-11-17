<?php
declare(strict_types=1);

require_once __DIR__ . '/DbConnection.php';

class Demon
{
    public int $id;
    public string $slug;
    public string $name;
    public ?string $summary = null;
    public ?int $image_file_id = null;
    
    // demografia
    public ?string $species = null;
    public ?string $gender = null;
    public ?string $age_real = null;
    
    // descripciones
    public ?string $lore = null;
    public ?string $abilities_summary = null;
    
    // arreglos JSON
    public ?array $aliases = null;
    public ?array $personality = null;
    public ?array $weaknesses_limits = null;
    
    // estadisticas
    public ?int $stat_strength = null;
    public ?int $stat_dexterity = null;
    public ?int $stat_intelligence = null;
    public ?int $stat_health = null;
    public ?int $stat_reflexes = null;
    public ?int $stat_stealth = null;

    /**
     * @param array<string, mixed> $row
     */
    public static function fromRow(array $row): self
    {
        $d = new self();
        $d->id = (int)$row['id'];
        $d->slug = $row['slug'];
        $d->name = $row['name'];
        $d->summary = $row['summary'] ?? null;
        $d->image_file_id = isset($row['image_file_id']) ? (int)$row['image_file_id'] : null;
        
        // demografia
        $d->species = $row['species'] ?? null;
        $d->gender = $row['gender'] ?? null;
        $d->age_real = $row['age_real'] ?? null;
        
        // descripciones
        $d->lore = $row['lore'] ?? null;
        $d->abilities_summary = $row['abilities_summary'] ?? null;
        
        // arreglos JSON se decodifican si son strings
        $d->aliases = isset($row['aliases']) && is_string($row['aliases']) 
            ? json_decode($row['aliases'], true, 512, JSON_UNESCAPED_UNICODE) 
            : ($row['aliases'] ?? null);
        $d->personality = isset($row['personality']) && is_string($row['personality']) 
            ? json_decode($row['personality'], true, 512, JSON_UNESCAPED_UNICODE) 
            : ($row['personality'] ?? null);
        $d->weaknesses_limits = isset($row['weaknesses_limits']) && is_string($row['weaknesses_limits']) 
            ? json_decode($row['weaknesses_limits'], true, 512, JSON_UNESCAPED_UNICODE) 
            : ($row['weaknesses_limits'] ?? null);
        
        // estadisticas
        $d->stat_strength = isset($row['stat_strength']) ? (int)$row['stat_strength'] : null;
        $d->stat_dexterity = isset($row['stat_dexterity']) ? (int)$row['stat_dexterity'] : null;
        $d->stat_intelligence = isset($row['stat_intelligence']) ? (int)$row['stat_intelligence'] : null;
        $d->stat_health = isset($row['stat_health']) ? (int)$row['stat_health'] : null;
        $d->stat_reflexes = isset($row['stat_reflexes']) ? (int)$row['stat_reflexes'] : null;
        $d->stat_stealth = isset($row['stat_stealth']) ? (int)$row['stat_stealth'] : null;
        
        return $d;
    }

    /**
     * @return Demon[]
     */
    public static function all(): array
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->query('SELECT id, slug, name, summary, image_file_id, aliases, species, lore FROM demons ORDER BY name');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * buscar demonio por ID o slug
     * @param int|string $idOrSlug
     * @return self|null
     */
    public static function find(int|string $idOrSlug): ?self
    {
        $pdo = DbConnection::get();
        
        if (is_int($idOrSlug)) {
            $stmt = $pdo->prepare('SELECT * FROM demons WHERE id = ?');
        } else {
            $stmt = $pdo->prepare('SELECT * FROM demons WHERE slug = ?');
        }
        
        $stmt->execute([$idOrSlug]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::fromRow($row) : null;
    }

    public static function findBySlug(string $slug): ?self
    {
        return self::find($slug);
    }

    /**
     * buscar demonios por IDs
     * @param int[] $ids
     * @return Demon[]
     */
    public static function findMultiple(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $pdo = DbConnection::get();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("SELECT * FROM demons WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function create(array $data): void
    {
        $pdo = DbConnection::get();
        
        // construir INSERT dinámico basado en los campos proporcionados
        $fields = ['slug', 'name']; // campos requeridos
        $placeholders = [':slug', ':name'];
        $values = [
            ':slug' => $data['slug'],
            ':name' => $data['name'],
        ];

        // campos de texto opcionales
        $optionalFields = [
            'species', 'gender', 'age_real', 'summary', 'lore', 
            'full_description', 'abilities_summary'
        ];
        foreach ($optionalFields as $field) {
            if (isset($data[$field])) {
                $fields[] = $field;
                $placeholders[] = ":$field";
                $values[":$field"] = $data[$field];
            }
        }

        // arreglos JSON
        $jsonFields = ['aliases', 'personality', 'preferred_envs', 'appearance_tags', 'weaknesses_limits'];
        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $fields[] = $field;
                $placeholders[] = ":$field";
                $values[":$field"] = json_encode($data[$field]);
            }
        }

        // estadisticas (tinyint)
        $statFields = [
            'stat_strength', 'stat_dexterity', 'stat_intelligence',
            'stat_health', 'stat_reflexes', 'stat_stealth', 'stat_mobility'
        ];
        foreach ($statFields as $field) {
            if (isset($data[$field])) {
                $fields[] = $field;
                $placeholders[] = ":$field";
                $values[":$field"] = (int)$data[$field];
            }
        }

        // ID de archivo de imagen
        if (isset($data['image_file_id'])) {
            $fields[] = 'image_file_id';
            $placeholders[] = ':image_file_id';
            $values[':image_file_id'] = (int)$data['image_file_id'];
        }

        $sql = sprintf(
            'INSERT INTO demons (%s) VALUES (%s)',
            implode(', ', $fields),
            implode(', ', $placeholders)
        );

        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function update(int $id, array $data): void
    {
        $pdo = DbConnection::get();
        
        // update dinamico
        $setClauses = [];
        $values = [':id' => $id];

        // campos requeridos
        if (isset($data['slug'])) {
            $setClauses[] = 'slug = :slug';
            $values[':slug'] = $data['slug'];
        }
        if (isset($data['name'])) {
            $setClauses[] = 'name = :name';
            $values[':name'] = $data['name'];
        }

        // campos de texto opcionales
        $optionalFields = [
            'species', 'gender', 'age_real', 'summary', 'lore', 
            'full_description', 'abilities_summary', 'image'
        ];
        foreach ($optionalFields as $field) {
            if (isset($data[$field])) {
                $setClauses[] = "$field = :$field";
                $values[":$field"] = $data[$field];
            }
        }

        // arreglos JSON
        $jsonFields = ['aliases', 'personality', 'preferred_envs', 'appearance_tags', 'weaknesses_limits'];
        foreach ($jsonFields as $field) {
            if (isset($data[$field])) {
                $setClauses[] = "$field = :$field";
                $values[":$field"] = json_encode($data[$field]);
            }
        }

        // estadisticas (tinyint)
        $statFields = [
            'stat_strength', 'stat_dexterity', 'stat_intelligence',
            'stat_health', 'stat_reflexes', 'stat_stealth', 'stat_mobility'
        ];
        foreach ($statFields as $field) {
            if (isset($data[$field])) {
                $setClauses[] = "$field = :$field";
                $values[":$field"] = (int)$data[$field];
            }
        }

        // ID de archivo de imagen
        if (isset($data['image_file_id'])) {
            $setClauses[] = 'image_file_id = :image_file_id';
            $values[':image_file_id'] = (int)$data['image_file_id'];
        }

        if (empty($setClauses)) {
            throw new Exception('No fields to update');
        }

        $sql = sprintf(
            'UPDATE demons SET %s WHERE id = :id',
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
        $stmt = $pdo->prepare('DELETE FROM demons WHERE id = ?');
        $stmt->execute([$this->id]);
    }

    /**
     * obtener todas las categorías asociadas a este demonio
     * @return Category[]
     */
    public function categories(): array
    {
        require_once __DIR__ . '/Category.php';
        
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('
            SELECT c.* 
            FROM categories c
            WHERE c.slug = ?
        ');
        $stmt->execute([$this->slug]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map([Category::class, 'fromRow'], $rows ?: []);
    }
}
