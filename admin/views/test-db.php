<?php
require_once __DIR__ . '/../classes/DbConnection.php';

echo "<h1>🔥 Prueba de Conexión a Base de Datos Abyssum 🔥</h1>";
echo "<hr>";

try {
    // 1. Obtener conexión
    echo "<h2>✅ Paso 1: Conectando...</h2>";
    $pdo = DbConnection::get();
    echo "<p style='color: green;'>✓ Conexión establecida exitosamente!</p>";

    // 2. Verificar la base de datos actual
    echo "<h2>✅ Paso 2: Verificando base de datos...</h2>";
    $stmt = $pdo->query("SELECT DATABASE() as db_name");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Base de datos actual: <strong style='color: blue;'>{$result['db_name']}</strong></p>";

    // 2.5 Listar TODAS las bases de datos disponibles
    echo "<h2>🔍 Paso 2.5: Bases de datos disponibles...</h2>";
    $stmt = $pdo->query("SHOW DATABASES");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<ul>";
    foreach ($databases as $db) {
        echo "<li><code>{$db}</code></li>";
    }
    echo "</ul>";

    // 2.6 Verificar tablas en cada BD relevante
    echo "<h2>🔍 Paso 2.6: Verificando tablas en cada base de datos...</h2>";
    foreach (['abyssum', 'demons'] as $dbName) {
        if (in_array($dbName, $databases)) {
            $stmt = $pdo->query("SHOW TABLES FROM `{$dbName}`");
            $dbTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "<h3>Base de datos: <code>{$dbName}</code> (" . count($dbTables) . " tablas)</h3>";
            if (count($dbTables) > 0) {
                echo "<ul>";
                foreach ($dbTables as $table) {
                    echo "<li><code>{$table}</code></li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color: orange;'>⚠️ Sin tablas</p>";
            }
        }
    }

    // 3. Listar tablas
    echo "<h2>✅ Paso 3: Listando tablas...</h2>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "<p style='color: green;'>Se encontraron " . count($tables) . " tabla(s):</p>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li><code>{$table}</code></li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: orange;'>⚠️ No hay tablas en la base de datos. Necesitas importar el SQL.</p>";
    }

    // 4. Contar registros en algunas tablas (si existen)
    echo "<h2>✅ Paso 4: Contando registros...</h2>";
    $tablesToCheck = ['demons', 'pacts', 'categories', 'users', 'roles'];
    
    foreach ($tablesToCheck as $table) {
        if (in_array($table, $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM `{$table}`");
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p>📊 Tabla <code>{$table}</code>: <strong>{$count['total']}</strong> registro(s)</p>";
        }
    }

    // 5. Test de escritura (insertar y borrar una categoría de prueba)
    echo "<h2>✅ Paso 5: Test de escritura...</h2>";
    if (in_array('categories', $tables)) {
        // Insertar
        $testSlug = 'test_' . time();
        $stmt = $pdo->prepare("INSERT INTO categories (slug, display_name) VALUES (?, ?)");
        $stmt->execute([$testSlug, 'Categoría de Prueba']);
        echo "<p style='color: green;'>✓ INSERT exitoso (slug: {$testSlug})</p>";
        
        // Eliminar
        $stmt = $pdo->prepare("DELETE FROM categories WHERE slug = ?");
        $stmt->execute([$testSlug]);
        echo "<p style='color: green;'>✓ DELETE exitoso</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Tabla 'categories' no existe, omitiendo test de escritura.</p>";
    }

    echo "<hr>";
    echo "<h2 style='color: green;'>🎉 ¡Todo funciona perfectamente! 🎉</h2>";
    echo "<p><em>Recuerda importar tu SQL si aún no tienes tablas.</em></p>";

} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Error de Base de Datos</h2>";
    echo "<p><strong>Mensaje:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Código:</strong> " . $e->getCode() . "</p>";
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Error General</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 900px;
        margin: 50px auto;
        padding: 20px;
        background: #1a1a1a;
        color: #e0e0e0;
    }
    h1 { color: #ff6b6b; }
    h2 { color: #4ecdc4; border-bottom: 2px solid #4ecdc4; padding-bottom: 5px; }
    code { background: #2d2d2d; padding: 2px 6px; border-radius: 3px; color: #ffd93d; }
    hr { border: 1px solid #444; margin: 30px 0; }
</style>
