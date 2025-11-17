<?php
require_once BASE_PATH . '/classes/Pact.php';
require_once BASE_PATH . '/classes/Demon.php';
require_once BASE_PATH . '/classes/Cart.php';
require_once BASE_PATH . '/classes/Order.php';
require_once BASE_PATH . '/classes/Category.php';
require_once BASE_PATH . '/classes/PactFilter.php';
require_once BASE_PATH . '/classes/DbConnection.php';

$dbError = false;
$pacts = [];
$demonsMap = [];
$hasActiveFilters = false;

try {
    // inicializar filtros
    $pactFilter = new PactFilter();
    $pactFilter->showToastIfNeeded();

    // obtener pactos filtrados
    $pacts = $pactFilter->getPacts();

    // variable para el template
    $hasActiveFilters = $pactFilter->hasActiveFilters();

    // pre-cargar todos los demonios
    $demonIds = array_unique(array_filter(array_column($pacts, 'demon_id')));
    if (!empty($demonIds)) {
        // convertir a array de enteros
        $demonIds = array_values(array_map('intval', $demonIds));
        $demons = Demon::findMultiple($demonIds);
        foreach ($demons as $demon) {
            $demonsMap[$demon->id] = $demon;
        }
    }
} catch (Exception $e) {
    $dbError = true;
    $pacts = [];
}

// obtener todas las categorías para los filtros
$allCategories = Category::allExcludingDemons();

// obtener todos los demonios para el dropdown de filtro
$allDemons = [];
try {
    $allDemons = Demon::all();
} catch (Exception $e) {
    $allDemons = [];
}

// obtener pactos ya comprados por el usuario
$purchasedPactIds = [];
if (isset($_SESSION['user_id'])) {
    $purchasedPactIds = Order::getPurchasedPactIds((int)$_SESSION['user_id']);
}
?>

