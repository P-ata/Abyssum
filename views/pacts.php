<?php
require_once BASE_PATH . '/classes/Pact.php';
require_once BASE_PATH . '/classes/Demon.php';
require_once BASE_PATH . '/classes/Cart.php';
require_once BASE_PATH . '/classes/Order.php';

$pacts = Pact::all();

// Pre-cargar todos los demonios de una vez (evita N+1 queries)
$demonIds = array_unique(array_filter(array_column($pacts, 'demon_id')));
$demonsMap = [];
if (!empty($demonIds)) {
    // Convertir a array de enteros
    $demonIds = array_values(array_map('intval', $demonIds));
    $demons = Demon::findMultiple($demonIds);
    foreach ($demons as $demon) {
        $demonsMap[$demon->id] = $demon;
    }
}

// Obtener pactos ya comprados por el usuario
$purchasedPactIds = [];
if (isset($_SESSION['user_id'])) {
    $purchasedPactIds = Order::getPurchasedPactIds((int)$_SESSION['user_id']);
}
?>

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

    <?php if (empty($pacts)): ?>
      <div class="text-center text-cyan-300 font-mono text-lg py-12">
        // NO_PACTS_FOUND
      </div>
    <?php else: ?>
      <!-- Container de las cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
        
        <?php foreach ($pacts as $pact): ?>
          <?php 
          $demon = $demonsMap[$pact->demon_id] ?? null;
          $demonName = $demon ? $demon->name : 'Desconocido';
          $categories = $pact->categories();
          $inCart = Cart::has($pact->id);
          
          // Determinar imagen del pacto
          // Las imágenes están en: /assets/img/pacts/DemonName/demonslug_numero_pactslug.png
          // Ejemplo: /assets/img/pacts/Apex/apex_01_overclock_corona.png
          $imagePath = '/assets/img/pacts/16861331.png'; // Fallback
          
          if ($pact->image_file_id) {
              // Si tiene file_id, usar el sistema de archivos
              $imagePath = "/?file_id={$pact->image_file_id}";
          } elseif ($demon && $pact->slug) {
              // Intentar construir ruta basada en patrón
              $demonFolder = ucfirst($demon->slug);
              $pactSlugClean = str_replace('-', '_', $pact->slug);
              
              // Buscar archivo que coincida
              $globPath = BASE_PATH . "/public/assets/img/pacts/{$demonFolder}/*{$pactSlugClean}*.png";
              $files = glob($globPath);
              
              if (!empty($files)) {
                  $filename = basename($files[0]);
                  $imagePath = "/assets/img/pacts/{$demonFolder}/{$filename}";
              }
          }
          ?>
          
          <div class="expandable-card-container">
            <div class="expandable-card" data-pact="pact-<?= $pact->id ?>">
              
              <!-- Imagen principal -->
              <div class="card-image">
                <img 
                  src="<?= htmlspecialchars($imagePath) ?>" 
                  alt="<?= htmlspecialchars($pact->name) ?>" 
                  class="w-full h-full object-cover opacity-80"
                  onerror="this.src='/assets/img/pacts/16861331.png'"
                >
                
                <!-- Info discreta en la esquina -->
                <div class="card-info">
                  <p class="text-cyan-400 text-xs font-mono opacity-60"><?= htmlspecialchars($demonName) ?></p>
                  <p class="text-fuchsia-400 text-sm font-mono font-semibold"><?= htmlspecialchars($pact->name) ?></p>
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
                        <span class="text-fuchsia-400">⏱ Duración:</span>
                        <span><?= htmlspecialchars($pact->duration ?? 'N/A') ?></span>
                      </li>
                      <li class="flex justify-between">
                        <span class="text-fuchsia-400">🔄 Cooldown:</span>
                        <span><?= htmlspecialchars($pact->cooldown ?? 'N/A') ?></span>
                      </li>
                      <?php if (!empty($categories)): ?>
                        <li class="flex justify-between">
                          <span class="text-fuchsia-400">🏷 Tags:</span>
                          <span><?= count($categories) ?></span>
                        </li>
                      <?php endif; ?>
                    </ul>
                  </div>
                </div>

                <!-- Panel derecho -->
                <div class="menu-panel menu-right">
                  <div class="p-4">
                    <h4 class="text-cyan-300 font-mono text-sm mb-3 border-b border-cyan-500/30 pb-2">// ACTIONS_</h4>
                    <div class="space-y-2">
                      <?php 
                      $isPurchased = in_array($pact->id, $purchasedPactIds);
                      $inCart = Cart::has($pact->id);
                      ?>
                      
                      <?php if ($isPurchased): ?>
                        <div class="w-full bg-amber-900/50 text-amber-400 text-xs font-bold py-2 px-3 rounded font-mono border border-amber-500/50 text-center">
                          ⛧ PACTO ADQUIRIDO
                        </div>
                      <?php elseif ($inCart): ?>
                        <div class="w-full bg-green-900/50 text-green-400 text-xs font-bold py-2 px-3 rounded font-mono border border-green-500/50 text-center">
                          ✓ EN CARRITO
                        </div>
                      <?php else: ?>
                        <form method="POST" action="/?sec=actions&action=add-to-cart">
                          <input type="hidden" name="pact_id" value="<?= $pact->id ?>">
                          <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-fuchsia-600 hover:from-cyan-400 hover:to-fuchsia-500 text-black text-xs font-bold py-2 px-3 rounded font-mono shadow-[0_0_15px_rgba(0,255,255,0.5)]">
                            [AGREGAR AL CARRITO]
                          </button>
                        </form>
                      <?php endif; ?>
                      
                      <?php if (!empty($categories)): ?>
                        <div class="text-[10px] text-cyan-300 font-mono">
                          <?php foreach (array_slice($categories, 0, 3) as $cat): ?>
                            <span class="inline-block bg-cyan-900/30 border border-cyan-500/30 px-2 py-1 rounded mr-1 mb-1">
                              <?= htmlspecialchars($cat->display_name) ?>
                            </span>
                          <?php endforeach; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <!-- Panel superior -->
                <div class="menu-panel menu-top">
                  <div class="p-3 text-center">
                    <p class="text-cyan-300 text-xs font-mono">
                      &gt; <?= htmlspecialchars($pact->summary ?? 'Pacto demoníaco') ?> // <?= htmlspecialchars($demonName) ?>.sys
                    </p>
                  </div>
                </div>

                <!-- Panel inferior -->
                <div class="menu-panel menu-bottom">
                  <div class="p-3 flex justify-between items-center">
                    <span class="text-fuchsia-400 text-xs font-mono">PRECIO:</span>
                    <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-500 font-mono"><?= $pact->price_credits ?> ⛧</span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>

    <!-- Instrucciones -->
    <div class="mt-12 text-center relative z-10">
      <p class="text-cyan-400 text-sm font-mono">
        [ HOVER_CARD_TO_REVEAL ] // &gt;_
      </p>
    </div>
  </div>
</div>