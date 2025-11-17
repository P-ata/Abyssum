<?php
$currentPage = $_GET['page'] ?? 'dashboard';
?>

<header class="sticky top-0 z-50">
  <nav class="bg-black border-b border-amber-500/20">
    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-3 h-16 items-center">
        
        <!-- izquierda menu button -->
        <div class="justify-self-start">
          <button id="adminMenuBtn"
                  class="inline-flex items-center justify-center p-2 rounded-md hover:bg-amber-500/10 transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/40 text-white/90"
                  aria-label="Abrir menú" aria-controls="adminMobileMenu" aria-expanded="false">
            <span class="sr-only">Abrir menú</span>
            <span class="block w-6 h-4 relative">
              <span class="bar bar-top absolute left-0 top-0 h-0.5 w-6 bg-current transition-all duration-300 ease-in-out origin-left"></span>
              <span class="bar bar-mid absolute left-0 top-1/2 -translate-y-1/2 h-0.5 w-5 bg-current transition-all duration-300 ease-in-out origin-left"></span>
              <span class="bar bar-bot absolute left-0 bottom-0 h-0.5 w-4 bg-current transition-all duration-300 ease-in-out origin-left"></span>
            </span>
          </button>
        </div>

        <!-- para que respete el espacio -->
        <div></div>

        <!-- derecha: link al sitio y logout -->
        <div class="justify-self-end flex items-center gap-3">
          <!-- Link al sitio público -->
          <a href="/" 
             class="flex items-center gap-2 px-3 py-2 rounded-md border border-white/40 bg-gradient-to-br from-white/10 to-white/5 hover:from-white/15 hover:to-white/10 hover:border-white/60 transition-all text-white shadow-lg shadow-white/10 hover:shadow-white/20">
            <i class="fas fa-globe text-base"></i>
          </a>
          
          <!-- Logout -->
          <a href="/?sec=admin&action=logout" 
             class="flex items-center gap-2 px-3 py-2 rounded-md border border-red-600/40 bg-gradient-to-br from-red-600/10 to-red-600/5 hover:from-red-600/20 hover:to-red-600/10 hover:border-red-600/60 transition-all text-red-500 shadow-lg shadow-red-500/10 hover:shadow-red-500/20">
            <i class="fas fa-right-from-bracket text-base"></i>
          </a>
        </div>

      </div>
    </div>
  </nav>

  <!-- borde decorativo brillante -->
  <div class="h-px bg-gradient-to-r from-transparent via-amber-500 to-transparent opacity-50"></div>

  <!-- Overlay -->
  <div id="adminOverlay" class="fixed inset-0 bg-black/70 opacity-0 pointer-events-none transition-opacity duration-300 z-40"></div>

  <!-- Off-canvas Menu -->
  <aside id="adminMobileMenu"
         class="fixed top-4 bottom-4 left-4 w-[20rem] sm:w-[22rem] bg-black/95 backdrop-blur-md text-white -translate-x-[120%] transition-transform duration-300 ease-out z-50 border border-amber-500/40 rounded-xl flex flex-col shadow-2xl shadow-amber-500/30">
    
    <!-- header del menú -->
    <div class="p-6 border-b border-amber-500/20">
      <div class="flex items-start justify-between gap-4">
        <div class="flex flex-col gap-2">
          <a href="/?sec=admin&page=dashboard" class="text-3xl font-bold font-mono text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 drop-shadow-[0_0_15px_rgba(251,191,36,0.5)]">
            ABYSSUM
          </a>
          <div class="inline-flex items-start">
            <div class="px-2 py-1 bg-red-600/20 border border-red-600/40 rounded">
              <span class="text-red-500 text-xs font-bold tracking-widest">PANEL DE ADMINISTRACIÓN</span>
            </div>
          </div>
        </div>
        <button data-action="close-admin-menu" aria-label="Cerrar menú"
          class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 transition group">
          <span class="relative flex items-center justify-center w-4 h-4">
            <span class="absolute w-full h-0.5 bg-amber-500 rotate-45 group-hover:bg-white transition"></span>
            <span class="absolute w-full h-0.5 bg-amber-500 -rotate-45 group-hover:bg-white transition"></span>
          </span>
        </button>
      </div>
      <p class="text-xs text-amber-200/60 leading-relaxed pt-3 font-mono">
        Control total sobre pactos, usuarios, órdenes y sistema.
      </p>
    </div>

    <!-- Contenido scrollable -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
      
      <!-- Navegación principal -->
      <nav class="space-y-2 font-mono text-base tracking-wide">
        <?php
          $adminLinks = [
            'dashboard' => ['label' => 'DASHBOARD', 'icon' => 'fa-gauge'],
            'pacts' => ['label' => 'PACTOS', 'icon' => 'fa-scroll'],
            'demons' => ['label' => 'DEMONIOS', 'icon' => 'fa-skull'],
            'users' => ['label' => 'USUARIOS', 'icon' => 'fa-users'],
            'orders' => ['label' => 'ÓRDENES', 'icon' => 'fa-cart-shopping'],
            'contacts' => ['label' => 'CONTACTOS', 'icon' => 'fa-envelope'],
            'health' => ['label' => 'HEALTH', 'icon' => 'fa-heart-pulse']
          ];
          foreach ($adminLinks as $page => $data):
            $active = $currentPage === $page;
        ?>
          <a href="/?sec=admin&page=<?= $page ?>"
             class="group flex items-center gap-3 px-4 py-3 rounded-md transition relative <?= $active ? 'bg-amber-500/20 text-amber-500 border border-amber-500/40' : 'text-white/70 hover:bg-amber-500/10 hover:text-amber-500 border-transparent hover:border-amber-500/20' ?>">
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

    </div>

    <!-- footer del menú pegado abajo -->
    <div class="mt-auto p-4 border-t border-amber-500/20">
      <div class="flex items-center justify-between text-[10px] text-amber-200/40 font-mono">
        <span>&copy; <?= date('Y'); ?> ABYSSUM</span>
        <span class="uppercase tracking-widest">ADMIN PANEL</span>
      </div>
    </div>
  </aside>
