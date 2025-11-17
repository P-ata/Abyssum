<?php
declare(strict_types=1);

/**
 * simple clase para manejar notificaciones tipo toast
 * 
 * tipos: success, info, warning, error
 */
class Toast
{
    /**
     * agregar un toast de éxito
     */
    public static function success(string $message): void
    {
        self::add('success', $message);
    }

    /**
     * agregar un toast de error
     */
    public static function error(string $message): void
    {
        self::add('error', $message);
    }

    /**
     * agregar un toast de advertencia
     */
    public static function warning(string $message): void
    {
        self::add('warning', $message);
    }

    /**
     * agregar un toast de información
     */
    public static function info(string $message): void
    {
        self::add('info', $message);
    }

    /**
     * agregar un toast a la sesión
     */
    private static function add(string $type, string $message): void
    {   
        // iniciar sesión si no está iniciada
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['toasts'])) {
            $_SESSION['toasts'] = [];
        }

        $_SESSION['toasts'][] = [
            'type' => $type,
            'message' => $message,
            'timestamp' => time()
        ];
    }

    /**
     * obtener todos los toasts y limpiarlos
     */
    public static function getAll(): array
    {   
        // iniciar sesión si no está iniciada
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $toasts = $_SESSION['toasts'] ?? [];
        unset($_SESSION['toasts']);
        
        return $toasts;
    }

    /**
     * verificar si hay toasts pendientes
     */
    public static function hasToasts(): bool
    {   
        // iniciar sesión si no está iniciada
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return !empty($_SESSION['toasts']);
    }
}
