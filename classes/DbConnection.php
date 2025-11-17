<?php
class DbConnection
{
    private static ?PDO $pdo = null;
    private static bool $connectionFailed = false;
    private static ?string $lastError = null;

    public static function isConnected(): bool
    {
        // si ya falló, retornar false
        if (self::$connectionFailed) {
            return false;
        }
        
        // si ya hay una conexión, retornar true
        if (self::$pdo instanceof PDO) {
            return true;
        }
        
        // si no se ha intentado conectar, intentar ahora
        try {
            self::get();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getLastError(): ?string
    {
        return self::$lastError;
    }

    public static function get(): PDO
    {   
        // si ya existe, reusar
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        // si ya falló antes, no reintentar
        if (self::$connectionFailed) {
            throw new Exception('Conexión a base de datos no disponible');
        }

        // si no es docker es default
        $get = static function(string $key, string $default = ''): string {
            $v = getenv($key);
            if ($v === false || $v === '') {
                $v = $_ENV[$key] ?? ($_SERVER[$key] ?? $default);
            }
            return (string)$v;
        };

        $host = $get('DB_HOST', 'mysql');
        $port = $get('DB_PORT', '3306');
        $db   = $get('DB_NAME', 'abyssum');
        $user = $get('DB_USER', 'root');
        $pass = $get('DB_PASS', 'secret');

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

        try {
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            self::$connectionFailed = true;
            self::$lastError = $e->getMessage();
            
            // si es admin (cualquier página admin excepto health), redirigir a health
            if (isset($_GET['sec']) && $_GET['sec'] === 'admin') {
                $page = $_GET['page'] ?? null;
                if ($page !== 'health') {
                    header('Location: /?sec=admin&page=health&error=db');
                    exit;
                }
            } elseif (!isset($_GET['sec']) || $_GET['sec'] !== 'db-error') {
                // si es público y no es la página de error, redirigir a página de error
                header('Location: /?sec=db-error');
                exit;
            }
            
            throw $e;
        }

        return self::$pdo;
    }
}