</header>

<script>
// admin menu toggle
document.addEventListener('DOMContentLoaded', function() {
  const menuBtn = document.getElementById('adminMenuBtn');
  const menu = document.getElementById('adminMobileMenu');
  const overlay = document.getElementById('adminOverlay');
  const closeBtn = document.querySelector('[data-action="close-admin-menu"]');

  function openMenu() {
    menu.classList.remove('-translate-x-[120%]');
    menu.classList.add('translate-x-0');
    overlay.classList.remove('opacity-0', 'pointer-events-none');
    overlay.classList.add('opacity-100', 'pointer-events-auto');
    menuBtn.setAttribute('aria-expanded', 'true');
    
    // Animar barras del botón
    const bars = menuBtn.querySelectorAll('.bar');
    bars[0].style.transform = 'rotate(45deg) scaleX(1.2)';
    bars[1].style.opacity = '0';
    bars[2].style.transform = 'rotate(-45deg) scaleX(1.2)';
  }

  function closeMenu() {
    menu.classList.add('-translate-x-[120%]');
    menu.classList.remove('translate-x-0');
    overlay.classList.add('opacity-0', 'pointer-events-none');
    overlay.classList.remove('opacity-100', 'pointer-events-auto');
    menuBtn.setAttribute('aria-expanded', 'false');
    
    // Resetear barras del botón
    const bars = menuBtn.querySelectorAll('.bar');
    bars[0].style.transform = '';
    bars[1].style.opacity = '1';
    bars[2].style.transform = '';
  }

  menuBtn.addEventListener('click', function() {
    const isOpen = menu.classList.contains('translate-x-0');
    if (isOpen) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  closeBtn.addEventListener('click', closeMenu);
  overlay.addEventListener('click', closeMenu);

  // cerrar con ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && menu.classList.contains('translate-x-0')) {
      closeMenu();
    }
  });
});
</script>
