<?php
require_once BASE_PATH . '/classes/Cart.php';
require_once BASE_PATH . '/classes/Pact.php';
require_once BASE_PATH . '/classes/Demon.php';

$pacts = Cart::getPacts();
$total = Cart::getTotal();
$count = Cart::count();

// Pre-load all demons at once to avoid N+1 queries
$demonIds = array_unique(array_column($pacts, 'demon_id'));
$demonsMap = [];
if (!empty($demonIds)) {
    $demons = Demon::findMultiple($demonIds);
    foreach ($demons as $demon) {
        $demonsMap[$demon->id] = $demon;
    }
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
    <div class="text-center mb-6 cart-title">
      <h1 class="text-6xl font-bold tracking-widest text-amber-500">CARRITO</h1>
    </div>

    <!-- Subtítulo -->
    <div class="text-center mb-12 cart-subtitle">
      <p class="text-amber-600/70 text-sm uppercase tracking-widest">
        // <?= $count ?> pacto<?= $count !== 1 ? 's' : '' ?> en tu carrito
      </p>
    </div>

    <div class="max-w-6xl mx-auto">
      
      <!-- CONTENEDOR DE ITEMS -->
      <?php if (empty($pacts)): ?>
        <div class="empty-state bg-black/70 border border-amber-600/30 rounded-xl p-12 text-center backdrop-blur-sm mb-6">
          <div class="text-6xl mb-4 text-amber-500/50">
            <i class="fa-solid fa-cart-shopping"></i>
          </div>
          <p class="text-amber-500 font-bold text-lg mb-2 uppercase tracking-wider">
            Tu carrito está vacío
          </p>
          <p class="text-amber-600/70 text-sm mb-6">
            Todavía no has agregado ningún pacto
          </p>
          <a href="/?sec=pacts" class="inline-block bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all hover:shadow-lg hover:shadow-amber-500/30 uppercase tracking-wider">
            Explorar Pactos
          </a>
        </div>
      <?php else: ?>
        <div class="cart-container bg-black/70 border border-amber-600/30 rounded-xl p-6 mb-6 backdrop-blur-sm">
          <h2 class="text-xl font-bold text-amber-500 mb-4 uppercase tracking-wider border-b border-amber-600/30 pb-3">
            <i class="fa-solid fa-file-contract mr-2"></i>Pactos Seleccionados
          </h2>
          <div class="space-y-4">
            <?php foreach ($pacts as $pact): ?>
              <?php 
              $demon = $demonsMap[$pact->demon_id] ?? null;
              $demonName = $demon ? $demon->name : 'Desconocido';
              
              // Obtener la imagen del pacto desde la base de datos
              $pactImage = null;
              if ($pact->image_file_id) {
                  $pdo = DbConnection::get();
                  $stmt = $pdo->prepare('SELECT filename FROM files WHERE id = ?');
                  $stmt->execute([$pact->image_file_id]);
                  $file = $stmt->fetch(PDO::FETCH_ASSOC);
                  if ($file) {
                      $pactImage = '/assets/img/' . $file['filename'];
                  }
              }
              ?>
              <div class="cart-item bg-black/50 border border-amber-600/20 rounded-lg overflow-hidden hover:border-amber-600/40 transition-all flex flex-col sm:flex-row">
                <!-- Imagen del pacto -->
                <?php if ($pactImage): ?>
                  <div class="w-full sm:w-32 h-32 flex-shrink-0">
                    <img 
                      src="<?= htmlspecialchars($pactImage) ?>" 
                      alt="<?= htmlspecialchars($pact->name) ?>"
                      class="w-full h-full object-cover"
                      onerror="this.src='/assets/img/pacts/16861331.png'"
                    >
                  </div>
                <?php else: ?>
                  <div class="w-full sm:w-32 h-32 flex-shrink-0 bg-amber-900/20 flex items-center justify-center">
                    <i class="fa-solid fa-image text-amber-600/30 text-3xl"></i>
                  </div>
                <?php endif; ?>
                
                <!-- Contenido del item -->
                <div class="flex-1 p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                  <!-- Info del pacto -->
                  <div class="flex-1 min-w-0">
                    <h3 class="text-amber-300 font-bold text-lg mb-1"><?= htmlspecialchars($pact->name) ?></h3>
                    <p class="text-amber-500/70 text-xs uppercase tracking-wider mb-2">
                      <i class="fa-solid fa-skull mr-1"></i><?= htmlspecialchars($demonName) ?>
                    </p>
                    <?php if ($pact->summary): ?>
                      <p class="text-amber-600/60 text-sm mb-2"><?= htmlspecialchars($pact->summary) ?></p>
                    <?php endif; ?>
                    <?php if ($pact->duration || $pact->cooldown): ?>
                      <div class="flex gap-4 text-xs text-amber-500/50 uppercase tracking-wider">
                        <?php if ($pact->duration): ?>
                          <span><i class="fa-solid fa-clock mr-1"></i>Duración: <?= htmlspecialchars($pact->duration) ?></span>
                        <?php endif; ?>
                        <?php if ($pact->cooldown): ?>
                          <span><i class="fa-solid fa-rotate-right mr-1"></i>Cooldown: <?= htmlspecialchars($pact->cooldown) ?></span>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                  <!-- Precio y botón -->
                  <div class="flex flex-row md:flex-col items-center md:items-end gap-3 md:gap-2 w-full md:w-auto justify-between md:justify-start">
                    <span class="text-3xl font-bold text-amber-500 whitespace-nowrap">
                      <?= $pact->price_credits ?> <i class="fa-solid fa-coins text-2xl"></i>
                    </span>
                    <form method="POST" action="/?sec=actions&action=remove-from-cart">
                      <input type="hidden" name="pact_id" value="<?= $pact->id ?>">
                      <button type="submit" class="bg-red-600/20 hover:bg-red-600/30 border border-red-600/40 text-red-400 hover:text-red-300 px-4 py-2 rounded text-xs font-bold transition-all uppercase tracking-wider whitespace-nowrap">
                        <i class="fa-solid fa-trash mr-1"></i>Eliminar
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
      
      <!-- TOTAL Y BOTONES -->
      <?php if (!empty($pacts)): ?>
        <div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 mb-6 backdrop-blur-sm">
          <div class="flex justify-between items-center">
            <span class="text-2xl font-bold text-amber-500 uppercase tracking-wider">Total:</span>
            <span class="text-5xl font-bold text-amber-500 cart-total">
              <?= $total ?> <i class="fa-solid fa-coins text-4xl"></i>
            </span>
          </div>
        </div>
      <?php endif; ?>
      
      <!-- BOTONES DE ACCIÓN -->
      <?php if (!empty($pacts)): ?>
        <div class="flex flex-col sm:flex-row gap-4 cart-actions">
          <a href="/?sec=pacts" class="inline-block bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider text-center">
            <i class="fa-solid fa-arrow-left mr-2"></i>Seguir Explorando
          </a>
          
          <form method="POST" action="/?sec=actions&action=checkout" class="flex-1">
            <button 
              type="submit"
              class="w-full bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all hover:shadow-lg hover:shadow-amber-500/30 uppercase tracking-wider">
              <i class="fa-solid fa-circle-check mr-2"></i>Completar Compra
            </button>
          </form>
          
          <form method="POST" action="/?sec=actions&action=clear-cart">
            <button 
              type="submit" 
              class="bg-red-600/20 hover:bg-red-600/30 border border-red-600/40 text-red-400 hover:text-red-300 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider">
              <i class="fa-solid fa-trash mr-2"></i>Vaciar Carrito
            </button>
          </form>
        </div>
      <?php endif; ?>
      
    </div>
  </div>
</div>
