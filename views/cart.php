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

<!-- CARRITO -->
<div class="min-h-screen bg-black text-white py-12 px-4 relative overflow-hidden">
  <!-- Grid cyberpunk background -->
  <div class="fixed inset-0 opacity-20 pointer-events-none">
    <div class="absolute inset-0" style="background-image: linear-gradient(cyan 1px, transparent 1px), linear-gradient(90deg, cyan 1px, transparent 1px); background-size: 50px 50px;"></div>
  </div>
  
  <!-- Glowing orbs -->
  <div class="fixed top-20 left-20 w-96 h-96 bg-cyan-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
  <div class="fixed bottom-20 right-20 w-96 h-96 bg-fuchsia-500 rounded-full blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>

  <div class="max-w-5xl mx-auto relative z-10">
    
    <!-- TÍTULO -->
    <h1 class="text-5xl font-bold text-center mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-fuchsia-500 to-purple-600 font-mono tracking-wider" data-main-title>
      🛒 TU CARRITO
    </h1>
    <p class="text-center text-cyan-300 mb-8 text-sm font-mono">
      // <?= $count ?> pacto<?= $count !== 1 ? 's' : '' ?> en tu carrito
    </p>
    
    <!-- CONTENEDOR DE ITEMS -->
    <div class="bg-black/70 border-2 border-cyan-600/40 rounded-lg p-6 mb-6 backdrop-blur-sm">
      <?php if (empty($pacts)): ?>
        <p class="text-cyan-400 text-center py-8 font-mono">
          // TU CARRITO ESTÁ VACÍO
          <br>
          <a href="/?sec=pacts" class="text-fuchsia-400 hover:text-fuchsia-300 underline text-sm mt-2 inline-block">
            &gt; Explorar_pactos.exe
          </a>
        </p>
      <?php else: ?>
        <div class="space-y-4">
          <?php foreach ($pacts as $pact): ?>
            <?php 
            $demon = $demonsMap[$pact->demon_id] ?? null;
            $demonName = $demon ? $demon->name : 'Desconocido';
            ?>
            <div class="bg-black/50 border border-cyan-500/30 p-4 rounded hover:border-fuchsia-500/50 transition w-full" data-cart-item>
              <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <!-- Info del pacto -->
                <div class="flex-1 min-w-0">
                  <h3 class="text-cyan-300 font-mono font-bold text-lg"><?= htmlspecialchars($pact->name) ?></h3>
                  <p class="text-fuchsia-400 text-xs font-mono">Demonio: <?= htmlspecialchars($demonName) ?></p>
                  <p class="text-gray-400 text-xs mt-1"><?= htmlspecialchars($pact->summary ?? '') ?></p>
                  <?php if ($pact->duration || $pact->cooldown): ?>
                    <div class="flex gap-4 mt-2 text-[10px] text-cyan-500/70 font-mono">
                      <?php if ($pact->duration): ?>
                        <span>⏱ Duración: <?= htmlspecialchars($pact->duration) ?></span>
                      <?php endif; ?>
                      <?php if ($pact->cooldown): ?>
                        <span>🔄 Cooldown: <?= htmlspecialchars($pact->cooldown) ?></span>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <!-- Precio y botón -->
                <div class="flex flex-row md:flex-col items-center md:items-end gap-3 md:gap-2 w-full md:w-auto justify-between md:justify-start">
                  <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-500 font-mono whitespace-nowrap">
                    <?= $pact->price_credits ?> ⛧
                  </span>
                  <form method="POST" action="/?sec=actions&action=remove-from-cart">
                    <input type="hidden" name="pact_id" value="<?= $pact->id ?>">
                    <button type="submit" class="bg-red-900/50 hover:bg-red-800/70 border border-red-500/50 text-red-300 px-4 py-1.5 rounded text-xs font-mono transition whitespace-nowrap">
                      🗑 ELIMINAR
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    
    <!-- TOTAL -->
    <div class="bg-black/70 border-2 border-fuchsia-600/40 rounded-lg p-6 flex justify-between items-center mb-6 backdrop-blur-sm">
      <span class="text-2xl font-bold text-cyan-300 font-mono">TOTAL:</span>
      <span class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-500 font-mono" data-cart-total>
        <?= $total ?> ⛧
      </span>
    </div>
    
    <!-- BOTONES -->
    <div class="flex gap-4">
      <a href="/?sec=pacts" class="bg-black/70 hover:bg-cyan-900/30 border border-cyan-500/50 text-cyan-300 px-6 py-3 rounded font-bold flex-1 text-center font-mono transition">
        ← SEGUIR EXPLORANDO
      </a>
      
      <?php if (!empty($pacts)): ?>
        <form method="POST" action="/?sec=actions&action=checkout" class="flex-1">
          <button 
            type="submit"
            class="w-full bg-gradient-to-r from-cyan-500 to-fuchsia-600 hover:from-cyan-400 hover:to-fuchsia-500 text-black px-6 py-3 rounded font-bold font-mono shadow-[0_0_20px_rgba(0,255,255,0.5)] transition">
            💳 COMPLETAR COMPRA
          </button>
        </form>
        
        <form method="POST" action="/?sec=actions&action=clear-cart" class="flex-none">
          <button 
            type="submit" 
            class="bg-red-900/50 hover:bg-red-800/70 border border-red-500/50 text-red-300 px-6 py-3 rounded font-bold font-mono transition">
            🗑 VACIAR
          </button>
        </form>
      <?php endif; ?>
    </div>
    
  </div>
</div>
