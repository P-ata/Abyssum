<?php
declare(strict_types=1);

require_once __DIR__ . '/DbConnection.php';

class User
{
    public int $id;
    public string $email;
    public string $display_name;
    public bool $is_active;
    public ?string $last_login_at = null;
    public array $roles = []; // ['admin', 'customer']
    
    /**
     * crear usuario desde fila de BD
     */
    public static function fromRow(array $row): self
    {
        $user = new self();
        $user->id = (int)$row['id'];
        $user->email = $row['email'];
        $user->display_name = $row['display_name'];
        $user->is_active = (bool)$row['is_active'];
        $user->last_login_at = $row['last_login_at'] ?? null;
        return $user;
    }
    
    /**
     * obtener todos los usuarios
     */
    public static function all(): array
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->query('SELECT id, email, display_name, is_active, last_login_at FROM users ORDER BY created_at DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $users = [];
        foreach ($rows as $row) {
            $user = self::fromRow($row);
            $user->roles = self::getUserRoles($user->id);
            $users[] = $user;
        }
        
        return $users;
    }
    
    /**
     * buscar usuario por ID
     */
    public static function find(int $id): ?self
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT id, email, display_name, is_active, last_login_at FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) return null;
        
        $user = self::fromRow($row);
        $user->roles = self::getUserRoles($user->id);
        return $user;
    }
    
    /**
     * buscar usuario por email
     */
    public static function findByEmail(string $email): ?self
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT id, email, display_name, is_active, last_login_at FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) return null;
        
        $user = self::fromRow($row);
        $user->roles = self::getUserRoles($user->id);
        return $user;
    }
    
    /**
     * verificar password
     */
    public static function verifyPassword(string $email, string $password): ?self
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT id, email, password_hash, display_name, is_active, last_login_at FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) return null;
        
        if (!password_verify($password, $row['password_hash'])) {
            return null;
        }
        
        $user = self::fromRow($row);
        $user->roles = self::getUserRoles($user->id);
        return $user;
    }
    
    /**
     * crear nuevo usuario
     */
    public static function create(string $email, string $password, string $displayName): int
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('
            INSERT INTO users (email, password_hash, display_name) 
            VALUES (?, ?, ?)
        ');
        $stmt->execute([
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $displayName
        ]);
        
        $userId = (int)$pdo->lastInsertId();
        
        // asignar rol customer por defecto
        self::assignRole($userId, 2); // 2 = customer
        
        return $userId;
    }
    
    /**
     * actualizar estado activo
     */
    public static function setActive(int $userId, bool $active): void
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('UPDATE users SET is_active = ? WHERE id = ?');
        $stmt->execute([$active ? 1 : 0, $userId]);
    }
    
    /**
     * actualizar último login
     */
    public static function updateLastLogin(int $userId): void
    {
        $pdo = DbConnection::get();
        // convertir hora actual
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $now = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare('UPDATE users SET last_login_at = ? WHERE id = ?');
        $stmt->execute([$now, $userId]);
    }
    
    /**
     * obtener roles de un usuario
     */
    public static function getUserRoles(int $userId): array
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('
            SELECT r.name 
            FROM roles r
            JOIN user_roles ur ON r.id = ur.role_id
            WHERE ur.user_id = ?
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * asignar rol
     */
    public static function assignRole(int $userId, int $roleId): void
    {
        $pdo = DbConnection::get();
        
        // verificar si ya tiene el rol
        $check = $pdo->prepare('SELECT COUNT(*) FROM user_roles WHERE user_id = ? AND role_id = ?');
        $check->execute([$userId, $roleId]);
        
        if ($check->fetchColumn() > 0) {
            return; // ya tiene el rol
        }
        
        $stmt = $pdo->prepare('INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)');
        $stmt->execute([$userId, $roleId]);
    }
    
    /**
     * quitar rol
     */
    public static function removeRole(int $userId, int $roleId): void
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('DELETE FROM user_roles WHERE user_id = ? AND role_id = ?');
        $stmt->execute([$userId, $roleId]);
    }
    
    /**
     * verificar si tiene un rol específico
     */
    public function hasRole(string $roleName): bool
    {
        return in_array($roleName, $this->roles);
    }
    
    /**
     * verificar si es admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
