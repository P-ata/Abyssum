<?php
declare(strict_types=1);

// Destruir sesión
session_destroy();

// Redirigir a home
header('Location: /?sec=abyssum');
exit;
