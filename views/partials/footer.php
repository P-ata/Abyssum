  <footer class="relative border-t border-amber-500/20 bg-black">
    <!-- Línea decorativa superior con glow -->
    <div class="h-px bg-gradient-to-r from-transparent via-amber-500 to-transparent opacity-50"></div>
    
    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 py-12">
      <!-- Grid principal -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        
        <!-- Columna 1: Branding -->
        <div class="space-y-4">
          <h3 class="text-2xl font-bold font-mono text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 drop-shadow-[0_0_15px_rgba(251,191,36,0.5)]">
            ABYSSUM
          </h3>
          <p class="text-sm text-amber-200/60 font-mono leading-relaxed">
            Portal de acceso al abismo digital. Contratos demoníacos, pactos arcanos y créditos infernales.
          </p>
          <!-- Redes sociales -->
          <div class="flex gap-3 pt-2">
            <a href="#" class="w-10 h-10 rounded-md border border-amber-500/40 bg-amber-500/10 hover:bg-amber-500/20 hover:border-amber-500/60 flex items-center justify-center transition-all text-amber-500 hover:text-amber-400 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40">
              <i class="fab fa-x-twitter"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-md border border-amber-500/40 bg-amber-500/10 hover:bg-amber-500/20 hover:border-amber-500/60 flex items-center justify-center transition-all text-amber-500 hover:text-amber-400 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40">
              <i class="fab fa-discord"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-md border border-amber-500/40 bg-amber-500/10 hover:bg-amber-500/20 hover:border-amber-500/60 flex items-center justify-center transition-all text-amber-500 hover:text-amber-400 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40">
              <i class="fab fa-github"></i>
            </a>
          </div>
        </div>
        
        <!-- Columna 2: Links rápidos -->
        <div class="space-y-4">
          <h4 class="text-sm font-bold font-mono text-amber-500 uppercase tracking-widest flex items-center gap-2">
            <i class="fas fa-terminal text-xs"></i>
            Navegación
          </h4>
          <nav class="space-y-2">
            <a href="/?sec=abyssum" class="block text-sm text-white/70 hover:text-amber-500 transition-colors font-mono group">
              <span class="inline-block group-hover:translate-x-1 transition-transform">→</span> Inicio
            </a>
            <a href="/?sec=pacts" class="block text-sm text-white/70 hover:text-amber-500 transition-colors font-mono group">
              <span class="inline-block group-hover:translate-x-1 transition-transform">→</span> Pactos
            </a>
            <a href="/?sec=cart" class="block text-sm text-white/70 hover:text-amber-500 transition-colors font-mono group">
              <span class="inline-block group-hover:translate-x-1 transition-transform">→</span> Carrito
            </a>
            <a href="/?sec=contact" class="block text-sm text-white/70 hover:text-amber-500 transition-colors font-mono group">
              <span class="inline-block group-hover:translate-x-1 transition-transform">→</span> Contacto
            </a>
          </nav>
        </div>
        
        <!-- Columna 3: Info de contacto -->
        <div class="space-y-4">
          <h4 class="text-sm font-bold font-mono text-amber-500 uppercase tracking-widest flex items-center gap-2">
            <i class="fas fa-broadcast-tower text-xs"></i>
            Transmisión
          </h4>
          <div class="space-y-3 text-sm text-white/70 font-mono">
            <div class="flex items-start gap-3">
              <i class="fas fa-envelope text-amber-500/60 mt-1"></i>
              <span>contact@abyssum.dev</span>
            </div>
            <div class="flex items-start gap-3">
              <i class="fas fa-map-marker-alt text-amber-500/60 mt-1"></i>
              <span>The Void, Digital Realm</span>
            </div>
            <div class="flex items-start gap-3">
              <i class="fas fa-clock text-amber-500/60 mt-1"></i>
              <span>24/7 Disponible</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Separador -->
      <div class="h-px bg-gradient-to-r from-transparent via-amber-500/30 to-transparent mb-6"></div>
      
      <!-- Footer inferior -->
      <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="text-xs text-amber-200/40 font-mono">
          <span class="inline-block mr-2">©</span>
          <span><?= date('Y'); ?> ABYSSUM</span>
          <span class="mx-2">•</span>
          <span class="text-amber-500/60">CYBERHELL</span>
        </div>
        
        <div class="flex items-center gap-4 text-xs text-white/40 font-mono">
          <a href="#" class="hover:text-amber-500 transition-colors">Términos</a>
          <span class="text-amber-500/30">|</span>
          <a href="#" class="hover:text-amber-500 transition-colors">Privacidad</a>
          <span class="text-amber-500/30">|</span>
          <a href="#" class="hover:text-amber-500 transition-colors">Cookies</a>
        </div>
        
        <div class="flex items-center gap-2 text-xs text-white/40 font-mono">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
          </span>
          <span>Sistema operativo</span>
        </div>
      </div>
    </div>
    
    <!-- Efectos de fondo -->
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-amber-500/20 to-transparent"></div>
  </footer>
  
  <!-- GSAP Library for animations -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
  
  <!-- Header Animations -->
  <script src="/assets/js/header-animations.js"></script>
  
  <!-- Cart Animations -->
  <script src="/assets/js/cart-animations.js"></script>
  
  <!-- Toast System -->
  <?php
  require_once BASE_PATH . '/classes/Toast.php';
  $hasToasts = Toast::hasToasts();
  $toastData = $hasToasts ? Toast::getAll() : [];
  ?>
  
  <?php if ($hasToasts || true): // Siempre incluir para toast de limpieza ?>
    <script src="/assets/admin/js/toast.js"></script>
    <?php if (!empty($toastData)): ?>
      <script>
        window.TOAST_DATA = <?= json_encode($toastData) ?>;
      </script>
    <?php endif; ?>
  <?php endif; ?>
  
  <!-- Filter Clear Toast -->
  <script>
    // Detectar cuando se limpian filtros (solo con acción del usuario, no en refresh)
    if (window.performance && window.performance.navigation.type !== 1) { // No es reload
      if (window.location.search === '?sec=pacts' && document.referrer) {
        const currentUrl = new URL(window.location.href);
        const refUrl = new URL(document.referrer);
        
        // Solo si el referrer es la misma página de pacts
        if (refUrl.pathname === currentUrl.pathname && refUrl.searchParams.get('sec') === 'pacts') {
          const refParams = refUrl.searchParams;
          const currentParams = currentUrl.searchParams;
          
          // Si el referrer tenía filtros pero ahora no
          const hadFilters = refParams.has('demon') || refParams.has('category') || (refParams.has('sort') && refParams.get('sort') !== 'newest');
          const hasFilters = currentParams.has('demon') || currentParams.has('category') || (currentParams.has('sort') && currentParams.get('sort') !== 'newest');
          
          if (hadFilters && !hasFilters) {
            // Esperar a que el sistema de toast se cargue
            const waitForToast = setInterval(() => {
              if (typeof showToast !== 'undefined') {
                clearInterval(waitForToast);
                showToast('success', 'Filtros eliminados correctamente');
              }
            }, 50);
            
            // Timeout de seguridad
            setTimeout(() => clearInterval(waitForToast), 2000);
          }
        }
      }
    }
  </script>
</body>
</html>
