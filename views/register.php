<?php
require_once BASE_PATH . '/classes/Toast.php';
?>

<!-- REGISTRO PÚBLICO -->
<div class="min-h-screen bg-black relative overflow-hidden py-20 px-4 font-mono">
  <!-- Ambient background grid & glow -->
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

  <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 relative z-10">
    
    <!-- Título -->
    <div class="text-center mb-6">
      <h1 class="text-6xl font-bold tracking-widest text-amber-500">CREAR CUENTA</h1>
    </div>

    <!-- Instrucciones -->
    <div class="text-center mb-12">
      <p class="text-amber-600/70 text-sm uppercase tracking-widest">
        // Forma tu pacto con el abismo
      </p>
    </div>
    
    <!-- Formulario centrado -->
    <div class="max-w-md mx-auto">
      <div class="bg-black/70 border-2 border-amber-600/40 backdrop-blur-sm rounded-xl p-8 shadow-2xl shadow-amber-500/20">
      
      <form action="/?sec=actions&action=register" method="POST" class="space-y-6">
        <!-- NOMBRE -->
        <div>
          <label class="block text-amber-500 mb-2 font-bold text-xs uppercase tracking-wider">
            <i class="fa-solid fa-user mr-2"></i>Nombre
          </label>
          <input 
            type="text" 
            name="display_name" 
            required 
            class="w-full bg-black/60 border border-amber-600/40 rounded-lg px-4 py-3 text-amber-300 font-mono focus:border-amber-500 focus:outline-none transition-colors"
            placeholder="Tu nombre"
          >
        </div>
        
        <!-- EMAIL -->
        <div>
          <label class="block text-amber-500 mb-2 font-bold text-xs uppercase tracking-wider">
            <i class="fa-solid fa-envelope mr-2"></i>Email
          </label>
          <input 
            type="email" 
            name="email" 
            required 
            class="w-full bg-black/60 border border-amber-600/40 rounded-lg px-4 py-3 text-amber-300 font-mono focus:border-amber-500 focus:outline-none transition-colors"
            placeholder="tu@email.com"
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
            minlength="6"
            class="w-full bg-black/60 border border-amber-600/40 rounded-lg px-4 py-3 text-amber-300 font-mono focus:border-amber-500 focus:outline-none transition-colors"
            placeholder="Mínimo 6 caracteres"
          >
        </div>
        
        <!-- SUBMIT -->
        <button 
          type="submit" 
          class="w-full bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 font-bold py-3 rounded-lg transition-all font-mono text-sm tracking-widest mt-8"
        >
          <i class="fa-solid fa-user-plus mr-2"></i>REGISTRARSE
        </button>
      </form>
      
      <!-- LINKS -->
      <div class="mt-8 text-center">
        <p class="text-amber-600/70 text-sm">
          ¿Ya tenés cuenta? <a href="/?sec=login" class="text-amber-500 hover:text-amber-400 font-bold transition-colors">Iniciá sesión</a>
        </p>
      </div>
    </div>
  </div>
</div>
</div>
