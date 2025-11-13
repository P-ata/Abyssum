<?php
class DbConnection
{
    private static ?PDO $pdo = null;

    public static function get(): PDO
    {   
        // Si ya existe, reusar
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
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
            /* die('Error al conectar con la base de datos.'); */
            
            // --- DEBUG (usar sólo en desarrollo) ---
            echo "<h3>Error de conexión a MySQL</h3>";
            echo "<p><strong>Mensaje:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>Código:</strong> " . $e->getCode() . "</p>";
            echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
            echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
            echo "<p><strong>DSN (sin credenciales):</strong> mysql:host=$host;port=$port;dbname=$db</p>";
            exit; // o throw $e; si preferís que la excepción suba
        }

        return self::$pdo;
    }
}
