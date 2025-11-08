<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/auth.php';

if (isAdmin()) {
    header('Location: admin');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    // Credenciales de ejemplo (cambialas o pasalas a DB cuando quieras)
    $validEmail = 'admin@demons.test';
    $validPass  = 'secreto123';

    if ($email === $validEmail && $pass === $validPass) {
        $_SESSION['admin_id'] = 1;
        header('Location: dashboard');
        exit;
    } else {
        $error = 'Credenciales inválidas';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="/assets/css/tailwind.css" rel="stylesheet">
    <script type="module" src="<?= BASE_PATH ?>assets/js/main.js"></script>
    <link rel="stylesheet" href="<?= BASE_PATH ?>assets/css/tailwind.css">
</head>     
<body class="min-h-screen flex items-center justify-center bg-black text-white">
    <form method="post" class="p-6 border border-gray-700 rounded-xl bg-zinc-900 space-y-4 w-full max-w-xs">
        <h1 class="text-xl font-semibold">Panel Demons — Login</h1>

        <?php if ($error): ?>
            <p class="text-red-500 text-sm"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <div>
            <input
                type="email"
                name="email"
                placeholder="Email"
                class="w-full px-3 py-2 bg-black border border-gray-700 rounded"
                required
            >
        </div>

        <div>
            <input
                type="password"
                name="password"
                placeholder="Contraseña"
                class="w-full px-3 py-2 bg-black border border-gray-700 rounded"
                required
            >
        </div>

        <button
            type="submit"
            class="w-full py-2 rounded bg-purple-600 hover:bg-purple-500 transition"
        >
            Entrar
        </button>
    </form>
</body>
</html>