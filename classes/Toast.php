<?php
declare(strict_types=1);

/**
 * sistema de toasts
 * 
 * Tipos: success, info, warning, error
 */
class Toast
{
    /**
     * Añade un toast de éxito
     */
    public static function success(string $message): void
    {
        self::add('success', $message);
    }

    /**
     * Añade un toast de error
     */
    public static function error(string $message): void
    {
        self::add('error', $message);
    }

    /**
     * Añade un toast de advertencia
     */
    public static function warning(string $message): void
    {
        self::add('warning', $message);
    }

    /**
     * Añade un toast de información
     */
    public static function info(string $message): void
    {
        self::add('info', $message);
    }

    /**
     * Añade un toast a la sesión
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
     * Obtiene todos los toasts y los limpia
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
     * Verifica si hay toasts
     */
    public static function hasToasts(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return !empty($_SESSION['toasts']);
    }
}
