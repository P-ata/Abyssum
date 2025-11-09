<div class="min-h-screen bg-black relative overflow-hidden py-20 px-4">
  <!-- Grid cyberpunk background -->
  <div class="fixed inset-0 opacity-20 pointer-events-none">
    <div class="absolute inset-0" style="background-image: linear-gradient(cyan 1px, transparent 1px), linear-gradient(90deg, cyan 1px, transparent 1px); background-size: 50px 50px;"></div>
  </div>
  
  <!-- Glowing orbs -->
  <div class="fixed top-20 left-20 w-96 h-96 bg-cyan-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
  <div class="fixed bottom-20 right-20 w-96 h-96 bg-fuchsia-500 rounded-full blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
  
  <div class="max-w-7xl mx-auto relative z-10">
    <h1 class="text-6xl font-bold text-center mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-fuchsia-500 to-purple-600 font-mono tracking-wider">
      <span class="drop-shadow-[0_0_10px_rgba(0,255,255,0.5)]">ABYSSUM</span>
    </h1>
    <p class="text-center text-cyan-300 mb-4 text-xl font-mono uppercase tracking-widest">
      // Pactos Demoníacos v2.0
    </p>
    <p class="text-center text-fuchsia-400 mb-12 text-sm font-mono">
      &gt; Explora_los_pactos_antiguos.exe
    </p>

    <!-- Container de las cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
      
      <!-- Card del Pacto de Invisibilidad con Menú Expandible -->
      <div class="expandable-card-container">
        <div class="expandable-card" data-pact="invisibility">
          
          <!-- Imagen principal -->
          <div class="card-image">
            <img 
              src="/assets/img/pacts/Aurelia/Invisible.png" 
              alt="Pacto de Invisibilidad" 
              class="w-full h-full object-cover opacity-80"
            >
            
            <!-- Info discreta en la esquina -->
            <div class="card-info">
              <p class="text-cyan-400 text-xs font-mono opacity-60">Aurelia</p>
              <p class="text-fuchsia-400 text-sm font-mono font-semibold">Invisibilidad</p>
            </div>
          </div>

          <!-- Menú expandible -->
          <div class="card-menu">
            <!-- Panel izquierdo -->
            <div class="menu-panel menu-left">
              <div class="p-4">
                <h4 class="text-cyan-300 font-mono text-sm mb-3 border-b border-cyan-500/30 pb-2">// STATS_</h4>
                <ul class="space-y-2 text-xs text-cyan-200 font-mono">
                  <li class="flex justify-between">
                    <span class="text-fuchsia-400">⚡ Poder:</span>
                    <span>7/10</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-fuchsia-400">⏱ Duración:</span>
                    <span>3h</span>
                  </li>
                  <li class="flex justify-between">
                    <span class="text-fuchsia-400">☠ Riesgo:</span>
                    <span>BAJO</span>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Panel derecho -->
            <div class="menu-panel menu-right">
              <div class="p-4">
                <h4 class="text-cyan-300 font-mono text-sm mb-3 border-b border-cyan-500/30 pb-2">// ACTIONS_</h4>
                <div class="space-y-2">
                  <button class="w-full bg-gradient-to-r from-cyan-500 to-fuchsia-600 hover:from-cyan-400 hover:to-fuchsia-500 text-black text-xs font-bold py-2 px-3 rounded font-mono shadow-[0_0_15px_rgba(0,255,255,0.5)]">
                    [ACTIVAR]
                  </button>
                  <button class="w-full bg-black/50 hover:bg-cyan-950/50 text-cyan-400 text-xs font-semibold py-2 px-3 rounded font-mono border border-cyan-500/50">
                    [INFO]
                  </button>
                </div>
              </div>
            </div>

            <!-- Panel superior -->
            <div class="menu-panel menu-top">
              <div class="p-3 text-center">
                <p class="text-cyan-300 text-xs font-mono">
                  &gt; Desvanecerse_en_las_sombras.exe // Aurelia.sys
                </p>
              </div>
            </div>

            <!-- Panel inferior -->
            <div class="menu-panel menu-bottom">
              <div class="p-3 flex justify-between items-center">
                <span class="text-fuchsia-400 text-xs font-mono">PRECIO:</span>
                <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-500 font-mono">666 ⛧</span>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- Instrucciones -->
    <div class="mt-12 text-center relative z-10">
      <p class="text-cyan-400 text-sm font-mono">
        [ CLICK_CARD_TO_REVEAL ] // &gt;_
      </p>
    </div>
  </div>
</div>