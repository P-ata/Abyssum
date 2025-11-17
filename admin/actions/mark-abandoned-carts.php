<?php

declare(strict_types=1);


$basePath = __DIR__;
if (php_sapi_name() === 'cli') {
    
    define('BASE_PATH', dirname(dirname(dirname($basePath))));
} else {
    
    define('BASE_PATH', dirname(dirname(dirname($basePath))));
}

require_once BASE_PATH . '/classes/Cart.php';

// horas de inactividad para marcar como abandonado
$hoursInactive = 24;

try {
    $count = Cart::markAbandoned($hoursInactive);
    
    if (php_sapi_name() === 'cli') {
        echo "✓ Se marcaron $count carritos como abandonados.\n";
    } else {
        // si se llama desde web, retornar JSON
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
