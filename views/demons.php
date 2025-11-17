<?php
require_once BASE_PATH . '/classes/DemonFilter.php';
require_once BASE_PATH . '/classes/Category.php';
require_once BASE_PATH . '/classes/DbConnection.php';

$dbError = false;
$demons = [];
$hasActiveFilters = false;

try {
    // Mostrar toast si hay filtros aplicados
    DemonFilter::showToastIfNeeded();
    
    // Aplicar filtros y ordenamiento
    $result = DemonFilter::applyFilters();
    $demons = $result['demons'];
    $hasActiveFilters = $result['hasActiveFilters'];
} catch (Exception $e) {
    $dbError = true;
    $demons = [];
}

// Obtener todas las categorías para los filtros (solo las de demonios)
$allCategories = [];
try {
    $allCategories = Category::allForDemons();
} catch (Exception $e) {
    $allCategories = [];
}
?>

<div class="min-h-screen bg-black relative overflow-hidden py-20 px-4 font-mono">
  <!-- Ambient background grid & glow -->
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>
  
  <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 relative z-10">
    
    <!-- Título -->
    <div class="text-center mb-6 demons-title">
      <h1 class="text-6xl font-bold tracking-widest text-amber-500 font-mono">
        DEMONIOS
      </h1>
    </div>

    <!-- Instrucciones arriba -->
    <div class="text-center mb-8 demons-instructions">
      <p class="text-amber-600/70 text-sm font-mono uppercase tracking-widest">
        // Pasa el cursor sobre un demonio para revelar detalles
      </p>
    </div>

    <!-- Buscador sutil -->
    <div class="mb-6 search-container">
      <div class="max-w-lg mx-auto flex items-center gap-3">
        <div class="relative flex-1">
          <input type="text" id="searchInput" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// buscar demonios..." />
          <span class="absolute right-3 top-1/2 -translate-y-1/2 text-amber-600/50 text-xs">CTRL+K</span>
        </div>
        <button class="px-4 py-2 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 rounded transition text-sm tracking-wide" type="button" id="clearBtn">LIMPIAR</button>
      </div>
    </div>

    <!-- Filtros -->
    <div class="mb-8 bg-black/70 border border-amber-600/30 rounded-xl p-6 filters-container">
      <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="hidden" name="sec" value="demons">

        <!-- Filtro por Categoría -->
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

        <!-- Ordenar por -->
        <div class="filter-item group">
          <label class="block text-amber-500 text-xs font-mono mb-2 uppercase tracking-wider">
            <i class="fa-solid fa-arrow-down-short-wide mr-2"></i>Ordenar
          </label>
          <div class="relative">
            <select name="sort" class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-3 py-2 pr-10 text-sm font-mono focus:border-amber-500 focus:outline-none appearance-none cursor-pointer">
              <option value="newest" <?= (!isset($_GET['sort']) || $_GET['sort'] === 'newest') ? 'selected' : '' ?>>Más reciente</option>
              <option value="oldest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : '' ?>>Más antiguo</option>
              <option value="name_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'name_asc') ? 'selected' : '' ?>>Nombre: A-Z</option>
              <option value="name_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'name_desc') ? 'selected' : '' ?>>Nombre: Z-A</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-amber-500/70 text-xs pointer-events-none transition-transform duration-300"></i>
          </div>
        </div>

        <!-- Botones -->
        <div class="flex items-end gap-2 filter-buttons">
          <button type="submit" class="flex-1 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 text-xs font-bold py-2 px-4 rounded font-mono transition-all">
            <i class="fa-solid fa-filter mr-2"></i>FILTRAR
          </button>
          <?php if ($hasActiveFilters): ?>
            <a href="/?sec=demons" class="bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 text-xs font-bold py-2 px-4 rounded font-mono transition-all" title="Limpiar filtros" onclick="window.toastCleared = true;">
              <i class="fa-solid fa-xmark"></i>
            </a>
          <?php else: ?>
            <button type="button" class="bg-black/40 border border-amber-600/20 text-amber-600/50 text-xs font-bold py-2 px-4 rounded font-mono cursor-not-allowed" disabled>
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
          No se pudieron cargar los demonios. Por favor, intenta más tarde.
        </div>
      </div>
    <?php elseif (empty($demons)): ?>
      <div class="text-center text-amber-400 font-mono text-lg py-12">
        // NO HAY DEMONIOS DISPONIBLES
      </div>
    <?php else: ?>
      <!-- Container de las cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <?php foreach ($demons as $demon): ?>
          <?php 
          $categories = $demon->categories();
          
          // Obtener imagen del demonio
          $imagePath = '/assets/img/demons/default.png'; // Fallback
          
          if ($demon->image_file_id) {
              $imagePath = "/?file_id={$demon->image_file_id}";
          }
          ?>
          
          <?php 
            $aliasesList = '';
            if (!empty($demon->aliases) && is_array($demon->aliases)) {
              $aliasesList = ' ' . implode(' ', $demon->aliases);
            }
            $searchable = strtolower(($demon->name ?? '') . $aliasesList);
          ?>
          <div class="expandable-card-container" data-searchable="<?= htmlspecialchars($searchable) ?>">
            <div class="expandable-card group" data-demon="demon-<?= $demon->id ?>">
              
              <!-- Imagen principal -->
              <div class="card-image relative overflow-hidden rounded-xl border-2 border-amber-600/30 bg-black shadow-2xl shadow-amber-500/20">
                <img 
                  src="<?= htmlspecialchars($imagePath) ?>" 
                  alt="<?= htmlspecialchars($demon->name) ?>" 
                  class="w-full h-full object-cover opacity-80"
                  onerror="this.src='/assets/img/demons/default.png'"
                >
                
                <!-- Info discreta en la esquina -->
                <div class="card-info">
                  <p class="text-amber-300 text-lg font-mono font-bold"><?= htmlspecialchars($demon->name) ?></p>
                </div>
              </div>

              <!-- Menú expandible -->
              <div class="card-menu">
                <!-- Panel izquierdo - Alias -->
                <div class="menu-panel menu-left bg-black/95 border-2 border-amber-600/40 backdrop-blur-sm h-38">
                  <div class="p-4 h-full flex flex-col">
                    <h4 class="text-amber-500 font-mono text-sm mb-3 border-b border-amber-600/30 pb-2 uppercase tracking-wider text-center">
                      <i class="fa-solid fa-mask mr-2"></i>Alias
                    </h4>
                    <div class="flex-1 flex items-center justify-center">
                      <?php if (!empty($demon->aliases) && is_array($demon->aliases) && count($demon->aliases) > 0): ?>
                        <span class="px-3 py-1.5 bg-amber-600/20 border border-amber-600/40 rounded text-amber-500 text-sm font-mono text-center">
                          <?= htmlspecialchars($demon->aliases[0]) ?>
                        </span>
                      <?php else: ?>
                        <span class="text-amber-600/50 text-xs">Sin alias</span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <!-- Panel derecho - Acciones -->
                <div class="menu-panel menu-right bg-black/95 border-2 border-amber-600/40 backdrop-blur-sm h-38">
                  <div class="p-4">
                    <h4 class="text-amber-500 font-mono text-sm mb-3 border-b border-amber-600/30 pb-2 uppercase tracking-wider text-center">
                      <i class="fa-solid fa-info-circle mr-2"></i>Info
                    </h4>
                    <div class="space-y-2">
                      <!-- Botón ver detalles -->
                      <a href="/?sec=demon-detail&demon_id=<?= $demon->id ?>" class="block w-full bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 text-xs font-bold py-2 px-3 rounded font-mono transition-all hover:shadow-lg hover:shadow-amber-500/30 text-center">
                        VER DETALLES
                      </a>
                      
                      <!-- Botón ver pactos -->
                      <a href="/?sec=pacts&demon=<?= $demon->id ?>" class="block w-full bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 text-xs font-bold py-2 px-3 rounded font-mono transition-all text-center">
                        VER PACTOS
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Panel superior - Nombre -->
                <div class="menu-panel menu-top bg-black/95 border-2 border-amber-600/40 backdrop-blur-sm">
                  <div class="p-3 text-center">
                    <p class="text-amber-500 font-bold text-sm font-mono uppercase tracking-wider">
                      <?= htmlspecialchars($demon->name) ?>
                    </p>
                  </div>
                </div>

                <!-- Panel inferior - Descripción -->
                <div class="menu-panel menu-bottom bg-black/95 border-2 border-amber-600/40 backdrop-blur-sm">
                  <div class="p-3">
                    <p class="text-amber-400 text-xs font-mono text-center line-clamp-2">
                      <?= htmlspecialchars($demon->summary ?? $demon->lore ?? 'Entidad del abismo esperando ser descubierta.') ?>
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
