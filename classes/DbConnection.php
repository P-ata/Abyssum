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

        $host = getenv('DB_HOST') ?: 'mysql';
        $port = getenv('DB_PORT') ?: '3306';
        $db   = getenv('DB_NAME') ?: 'demons';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: 'secret';

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

        try {
            self::$pdo = new PDO($dsn, $user, $pass);
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
