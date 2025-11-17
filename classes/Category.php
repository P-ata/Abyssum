<?php
declare(strict_types=1);

require_once __DIR__ . '/DbConnection.php';

class Category
{
    public string $slug;
    public string $display_name;
    public string $created_at;

    public static function fromRow(array $row): self
    {
        $c = new self();
        $c->slug = $row['slug'];
        $c->display_name = $row['display_name'];
        $c->created_at = $row['created_at'] ?? '';
        return $c;
    }

    /**
     * @return Category[]
     */
    public static function all(): array
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->query('SELECT slug, display_name, created_at FROM categories ORDER BY display_name');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * todas las categorias menos los nombres de demonios
     * @return Category[]
     */
    public static function allExcludingDemons(): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT c.slug, c.display_name, c.created_at 
                FROM categories c
                WHERE c.slug NOT IN (SELECT slug FROM demons)
                ORDER BY c.display_name';
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    /**
     * todas las categorias para demonios (categorias que son nombres de demonios)
     * @return Category[]
     */
    public static function allForDemons(): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT c.slug, c.display_name, c.created_at 
                FROM categories c
                WHERE c.slug IN (SELECT slug FROM demons)
                ORDER BY c.display_name';
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }

    public static function find(string $slug): ?self
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT slug, display_name, created_at FROM categories WHERE slug = ?');
        $stmt->execute([$slug]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::fromRow($row) : null;
    }

    /**
     * @return Category[]
     */
    public static function forPact(string $pactId): array
    {
        $pdo = DbConnection::get();
        $sql = 'SELECT c.slug, c.display_name, c.created_at
                FROM pact_categories pc
                JOIN categories c ON c.slug = pc.category_slug
                WHERE pc.pact_id = ?
                ORDER BY c.display_name';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pactId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromRow'], $rows ?: []);
    }
}
