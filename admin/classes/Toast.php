<?php
declare(strict_types=1);

/**
 * Toast notification system using $_SESSION
 * 
 * Types: success, info, warning, error
 */
class Toast
{
    /**
     * Add a success toast
     */
    public static function success(string $message): void
    {
        self::add('success', $message);
    }

    /**
     * Add an error toast
     */
    public static function error(string $message): void
    {
        self::add('error', $message);
    }

    /**
     * Add a warning toast
     */
    public static function warning(string $message): void
    {
        self::add('warning', $message);
    }

    /**
     * Add an info toast
     */
    public static function info(string $message): void
    {
        self::add('info', $message);
    }

    /**
     * Add a toast to the session
     */
    private static function add(string $type, string $message): void
    {
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
     * Get all toasts and clear them
     */
    public static function getAll(): array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $toasts = $_SESSION['toasts'] ?? [];
        unset($_SESSION['toasts']);
        
        return $toasts;
    }

    /**
     * Check if there are toasts
     */
    public static function hasToasts(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return !empty($_SESSION['toasts']);
    }
}
