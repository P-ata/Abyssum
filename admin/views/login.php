<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';

if (isAdmin()) {
    header('Location: /admin/dashboard');
    exit;
}

// Esta es la VISTA del login (solo GET)
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']); // Clear flash message
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | ABYSSUM</title>
    <link href="/assets/admin/css/tailwind.css" rel="stylesheet">
</head>     
<body class="min-h-screen flex items-center justify-center bg-black text-white overflow-hidden">
    <div class="cyber-grid absolute inset-0 opacity-10"></div>
    <div class="scanlines absolute inset-0 pointer-events-none opacity-30"></div>
    
    <form method="post" action="/admin/actions/login" class="relative z-10 p-8 border-2 border-cyan-500/30 rounded-xl bg-black/80 backdrop-blur-sm space-y-6 w-full max-w-md">
        <header class="text-center mb-6">
            <h1 class="text-3xl font-bold glitch-text text-cyan-400 mb-2" data-text="ADMIN ACCESS">ADMIN ACCESS</h1>
            <p class="text-sm text-gray-500 font-mono">&gt; Panel de control ABYSSUM_</p>
        </header>

        <?php if ($error): ?>
            <div class="p-4 bg-red-500/10 border border-red-500/50 rounded text-red-400 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div>
            <label class="block text-sm text-cyan-400 mb-2 font-mono">&gt; EMAIL</label>
            <input
                type="email"
                name="email"
                placeholder="admin@demons.test"
                class="w-full px-4 py-3 bg-black border-2 border-gray-700 rounded focus:border-cyan-500 focus:outline-none transition-all text-cyan-300 font-mono"
                required
                autofocus
            >
        </div>

        <div>
            <label class="block text-sm text-cyan-400 mb-2 font-mono">&gt; PASSWORD</label>
            <input
                type="password"
                name="password"
                placeholder="••••••••••"
                class="w-full px-4 py-3 bg-black border-2 border-gray-700 rounded focus:border-cyan-500 focus:outline-none transition-all text-cyan-300 font-mono"
                required
            >
        </div>

        <button
            type="submit"
            class="w-full py-3 rounded bg-gradient-to-r from-cyan-500 to-pink-500 text-black font-bold uppercase tracking-wider hover:shadow-lg hover:shadow-cyan-500/50 transition-all"
        >
            Iniciar sesión
        </button>

        <footer class="text-center pt-4 border-t border-gray-800">
            <a href="/" class="text-sm text-gray-500 hover:text-cyan-400 transition-colors">
                ← Volver al sitio
            </a>
        </footer>
    </form>
</body>
</html>
