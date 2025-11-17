<?php
require_once BASE_PATH . '/classes/Pact.php';
require_once BASE_PATH . '/classes/Demon.php';
require_once BASE_PATH . '/classes/Order.php';
?>

<!-- main section -->
<div class="relative overflow-hidden bg-black py-20 lg:py-32 font-mono">
  
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>
  
  <div class="relative z-10 mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
    <div class="text-center">
      
      <h1 class="hero-title text-6xl lg:text-8xl font-bold tracking-widest text-amber-500 mb-4">
        <span class="block">ABYSSUM</span>
      </h1>
      <div class="hero-subtitle text-xl lg:text-2xl tracking-wide text-amber-600/80 mb-8">
        <span class="inline-block">// PORTAL</span>
        <span class="inline-block mx-2 text-amber-500/50">:</span>
        <span class="inline-block">SISTEMA DE PACTOS</span>
      </div>
      
      
      <p class="hero-description max-w-3xl mx-auto lg:px-17 text-sm lg:text-base text-gray-400 leading-relaxed mb-12">
        Los demonios de Abyssum son leyendas, entidades con reglas claras y poderes medibles. Un pacto abre acceso a sus dones y habilidades.
      </p>
      
      
      <div class="flex flex-wrap justify-center gap-4 mb-12">
        <div class="feature-pill group bg-black/70 border border-amber-600/30 rounded-xl px-6 py-3 backdrop-filter hover:bg-amber-600/10 transition-all">
          <div class="flex items-center gap-3">
            <i class="fas fa-shield-halved text-amber-500 text-lg"></i>
            <div class="text-left">
              <div class="text-xs uppercase tracking-widest text-amber-600/70">Seguridad</div>
              <div class="text-sm text-amber-400 font-semibold">Cifrado Absoluto</div>
            </div>
          </div>
        </div>
        
        <div class="feature-pill group bg-black/70 border border-amber-600/30 rounded-xl px-6 py-3 backdrop-filter hover:bg-amber-600/10 transition-all">
          <div class="flex items-center gap-3">
            <i class="fas fa-bolt text-amber-500 text-lg"></i>
            <div class="text-left">
              <div class="text-xs uppercase tracking-widest text-amber-600/70">Velocidad</div>
              <div class="text-sm text-amber-400 font-semibold">Instantáneo</div>
            </div>
          </div>
        </div>
        
        <div class="feature-pill group bg-black/70 border border-amber-600/30 rounded-xl px-6 py-3 backdrop-filter hover:bg-amber-600/10 transition-all">
          <div class="flex items-center gap-3">
            <i class="fas fa-infinity text-amber-500 text-lg"></i>
            <div class="text-left">
              <div class="text-xs uppercase tracking-widest text-amber-600/70">Alcance</div>
              <div class="text-sm text-amber-400 font-semibold">Multi-dimensional</div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="flex flex-wrap justify-center gap-4">
        <a href="/?sec=pacts" class="cta-button group relative inline-flex items-center gap-2 px-8 py-3 rounded border border-amber-600/40 bg-amber-600/20 hover:bg-amber-600/30 transition overflow-hidden">
          <span class="text-amber-500 text-sm tracking-wide font-semibold">EXPLORAR PACTOS</span>
          <span class="absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition bg-gradient-to-r from-amber-600/0 via-amber-600/20 to-amber-600/0"></span>
        </a>
        
        <a href="/?sec=contact" class="cta-button group relative inline-flex items-center gap-2 px-8 py-3 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/20 transition overflow-hidden">
          <span class="text-amber-500 text-sm tracking-wide font-semibold">SOPORTE</span>
          <span class="absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition bg-gradient-to-r from-amber-600/0 via-amber-600/20 to-amber-600/0"></span>
        </a>
      </div>
      
      <!-- Status Bar -->
      <div class="status-bar mt-25 border-t border-amber-600/20">
      
      </div>
      
      <!-- Stats Grid -->
      <div class="mt-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Pactos Comprados -->
          <div class="relative group bg-black/70 border border-amber-600/30 rounded-xl p-4 backdrop-filter" data-stat>
            <div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">COMPRADOS</div>
            <div class="flex items-end justify-between">
              <div class="text-amber-500 text-2xl font-bold" data-value="<?= isLoggedIn() ? Order::countByUser($_SESSION['user_id']) : 0 ?>"><?= isLoggedIn() ? Order::countByUser($_SESSION['user_id']) : 0 ?></div>
              <div class="text-xs text-gray-600">// pactos</div>
            </div>
            <div class="mt-2 h-1 w-full bg-amber-600/20 relative overflow-hidden rounded">
              <div class="absolute inset-y-0 left-0 bg-amber-500/70" data-bar style="width: 0%"></div>
            </div>
          </div>
          
          <!-- Pactos Totales -->
          <div class="relative group bg-black/70 border border-amber-600/30 rounded-xl p-4 backdrop-filter" data-stat>
            <div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TOTAL PACTOS</div>
            <div class="flex items-end justify-between">
              <div class="text-amber-500 text-2xl font-bold" data-value="<?= count(Pact::all()) ?>"><?= count(Pact::all()) ?></div>
              <div class="text-xs text-gray-600">// activos</div>
            </div>
            <div class="mt-2 h-1 w-full bg-amber-600/20 relative overflow-hidden rounded">
              <div class="absolute inset-y-0 left-0 bg-amber-500/70" data-bar style="width: 0%"></div>
            </div>
          </div>
          
          <!-- Demonios Totales -->
          <div class="relative group bg-black/70 border border-amber-600/30 rounded-xl p-4 backdrop-filter" data-stat>
            <div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">DEMONIOS</div>
            <div class="flex items-end justify-between">
              <div class="text-amber-500 text-2xl font-bold" data-value="<?= count(Demon::all()) ?>"><?= count(Demon::all()) ?></div>
              <div class="text-xs text-gray-600">// indexados</div>
            </div>
            <div class="mt-2 h-1 w-full bg-amber-600/20 relative overflow-hidden rounded">
              <div class="absolute inset-y-0 left-0 bg-amber-500/70" data-bar style="width: 0%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- fade -->
  <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-black to-transparent pointer-events-none"></div>
</div>