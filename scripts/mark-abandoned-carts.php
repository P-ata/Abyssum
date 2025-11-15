<?php
/**
 * Script para marcar carritos abandonados
 * 
 * Este script puede ejecutarse como:
 * 1. Tarea CRON programada (recomendado cada hora o diariamente)
 * 2. Llamada manual: php mark-abandoned-carts.php
 * 3. Llamada desde el admin dashboard
 * 
 * Marca como "abandoned" todos los carritos "pending" que tengan
 * más de 24 horas sin actualizar.
 */

declare(strict_types=1);

// Ajustar path si se ejecuta desde línea de comandos
$basePath = __DIR__;
if (php_sapi_name() === 'cli') {
    define('BASE_PATH', $basePath);
} else {
    define('BASE_PATH', dirname($basePath));
}

require_once BASE_PATH . '/classes/Cart.php';

// Configuración: horas de inactividad para marcar como abandonado
$hoursInactive = 24;

try {
    $count = Cart::markAbandoned($hoursInactive);
    
    if (php_sapi_name() === 'cli') {
        echo "✓ Se marcaron $count carritos como abandonados.\n";
    } else {
        // Si se llama desde web, retornar JSON
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'count' => $count,
            'message' => "$count carritos marcados como abandonados"
        ]);
    }
} catch (Exception $e) {
    if (php_sapi_name() === 'cli') {
        echo "✗ Error: " . $e->getMessage() . "\n";
        exit(1);
    } else {
        header('Content-Type: application/json', true, 500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
