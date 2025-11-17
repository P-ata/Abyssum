<?php
require_once BASE_PATH . '/classes/Cart.php';
$cartCount = Cart::count();
$current = $_GET['sec'] ?? 'abyssum';
?>

<header class="sticky top-0 z-50">
  <nav class="bg-black border-b border-amber-500/20">
    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-3 h-16 items-center">
        
        <!-- izquierda menu -->
        <div class="justify-self-start">
          <button id="menuBtn"
                  class="inline-flex items-center justify-center p-2 rounded-md hover:bg-amber-500/10 transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/40 text-white/90"
                  aria-label="Abrir menú" aria-controls="mobileMenu" aria-expanded="false">
            <span class="sr-only">Abrir menú</span>
            <span class="block w-6 h-4 relative">
              <span class="bar bar-top absolute left-0 top-0 h-0.5 w-6 bg-current transition-all duration-300 ease-in-out origin-left"></span>
              <span class="bar bar-mid absolute left-0 top-1/2 -translate-y-1/2 h-0.5 w-5 bg-current transition-all duration-300 ease-in-out origin-left"></span>
              <span class="bar bar-bot absolute left-0 bottom-0 h-0.5 w-4 bg-current transition-all duration-300 ease-in-out origin-left"></span>
            </span>
          </button>
        </div>

        <!-- pelado como una papa -->
        <div></div>

        <!-- derecha: carrito y perfil -->
        <div class="justify-self-end flex items-center gap-3">
          <?php if (isLoggedIn()): ?>
            <!-- CARRITO -->
            <a href="/?sec=cart" class="relative group">
              <div class="flex items-center gap-2 px-3 py-2 rounded-md border border-white/40 bg-gradient-to-br from-white/10 to-white/5 hover:from-white/15 hover:to-white/10 hover:border-white/60 transition-all text-white shadow-lg shadow-white/10 hover:shadow-white/20">
                <i class="fas fa-shopping-cart text-base"></i>
                <?php if ($cartCount > 0): ?>
                  <span class="text-xs font-bold font-mono tracking-wider"><?= $cartCount ?></span>
                <?php endif; ?>
              </div>
              <?php if ($cartCount > 0): ?>
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-white shadow-lg shadow-white/50"></span>
                </span>
              <?php endif; ?>
            </a>
          <?php endif; ?>
          
          <?php if (isLoggedIn()): ?>
            <!-- PERFIL CON DROPDOWN -->
            <div class="relative group">
              <button class="flex items-center gap-2 px-3 py-2 rounded-md border border-white/40 bg-gradient-to-br from-white/10 to-white/5 hover:from-white/15 hover:to-white/10 hover:border-white/60 transition-all text-white shadow-lg shadow-white/10 hover:shadow-white/20">
                <i class="fas fa-user text-base"></i>
                <i class="fas fa-chevron-down text-[10px] transition-transform group-hover:rotate-180 duration-300"></i>
              </button>
              
              <!-- Dropdown -->
              <div class="absolute right-0 mt-2 w-55 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                <div class="bg-black/95 backdrop-blur-xl border-2 border-amber-500/40 rounded-lg shadow-2xl shadow-amber-500/30 overflow-hidden">
                  <div class="p-1">
                    <a href="/?sec=profile" class="flex items-center gap-3 px-4 py-3 text-sm text-white/90 hover:text-amber-500 hover:bg-amber-500/10 rounded-md transition-all group/item">
                      <i class="fas fa-user-circle w-5 text-center text-lg text-white/70 group-hover/item:text-amber-500 transition-colors"></i>
                      <span class="font-mono font-bold tracking-wide">MI CUENTA</span>
                    </a>
                    <a href="/?sec=orders" class="flex items-center gap-3 px-4 py-3 text-sm text-white/90 hover:text-amber-500 hover:bg-amber-500/10 rounded-md transition-all group/item">
                      <i class="fas fa-file-invoice w-5 text-center text-lg text-white/70 group-hover/item:text-amber-500 transition-colors"></i>
                      <span class="font-mono font-bold tracking-wide">MIS COMPRAS</span>
                    </a>
                    <div class="h-px bg-gradient-to-r from-transparent via-amber-500/30 to-transparent my-1"></div>
                    <form action="/?sec=actions&action=logout" method="POST" class="m-0">
                      <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-400 hover:text-red-500 hover:bg-red-500/10 rounded-md transition-all group/item">
                        <i class="fas fa-sign-out-alt w-5 text-center text-lg text-red-500/60 group-hover/item:text-red-500 transition-colors"></i>
                        <span class="font-mono font-bold tracking-wide">SALIR</span>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php else: ?>
            <!-- LOGIN -->
            <a href="/?sec=login" class="relative group overflow-hidden px-4 py-2 rounded-md border border-white/50 bg-gradient-to-r from-white to-white/90 hover:from-white/90 hover:to-white text-black font-bold font-mono text-sm shadow-md shadow-white/20 hover:shadow-lg hover:shadow-white/30 transition-all">
              <span class="relative z-10">INICIAR SESIÓN</span>
              <div class="absolute inset-0 bg-gradient-to-r from-white/80 to-white opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </a>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </nav>

  
  <div class="h-px bg-gradient-to-r from-transparent via-amber-500 to-transparent opacity-50"></div>

  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black/70 opacity-0 pointer-events-none transition-opacity duration-300 z-40"></div>

  <!-- Off-canvas Menu -->
  <aside id="mobileMenu"
         class="fixed top-4 bottom-4 left-4 w-[20rem] sm:w-[22rem] bg-black/95 backdrop-blur-md text-white -translate-x-[120%] transition-transform duration-300 ease-out z-50 border border-amber-500/40 rounded-xl flex flex-col shadow-2xl shadow-amber-500/30">
    
    <!-- Header del menú -->
    <div class="p-6 border-b border-amber-500/20">
      <div class="flex items-start justify-between gap-4">
        <a href="/?sec=abyssum" class="text-3xl font-bold font-mono text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 drop-shadow-[0_0_15px_rgba(251,191,36,0.5)]">
          ABYSSUM
        </a>
        <button data-action="close-menu" aria-label="Cerrar menú"
          class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 transition group">
          <span class="relative flex items-center justify-center w-4 h-4">
            <span class="absolute w-full h-0.5 bg-amber-500 rotate-45 group-hover:bg-white transition"></span>
            <span class="absolute w-full h-0.5 bg-amber-500 -rotate-45 group-hover:bg-white transition"></span>
          </span>
        </button>
      </div>
      <p class="text-xs text-amber-200/60 leading-relaxed pt-3 font-mono">
        Portal de acceso al abismo digital. Contratos demoníacos, pactos arcanos y créditos infernales.
      </p>
    </div>

    <!-- Contenido scrollable -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
      
      <!-- Navegación principal -->
      <nav class="space-y-2 font-mono text-base tracking-wide">
        <?php
          $links = [
            'abyssum' => ['label' => 'INICIO', 'icon' => 'fa-home'],
            'pacts' => ['label' => 'PACTOS', 'icon' => 'fa-file-contract'],
            'demons' => ['label' => 'DEMONIOS', 'icon' => 'fa-skull'],
            'sellador' => ['label' => 'SELLADOR', 'icon' => 'fa-user-secret'],
            'contact' => ['label' => 'CONTACTO', 'icon' => 'fa-envelope']
          ];
          foreach ($links as $slug => $data):
            $active = $current === $slug;
        ?>
          <a href="/?sec=<?= $slug ?>"
             class="group flex items-center gap-3 px-4 py-3 rounded-md transition relative <?= $active ? 'bg-amber-500/20 text-amber-500 border border-amber-500/40' : 'text-white/70 hover:bg-amber-500/10 hover:text-amber-500 border border-transparent hover:border-amber-500/20' ?>">
            <i class="fas <?= $data['icon'] ?> w-5 text-center <?= $active ? 'text-amber-500' : 'text-white/60 group-hover:text-amber-500' ?> transition-colors"></i>
            <span class="font-bold"><?= $data['label'] ?></span>
            <?php if ($active): ?>
              <span class="ml-auto w-2 h-2 rounded-full bg-amber-500 shadow-lg shadow-amber-500/50 animate-pulse"></span>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <!-- Separador -->
      <div class="h-px bg-gradient-to-r from-transparent via-amber-500/30 to-transparent"></div>

      <!-- Acciones rápidas -->
      <div class="space-y-4">
        <h3 class="text-xs tracking-widest font-mono text-amber-500 uppercase font-bold flex items-center gap-2">
          <i class="fas fa-bolt"></i>
          ACCESO RÁPIDO
        </h3>
        <div class="grid grid-cols-2 gap-3">
          <a href="/?sec=pacts" class="group relative overflow-hidden px-3 py-4 rounded-lg bg-gradient-to-br from-amber-500/20 to-amber-600/10 border border-amber-500/30 hover:border-amber-500/60 transition-all">
            <div class="relative z-10 flex flex-col items-center gap-2 text-center">
              <i class="fas fa-file-contract text-2xl text-amber-500 group-hover:scale-110 transition-transform"></i>
              <span class="text-xs font-mono font-bold text-white/90">PACTOS</span>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </a>
          
          <a href="/?sec=cart" class="group relative overflow-hidden px-3 py-4 rounded-lg bg-gradient-to-br from-white/5 to-white/[0.02] border border-white/20 hover:border-white/40 transition-all">
            <div class="relative z-10 flex flex-col items-center gap-2 text-center">
              <i class="fas fa-shopping-cart text-2xl text-white/70 group-hover:text-white group-hover:scale-110 transition-all"></i>
              <span class="text-xs font-mono font-bold text-white/90">CARRITO</span>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </a>
          
          <a href="/?sec=contact" class="group relative overflow-hidden px-3 py-4 rounded-lg bg-gradient-to-br from-white/5 to-white/[0.02] border border-white/20 hover:border-white/40 transition-all">
            <div class="relative z-10 flex flex-col items-center gap-2 text-center">
              <i class="fas fa-envelope text-2xl text-white/70 group-hover:text-white group-hover:scale-110 transition-all"></i>
              <span class="text-xs font-mono font-bold text-white/90">CONTACTO</span>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </a>
          
          <a href="/?sec=profile" class="group relative overflow-hidden px-3 py-4 rounded-lg bg-gradient-to-br from-white/5 to-white/[0.02] border border-white/20 hover:border-white/40 transition-all">
            <div class="relative z-10 flex flex-col items-center gap-2 text-center">
              <i class="fas fa-user-circle text-2xl text-white/70 group-hover:text-white group-hover:scale-110 transition-all"></i>
              <span class="text-xs font-mono font-bold text-white/90">PERFIL</span>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </a>
        </div>
      </div>
    </div>

    <!-- Footer del menú -->
    <div class="p-4 border-t border-amber-500/20">
      <div class="flex items-center justify-between text-[10px] text-amber-200/40 font-mono">
        <span>&copy; <?= date('Y'); ?> ABYSSUM</span>
        <span class="uppercase tracking-widest">CYBERHELL</span>
      </div>
    </div>
  </aside>
</header>