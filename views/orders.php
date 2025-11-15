<?php
require_once BASE_PATH . '/classes/Order.php';
require_once BASE_PATH . '/includes/auth.php';

requireLogin();

$userId = $_SESSION['user_id'];
$orders = Order::byUser($userId);

// Cargar items de cada orden
foreach ($orders as $order) {
    $order->items = $order->getItems();
}
?>

<div class="min-h-screen bg-black text-white py-12 px-4 relative overflow-hidden">
  <!-- Grid cyberpunk background -->
  <div class="fixed inset-0 opacity-20 pointer-events-none">
    <div class="absolute inset-0" style="background-image: linear-gradient(cyan 1px, transparent 1px), linear-gradient(90deg, cyan 1px, transparent 1px); background-size: 50px 50px;"></div>
  </div>
  
  <!-- Glowing orbs -->
  <div class="fixed top-20 left-20 w-96 h-96 bg-cyan-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
  <div class="fixed bottom-20 right-20 w-96 h-96 bg-fuchsia-500 rounded-full blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>

  <div class="max-w-6xl mx-auto relative z-10">
    
    <!-- TÍTULO -->
    <h1 class="text-5xl font-bold text-center mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-fuchsia-500 to-purple-600 font-mono tracking-wider">
      📜 MIS COMPRAS
    </h1>
    <p class="text-center text-cyan-300 mb-8 text-sm font-mono">
      // <?= count($orders) ?> orden<?= count($orders) !== 1 ? 'es' : '' ?> realizada<?= count($orders) !== 1 ? 's' : '' ?>
    </p>

    <!-- Botón volver al perfil -->
    <div class="mb-6 text-center">
      <a href="/?sec=profile" class="inline-block bg-black/70 hover:bg-cyan-900/30 border border-cyan-500/50 text-cyan-300 px-4 py-2 rounded font-mono text-sm transition">
        ← Volver a Mi Cuenta
      </a>
    </div>
    
    <!-- LISTADO DE ÓRDENES -->
    <div class="space-y-6">
      <?php if (empty($orders)): ?>
        <div class="bg-black/70 border-2 border-cyan-600/40 rounded-lg p-12 text-center backdrop-blur-sm">
          <p class="text-cyan-400 font-mono text-lg mb-4">
            // NO HAY COMPRAS REGISTRADAS
          </p>
          <a href="/?sec=pacts" class="text-fuchsia-400 hover:text-fuchsia-300 underline text-sm font-mono">
            &gt; Explorar_pactos.exe
          </a>
        </div>
      <?php else: ?>
        <?php foreach ($orders as $order): ?>
          <?php
          // Determinar color según estado
          $statusColors = [
              'placed' => 'text-yellow-400 border-yellow-600/40',
              'paid' => 'text-blue-400 border-blue-600/40',
              'fulfilled' => 'text-green-400 border-green-600/40',
              'refunded' => 'text-purple-400 border-purple-600/40',
              'cancelled' => 'text-red-400 border-red-600/40'
          ];
          $statusColor = $statusColors[$order->status] ?? 'text-gray-400 border-gray-600/40';
          
          $statusLabels = [
              'placed' => 'PENDIENTE',
              'paid' => 'PAGADA',
              'fulfilled' => 'COMPLETADA',
              'refunded' => 'REEMBOLSADA',
              'cancelled' => 'CANCELADA'
          ];
          $statusLabel = $statusLabels[$order->status] ?? strtoupper($order->status);
          ?>
          
          <div class="bg-black/70 border-2 border-cyan-600/40 rounded-lg overflow-hidden backdrop-blur-sm">
            <!-- Header de la orden -->
            <div class="bg-cyan-900/20 border-b border-cyan-600/30 p-4 flex justify-between items-center">
              <div>
                <h3 class="text-cyan-300 font-mono font-bold text-lg">
                  ORDEN #<?= str_pad((string)$order->id, 6, '0', STR_PAD_LEFT) ?>
                </h3>
                <p class="text-cyan-500/70 text-xs font-mono mt-1">
                  📅 <?= date('d/m/Y H:i', strtotime($order->placed_at)) ?>
                </p>
              </div>
              <div class="text-right">
                <span class="inline-block px-3 py-1 rounded border <?= $statusColor ?> font-mono text-sm font-bold">
                  <?= $statusLabel ?>
                </span>
                <p class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-500 font-mono mt-2">
                  <?= $order->total_credits ?> ⛧
                </p>
              </div>
            </div>

            <!-- Items de la orden -->
            <div class="p-4">
              <h4 class="text-fuchsia-400 font-mono text-sm mb-3 border-b border-fuchsia-600/30 pb-2">
                // PACTOS_ADQUIRIDOS
              </h4>
              <div class="space-y-2">
                <?php foreach ($order->items as $item): ?>
                  <?php 
                  $snapshot = json_decode($item['snapshot'], true);
                  $pactName = $item['pact_name'] ?? $snapshot['name'] ?? 'Pacto Desconocido';
                  ?>
                  <div class="bg-black/50 border border-cyan-500/20 p-3 rounded flex justify-between items-center">
                    <div class="flex-1">
                      <p class="text-cyan-300 font-mono font-semibold"><?= htmlspecialchars($pactName) ?></p>
                      <?php if (isset($snapshot['summary'])): ?>
                        <p class="text-gray-400 text-xs mt-1"><?= htmlspecialchars($snapshot['summary']) ?></p>
                      <?php endif; ?>
                    </div>
                    <div class="text-fuchsia-400 font-mono font-bold ml-4">
                      <?= $item['unit_price_credits'] ?> ⛧
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

              <!-- Notas o acciones -->
              <div class="mt-4 pt-4 border-t border-cyan-600/30 flex justify-between items-center">
                <?php if ($order->notes): ?>
                  <p class="text-yellow-400 text-xs font-mono">
                    ⚠ Nota: <?= htmlspecialchars($order->notes) ?>
                  </p>
                <?php else: ?>
                  <div></div>
                <?php endif; ?>
                
                <?php if ($order->status === 'paid'): ?>
                  <form method="POST" action="/?sec=actions&action=cancel-order" class="inline">
                    <input type="hidden" name="order_id" value="<?= $order->id ?>">
                    <button 
                      type="submit" 
                      onclick="return confirm('¿Seguro que querés cancelar esta orden?')"
                      class="bg-red-900/50 hover:bg-red-800/70 border border-red-500/50 text-red-300 px-4 py-2 rounded text-xs font-mono transition">
                      ❌ CANCELAR ORDEN
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    
  </div>
</div>
