<?php
require_once BASE_PATH . '/classes/Demon.php';
require_once BASE_PATH . '/classes/Category.php';
require_once BASE_PATH . '/classes/DbConnection.php';

// Obtener ID del demonio
$demonId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$demonId) {
    header('Location: /?sec=admin&page=demons');
    exit;
}

$dbError = false;
$demon = null;
$demonImage = null;

try {
    // Obtener el demonio (por slug o id)
    if (is_numeric($demonId)) {
        $demon = Demon::find((int)$demonId);
    } else {
        $demon = Demon::findBySlug($demonId);
    }

    if (!$demon) {
        header('Location: /?sec=admin&page=demons');
        exit;
    }

    // Obtener imagen
    if ($demon->image_file_id) {
        $demonImage = "/?file_id={$demon->image_file_id}";
    }
} catch (Exception $e) {
    $dbError = true;
    error_log('Error loading demon detail: ' . $e->getMessage());
}
?>

<div class="min-h-screen bg-black relative overflow-hidden py-8 px-4 font-mono">
  <!-- Ambient background grid & glow -->
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

  <div class="mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-8 relative z-10">
    
    <?php if ($dbError): ?>
      <div class="text-center py-20">
        <div class="text-red-400 font-mono text-xl mb-2">
          // ERROR DE CONEXIÓN
        </div>
        <div class="text-amber-400/60 font-mono mb-6">
          No se pudo cargar el detalle del demonio. Por favor, intenta más tarde.
        </div>
        <a href="/?sec=admin&page=demons" class="inline-block bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider">
          <i class="fa-solid fa-arrow-left mr-2"></i>Volver a Demonios
        </a>
      </div>
    <?php else: ?>
    <!-- Contenedor principal centrado -->
    <div class="mx-auto max-w-7xl overflow-visible">
      
      <!-- Botón volver -->
      <div class="mb-6 mt-2 demon-back">
        <a href="/?sec=admin&page=<?= isset($_GET['return_to']) ? htmlspecialchars($_GET['return_to']) : 'demons' ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-amber-600/40 bg-amber-600/10 hover:bg-amber-600/20 hover:border-amber-600/60 transition-all text-amber-500 hover:text-amber-400 shadow-lg shadow-amber-500/10 hover:shadow-amber-500/20">
          <i class="fa-solid fa-arrow-left text-base"></i>
          <span class="font-bold text-sm uppercase tracking-wider">Volver a Demonios</span>
        </a>
      </div>

      <div class="flex flex-col lg:flex-row gap-8 lg:items-start">
        
        <!-- Columna izquierda: Imagen -->
        <div class="demon-image lg:w-2/5 flex-shrink-0">
          <div class="bg-black/70 border-2 border-amber-600/40 backdrop-blur-sm rounded-xl overflow-hidden shadow-2xl shadow-amber-500/20 h-full">
            <?php if ($demonImage): ?>
              <img 
                src="<?= htmlspecialchars($demonImage) ?>" 
                alt="<?= htmlspecialchars($demon->name) ?>"
                class="w-full h-full object-cover"
                onerror="this.src='/assets/img/demons/default.png'"
              >
            <?php else: ?>
              <div class="flex items-center justify-center bg-black/60 w-full h-full">
                <i class="fa-solid fa-skull text-amber-600/30 text-9xl"></i>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Columna derecha: Información -->
        <div class="demon-info space-y-6 lg:w-3/5 flex-shrink-0 lg:overflow-y-auto lg:h-[766px] lg:pr-4"
             style="scrollbar-width: thin; scrollbar-color: rgba(251, 191, 36, 0.3) transparent;">
        
        <!-- Título y especie -->
        <div class="demon-header">
          <h1 class="text-5xl font-bold text-amber-500 mb-3 tracking-wider"><?= htmlspecialchars($demon->name) ?></h1>
          <?php if ($demon->species): ?>
            <p class="text-amber-600/80 text-lg flex items-center gap-2">
              <i class="fa-solid fa-dna"></i>
              <span>Especie: <strong class="text-amber-500"><?= htmlspecialchars($demon->species) ?></strong></span>
            </p>
          <?php endif; ?>
        </div>

        <!-- Aliases -->
        <?php if (!empty($demon->aliases) && is_array($demon->aliases)): ?>
          <div class="demon-aliases">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-2">
              <i class="fa-solid fa-mask mr-2"></i>Conocido como
            </h3>
            <div class="flex flex-wrap gap-2">
              <?php foreach ($demon->aliases as $alias): ?>
                <span class="px-3 py-1 bg-amber-600/20 border border-amber-600/40 rounded-full text-amber-400 text-xs font-mono">
                  <?= htmlspecialchars($alias) ?>
                </span>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Resumen -->
        <?php if ($demon->summary): ?>
          <div class="demon-summary bg-black/70 border border-amber-600/30 rounded-xl p-6">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-3">
              <i class="fa-solid fa-file-lines mr-2"></i>Resumen
            </h3>
            <p class="text-amber-300/90 text-sm leading-relaxed">
              <?= nl2br(htmlspecialchars($demon->summary)) ?>
            </p>
          </div>
        <?php endif; ?>

        <!-- Información demográfica -->
        <div class="demon-demographics grid grid-cols-1 md:grid-cols-2 gap-4">
          
          <!-- Género -->
          <?php if ($demon->gender): ?>
            <div class="bg-black/70 border border-amber-600/30 rounded-xl p-4">
              <h4 class="text-amber-500 text-xs font-bold uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fa-solid fa-venus-mars"></i>Género
              </h4>
              <p class="text-amber-300 text-sm font-mono"><?= htmlspecialchars($demon->gender) ?></p>
            </div>
          <?php endif; ?>

          <!-- Edad -->
          <?php if ($demon->age_real): ?>
            <div class="bg-black/70 border border-amber-600/30 rounded-xl p-4">
              <h4 class="text-amber-500 text-xs font-bold uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fa-solid fa-calendar"></i>Edad
              </h4>
              <p class="text-amber-300 text-sm font-mono"><?= htmlspecialchars($demon->age_real) ?></p>
            </div>
          <?php endif; ?>

        </div>

        <!-- Lore -->
        <?php if ($demon->lore): ?>
          <div class="demon-lore bg-black/70 border border-amber-600/30 rounded-xl p-6">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-3">
              <i class="fa-solid fa-book-skull mr-2"></i>Historia
            </h3>
            <p class="text-amber-300/90 text-sm leading-relaxed">
              <?= nl2br(htmlspecialchars($demon->lore)) ?>
            </p>
          </div>
        <?php endif; ?>

        <!-- Habilidades -->
        <?php if ($demon->abilities_summary): ?>
          <div class="demon-abilities bg-black/70 border border-amber-600/30 rounded-xl p-6">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-3">
              <i class="fa-solid fa-wand-sparkles mr-2"></i>Habilidades
            </h3>
            <p class="text-amber-300/90 text-sm leading-relaxed">
              <?= nl2br(htmlspecialchars($demon->abilities_summary)) ?>
            </p>
          </div>
        <?php endif; ?>

        <!-- Estadísticas -->
        <?php 
        $hasStats = $demon->stat_strength || $demon->stat_dexterity || $demon->stat_intelligence || 
                    $demon->stat_health || $demon->stat_reflexes || $demon->stat_stealth;
        if ($hasStats): 
        ?>
          <div class="demon-stats bg-black/70 border border-amber-600/30 rounded-xl p-6">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-4">
              <i class="fa-solid fa-chart-bar mr-2"></i>Estadísticas
            </h3>
            <div class="space-y-3">
              <?php if ($demon->stat_strength): ?>
                <div>
                  <div class="flex justify-between text-xs mb-1">
                    <span class="text-amber-400">Fuerza</span>
                    <span class="text-amber-300"><?= $demon->stat_strength ?>/10</span>
                  </div>
                  <div class="h-2 bg-black/40 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-600 to-amber-500" style="width: <?= $demon->stat_strength * 10 ?>%"></div>
                  </div>
                </div>
              <?php endif; ?>

              <?php if ($demon->stat_dexterity): ?>
                <div>
                  <div class="flex justify-between text-xs mb-1">
                    <span class="text-amber-400">Destreza</span>
                    <span class="text-amber-300"><?= $demon->stat_dexterity ?>/10</span>
                  </div>
                  <div class="h-2 bg-black/40 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-600 to-amber-500" style="width: <?= $demon->stat_dexterity * 10 ?>%"></div>
                  </div>
                </div>
              <?php endif; ?>

              <?php if ($demon->stat_intelligence): ?>
                <div>
                  <div class="flex justify-between text-xs mb-1">
                    <span class="text-amber-400">Inteligencia</span>
                    <span class="text-amber-300"><?= $demon->stat_intelligence ?>/10</span>
                  </div>
                  <div class="h-2 bg-black/40 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-600 to-amber-500" style="width: <?= $demon->stat_intelligence * 10 ?>%"></div>
                  </div>
                </div>
              <?php endif; ?>

              <?php if ($demon->stat_health): ?>
                <div>
                  <div class="flex justify-between text-xs mb-1">
                    <span class="text-amber-400">Salud</span>
                    <span class="text-amber-300"><?= $demon->stat_health ?>/10</span>
                  </div>
                  <div class="h-2 bg-black/40 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-600 to-amber-500" style="width: <?= $demon->stat_health * 10 ?>%"></div>
                  </div>
                </div>
              <?php endif; ?>

              <?php if ($demon->stat_reflexes): ?>
                <div>
                  <div class="flex justify-between text-xs mb-1">
                    <span class="text-amber-400">Reflejos</span>
                    <span class="text-amber-300"><?= $demon->stat_reflexes ?>/10</span>
                  </div>
                  <div class="h-2 bg-black/40 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-600 to-amber-500" style="width: <?= $demon->stat_reflexes * 10 ?>%"></div>
                  </div>
                </div>
              <?php endif; ?>

              <?php if ($demon->stat_stealth): ?>
                <div>
                  <div class="flex justify-between text-xs mb-1">
                    <span class="text-amber-400">Sigilo</span>
                    <span class="text-amber-300"><?= $demon->stat_stealth ?>/10</span>
                  </div>
                  <div class="h-2 bg-black/40 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-600 to-amber-500" style="width: <?= $demon->stat_stealth * 10 ?>%"></div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Personalidad -->
        <?php if (!empty($demon->personality)): ?>
          <div class="demon-personality bg-black/70 border border-amber-600/30 rounded-xl p-6">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-3">
              <i class="fa-solid fa-brain mr-2"></i>Personalidad
            </h3>
            
            <?php if (is_array($demon->personality)): ?>
              <?php 
              // Verificar si es un array asociativo con estructura compleja
              $isComplex = isset($demon->personality['core']) || isset($demon->personality['quirks']);
              ?>
              
              <?php if (!$isComplex): ?>
                <!-- Si es array simple (legado) -->
                <ul class="space-y-2">
                  <?php foreach ($demon->personality as $trait): ?>
                    <?php if (is_string($trait)): ?>
                      <li class="text-amber-300/90 text-sm flex items-start gap-2">
                        <i class="fa-solid fa-circle text-amber-600/50 text-[6px] mt-1.5"></i>
                        <span><?= htmlspecialchars($trait) ?></span>
                      </li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <!-- Si es objeto con estructura compleja -->
                <div class="space-y-3">
                  <?php if (isset($demon->personality['core']) && is_string($demon->personality['core'])): ?>
                    <p class="text-amber-300/90 text-sm leading-relaxed">
                      <?= htmlspecialchars($demon->personality['core']) ?>
                    </p>
                  <?php endif; ?>
                  
                  <?php if (isset($demon->personality['quirks']) && is_array($demon->personality['quirks'])): ?>
                    <div class="mt-3">
                      <h4 class="text-amber-400 text-xs font-bold mb-2">Peculiaridades:</h4>
                      <ul class="space-y-1">
                        <?php foreach ($demon->personality['quirks'] as $quirk): ?>
                          <?php if (is_string($quirk)): ?>
                            <li class="text-amber-300/80 text-xs flex items-start gap-2">
                              <i class="fa-solid fa-circle text-amber-600/50 text-[5px] mt-1"></i>
                              <span><?= htmlspecialchars($quirk) ?></span>
                            </li>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- Debilidades -->
        <?php if (!empty($demon->weaknesses_limits) && is_array($demon->weaknesses_limits)): ?>
          <div class="demon-weaknesses bg-black/70 border border-amber-600/30 rounded-xl p-6">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-3">
              <i class="fa-solid fa-shield-halved mr-2"></i>Debilidades y Límites
            </h3>
            <ul class="space-y-2">
              <?php foreach ($demon->weaknesses_limits as $weakness): ?>
                <li class="text-amber-300/90 text-sm flex items-start gap-2">
                  <i class="fa-solid fa-circle text-amber-600/50 text-[6px] mt-1.5"></i>
                  <span><?= htmlspecialchars($weakness) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <!-- Botones de acción ADMIN -->
        <div class="demon-actions flex flex-col sm:flex-row gap-3">
          <a href="/?sec=admin&page=edit-demon&id=<?= urlencode($demon->slug) ?>&return_to=demon-detail" class="flex-1 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 text-sm font-bold py-3 px-6 rounded-lg transition-all text-center flex items-center justify-center gap-2">
            <i class="fa-solid fa-edit"></i>
            EDITAR DEMONIO
          </a>
          
          <a href="/?sec=admin&action=delete-demon&id=<?= urlencode($demon->slug) ?>" onclick="return confirm('¿Estás seguro de eliminar este demonio?')" class="bg-red-900/30 hover:bg-red-900/50 border border-red-600/40 text-red-500 text-sm font-bold py-3 px-6 rounded-lg transition-all text-center flex items-center justify-center gap-2">
            <i class="fa-solid fa-trash"></i>
            ELIMINAR
          </a>

          <a href="/?sec=demon-detail&demon_id=<?= $demon->id ?>" target="_blank" class="bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 text-sm font-bold py-3 px-6 rounded-lg transition-all text-center flex items-center justify-center gap-2">
            <i class="fa-solid fa-external-link-alt"></i>
            VER PÚBLICO
          </a>
        </div>

      </div>
      <!-- Fin columna derecha demon-info -->

      </div>
      <!-- Fin contenedor flex -->
    </div>
    <!-- Fin contenedor centrado -->
    <?php endif; ?>

  </div>
</div>

<script type="module" src="http://localhost:5173/public/assets/admin/js/demon-detail.js"></script>
