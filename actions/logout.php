<?php
declare(strict_types=1);

// destruir la sesión
session_destroy();

// redirigir a home
header('Location: /?sec=abyssum');
exit;
