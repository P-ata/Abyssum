<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';

if (isAdmin()) {
    header('Location: /?sec=admin&page=dashboard');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>     
<body class="min-h-screen bg-black relative overflow-hidden flex items-center justify-center font-mono">
  <!-- Ambient background grid & glow -->
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

  <div class="relative z-10 w-full max-w-md px-4">
    
    <!-- Título con badge ADMIN -->
    <div class="text-center mb-6">
      <div class="flex justify-center mb-4">
        <div class="px-3 py-1 bg-red-600/20 border border-red-600/40 rounded-full">
          <span class="text-red-500 text-xs font-bold tracking-widest flex items-center gap-2">
            <i class="fa-solid fa-shield-halved"></i>ADMIN ACCESS
          </span>
        </div>
      </div>
    </div>

    <!-- Instrucciones -->
    <div class="text-center mb-8">
      <p class="text-amber-600/70 text-sm uppercase tracking-widest">
        // Acceso restringido - Solo administradores
      </p>
    </div>
    
    <!-- Formulario -->
    <div class="bg-black/70 border-2 border-amber-600/40 backdrop-blur-sm rounded-xl p-8 shadow-2xl shadow-amber-500/20">
      
      <?php if ($error): ?>
        <div class="mb-6 p-4 bg-red-600/10 border border-red-600/40 rounded-lg text-red-400 text-sm">
          <i class="fa-solid fa-exclamation-triangle mr-2"></i><?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>
      
      <form method="post" action="/?sec=admin&action=login" class="space-y-6">
        <!-- EMAIL -->
        <div>
          <label class="block text-amber-500 mb-2 font-bold text-xs uppercase tracking-wider">
            <i class="fa-solid fa-envelope mr-2"></i>Email de administrador
          </label>
          <input 
            type="email" 
            name="email" 
            required 
            autofocus
            class="w-full bg-black/60 border border-amber-600/40 rounded-lg px-4 py-3 text-amber-300 font-mono focus:border-amber-500 focus:outline-none transition-colors placeholder:text-amber-300/30"
            placeholder="admin@abyssum.local"
          >
        </div>
        
        <!-- PASSWORD -->
        <div>
          <label class="block text-amber-500 mb-2 font-bold text-xs uppercase tracking-wider">
            <i class="fa-solid fa-lock mr-2"></i>Contraseña
          </label>
          <input 
            type="password" 
            name="password" 
            required 
            class="w-full bg-black/60 border border-amber-600/40 rounded-lg px-4 py-3 text-amber-300 font-mono focus:border-amber-500 focus:outline-none transition-colors placeholder:text-amber-300/30"
            placeholder="••••••••"
          >
        </div>
        
        <!-- SUBMIT -->
        <button 
          type="submit" 
          class="w-full bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 font-bold py-3 rounded-lg transition-all font-mono text-sm tracking-widest mt-8"
        >
          <i class="fa-solid fa-right-to-bracket mr-2"></i>ACCEDER AL PANEL
        </button>
      </form>
      
      <!-- LINKS -->
      <div class="mt-8 text-center">
        <a href="/" class="text-amber-600/70 hover:text-amber-500 text-sm transition-colors inline-flex items-center gap-2">
          <i class="fa-solid fa-arrow-left"></i>Volver al sitio
        </a>
      </div>
      
    </div>
  </div>
</body>
</html>