<div class="min-h-screen bg-black relative overflow-hidden py-20 px-4 font-mono">
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>
  
  <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 relative z-10">
    
    <!-- título -->
    <div class="text-center mb-6 pacts-title">
      <h1 class="text-6xl font-bold tracking-widest text-amber-500 font-mono">
        PACTOS
      </h1>
    </div>

    <!-- instrucciones arriba -->
    <div class="text-center mb-8 pacts-instructions">
      <p class="text-amber-600/70 text-sm font-mono uppercase tracking-widest">
        // Pasa el cursor sobre un pacto para revelar detalles
      </p>
    </div>

    <!-- buscador sutil -->
    <div class="mb-6 search-container">
      <div class="max-w-lg mx-auto flex items-center gap-3">
        <div class="relative flex-1">
          <input type="text" id="searchInput" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// buscar pactos..." />
          <span class="absolute right-3 top-1/2 -translate-y-1/2 text-amber-600/50 text-xs">CTRL+K</span>
        </div>
        <button class="px-4 py-2 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 rounded transition text-sm tracking-wide" type="button" id="clearBtn">LIMPIAR</button>
      </div>
    </div>

    <!-- filtros -->
    <div class="mb-8 bg-black/70 border border-amber-600/30 rounded-xl p-6 filters-container">
      <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="hidden" name="sec" value="pacts">

        <!-- filtro por demonio -->
        <div class="filter-item group">
          <label class="block text-amber-500 text-xs font-mono mb-2 uppercase tracking-wider">
            <i class="fa-solid fa-skull mr-2"></i>Demonio
          </label>
          <div class="relative">
            <select name="demon" class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-3 py-2 pr-10 text-sm font-mono focus:border-amber-500 focus:outline-none appearance-none cursor-pointer">
              <option value="">Todos</option>
              <?php foreach ($allDemons as $demon): ?>
                <option value="<?= $demon->id ?>" <?= (isset($_GET['demon']) && (int)$_GET['demon'] === $demon->id) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($demon->name) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-amber-500/70 text-xs pointer-events-none transition-transform duration-300"></i>
          </div>
        </div>

        <!-- filtro por categoría -->
        <div class="filter-item group">
          <label class="block text-amber-500 text-xs font-mono mb-2 uppercase tracking-wider">
            <i class="fa-solid fa-tag mr-2"></i>Categoría
          </label>
          <div class="relative">
            <select name="category" class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-3 py-2 pr-10 text-sm font-mono focus:border-amber-500 focus:outline-none appearance-none cursor-pointer">
              <option value="">Todas</option>
              <?php foreach ($allCategories as $cat): ?>
                <option value="<?= htmlspecialchars($cat->slug) ?>" <?= (isset($_GET['category']) && $_GET['category'] === $cat->slug) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($cat->display_name) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-amber-500/70 text-xs pointer-events-none transition-transform duration-300"></i>
          </div>
        </div>

        <!-- ordenar por -->
        <div class="filter-item group">
          <label class="block text-amber-500 text-xs font-mono mb-2 uppercase tracking-wider">
            <i class="fa-solid fa-arrow-down-short-wide mr-2"></i>Ordenar
          </label>
          <div class="relative">
            <select name="sort" class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-3 py-2 pr-10 text-sm font-mono focus:border-amber-500 focus:outline-none appearance-none cursor-pointer">
              <option value="newest" <?= (!isset($_GET['sort']) || $_GET['sort'] === 'newest') ? 'selected' : '' ?>>Más reciente</option>
              <option value="oldest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : '' ?>>Más antiguo</option>
              <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'price_asc') ? 'selected' : '' ?>>Precio: Menor a Mayor</option>
              <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'price_desc') ? 'selected' : '' ?>>Precio: Mayor a Menor</option>
              <option value="name_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'name_asc') ? 'selected' : '' ?>>Nombre: A-Z</option>
              <option value="name_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'name_desc') ? 'selected' : '' ?>>Nombre: Z-A</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-amber-500/70 text-xs pointer-events-none transition-transform duration-300"></i>
          </div>
        </div>

        <!-- botones -->
        <div class="flex items-end gap-2 filter-buttons">
          <button type="submit" class="flex-1 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 text-xs font-bold py-2 px-4 rounded font-mono transition-all">
            <i class="fa-solid fa-filter mr-2"></i>FILTRAR
          </button>
          <?php if ($hasActiveFilters): ?>
            <a href="/?sec=pacts" class="bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 text-xs font-bold py-2 px-4 rounded font-mono transition-all" title="Limpiar filtros" onclick="window.toastCleared = true;">
              <i class="fa-solid fa-xmark"></i>
            </a>
          <?php else: ?>
            <button type="button" class="bg-black/40 border border-amber-600/20 text-amber-600/50 text-xs font-bold py-2 px-4 rounded font-mono cursor-not-allowed" disabled title="No hay filtros activos">
              <i class="fa-solid fa-xmark"></i>
            </button>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <?php if ($dbError): ?>
      <div class="text-center py-12">
        <div class="text-red-400 font-mono text-xl mb-2">
          // ERROR DE CONEXIÓN
        </div>
        <div class="text-amber-400/60 font-mono">
          No se pudieron cargar los pactos. Por favor, intenta más tarde.
        </div>
      </div>
    <?php elseif (empty($pacts)): ?>
      <div class="text-center text-amber-400 font-mono text-lg py-12">
        // NO HAY PACTOS DISPONIBLES
      </div>
    <?php else: ?>
      <!-- container cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <?php foreach ($pacts as $pact): ?>
          <?php 
          $demon = $demonsMap[$pact->demon_id] ?? null;
          $demonName = $demon ? $demon->name : 'Desconocido';
          $categories = $pact->categories();
          $inCart = Cart::has($pact->id);
          
          
          $imagePath = '/assets/img/pacts/16861331.png'; // Fallback
          
          if ($pact->image_file_id) {
              // si tiene file_id, usar el sistema de archivos
              $imagePath = "/?file_id={$pact->image_file_id}";
          } elseif ($demon && $pact->slug) {
              // intentar construir ruta basada en patrón
              $demonFolder = ucfirst($demon->slug);
              $pactSlugClean = str_replace('-', '_', $pact->slug);
              
              // buscar archivo que coincida
              $globPath = BASE_PATH . "/public/assets/img/pacts/{$demonFolder}/*{$pactSlugClean}*.png";
              $files = glob($globPath);
              
              if (!empty($files)) {
                  $filename = basename($files[0]);
                  $imagePath = "/assets/img/pacts/{$demonFolder}/{$filename}";
              }
          }
          ?>
          
          <?php 
            $searchable = strtolower(($pact->name ?? '') . ' ' . ($demonName ?? '') . ' ' . ($pact->summary ?? ''));
          ?>
          <div class="expandable-card-container" data-searchable="<?= htmlspecialchars($searchable) ?>">
            <div class="expandable-card group" data-pact="pact-<?= $pact->id ?>">
              
              <!-- imagen principal -->
              <div class="card-image relative overflow-hidden rounded-xl border-2 border-amber-600/30 bg-black shadow-2xl shadow-amber-500/20">


                <img 
                  src="<?= htmlspecialchars($imagePath) ?>" 
                  alt="<?= htmlspecialchars($pact->name) ?>" 
                  class="w-full h-full object-cover opacity-80"
                  onerror="this.src='/assets/img/pacts/16861331.png'"
                >
                
                <!-- info discreta en la esquina -->
                <div class="card-info">
                  <p class="text-amber-500 text-xs font-mono font-semibold"><?= htmlspecialchars($demonName) ?></p>
                  <p class="text-amber-300 text-sm font-mono font-bold"><?= htmlspecialchars($pact->name) ?></p>
                </div>
              </div>

              <!-- Menú expandible -->
              <div class="card-menu">
                <!-- Panel izquierdo - Precio -->
                <div class="menu-panel menu-left bg-black/95 border-2 border-amber-600/40 backdrop-blur-sm h-38">
                  <div class="p-4 h-full flex flex-col">
                    <h4 class="text-amber-500 font-mono text-sm mb-3 border-b border-amber-600/30 pb-2 uppercase tracking-wider text-center">
                      <i class="fa-solid fa-coins mr-2"></i>Precio
                    </h4>
                    <div class="flex-1 flex items-center justify-center">
                      <span class="text-3xl font-bold text-amber-500 font-mono">
                        <?= $pact->price_credits ?>
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Panel derecho - Acciones -->
                <div class="menu-panel menu-right bg-black/95 border-2 border-amber-600/40 backdrop-blur-sm h-38">
                  <div class="p-4">
                    <h4 class="text-amber-500 font-mono text-sm mb-3 border-b border-amber-600/30 pb-2 uppercase tracking-wider text-center">
                      <i class="fa-solid fa-bolt mr-2"></i>Acciones
                    </h4>
                    <div class="space-y-2">
                      <?php 
                      $isPurchased = in_array($pact->id, $purchasedPactIds);
                      $inCart = Cart::has($pact->id);
                      ?>
                      
                      <!-- Botón agregar al carrito -->
                      <?php if ($isPurchased): ?>
                        <div class="w-full bg-green-900/30 text-green-400 text-xs font-bold py-2 px-3 rounded font-mono border border-green-500/50 text-center flex items-center justify-center gap-2">
                          <i class="fa-solid fa-check-circle"></i> ADQUIRIDO
                        </div>
                      <?php elseif ($inCart): ?>
                        <div class="w-full bg-blue-900/30 text-blue-400 text-xs font-bold py-2 px-3 rounded font-mono border border-blue-500/50 text-center flex items-center justify-center gap-2">
                          <i class="fa-solid fa-cart-shopping"></i> EN CARRITO
                        </div>
                      <?php else: ?>
                        <form method="POST" action="/?sec=actions&action=add-to-cart">
                          <input type="hidden" name="pact_id" value="<?= $pact->id ?>">
                          <button type="submit" class="w-full bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 text-xs font-bold py-2 px-3 rounded font-mono transition-all hover:shadow-lg hover:shadow-amber-500/30 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> AGREGAR
                          </button>
                        </form>
                      <?php endif; ?>
                      
                      <!-- Botón ver detalles -->
                      <a href="/?sec=pact-detail&pact_id=<?= $pact->id ?>" class="block w-full bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 text-xs font-bold py-2 px-3 rounded font-mono transition-all text-center">
                        VER
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Panel superior - Nombre y Demonio -->
                <div class="menu-panel menu-top bg-black/95 border-2 border-amber-600/40 backdrop-blur-sm">
                  <div class="p-3 text-center">
                    <p class="text-amber-500 font-bold text-sm font-mono mb-1 uppercase tracking-wider">
                      <?= htmlspecialchars($pact->name) ?>
                    </p>
                    <p class="text-amber-600/70 text-xs font-mono flex items-center justify-center gap-1">
                      <i class="fa-solid fa-skull"></i> <?= htmlspecialchars($demonName) ?>
                    </p>
                  </div>
                </div>

                <!-- Panel inferior - Resumen -->
                <div class="menu-panel menu-bottom bg-black/95 border-2 border-amber-600/40 backdrop-blur-sm">
                  <div class="p-3">
                    <p class="text-amber-400 text-xs font-mono text-center">
                      <?= htmlspecialchars($pact->summary ?? 'Pacto demoníaco disponible') ?>
                    </p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>

  </div>
</div>