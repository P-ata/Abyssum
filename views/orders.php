<?php
require_once BASE_PATH . '/classes/Order.php';
require_once BASE_PATH . '/classes/DbConnection.php';
require_once BASE_PATH . '/includes/auth.php';

requireLogin();

$userId = $_SESSION['user_id'];
$dbError = false;
$orders = [];

try {
    $orders = Order::byUser($userId);

    // Cargar items de cada orden
    foreach ($orders as $order) {
        $order->items = $order->getItems();
    }
} catch (Exception $e) {
    $dbError = true;
    error_log('Error loading orders: ' . $e->getMessage());
}
?>

<div class="min-h-screen bg-black relative overflow-hidden py-20 px-4 font-mono">
  
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

  <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 relative z-10">
    
    <!-- Título -->
    <div class="text-center mb-6 orders-title">
      <h1 class="text-6xl font-bold tracking-widest text-amber-500">MIS COMPRAS</h1>
    </div>

    <!-- Subtítulo -->
    <div class="text-center mb-12 orders-subtitle">
      <p class="text-amber-600/70 text-sm uppercase tracking-widest">
        // <?= count($orders) ?> orden<?= count($orders) !== 1 ? 'es' : '' ?> realizada<?= count($orders) !== 1 ? 's' : '' ?>
      </p>
    </div>

    <div class="max-w-6xl mx-auto">

      <!-- Botón volver al perfil -->
      <div class="mb-8 text-center back-button">
        <a href="/?sec=profile" class="inline-block bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider">
          <i class="fa-solid fa-arrow-left mr-2"></i>Volver a Mi Cuenta
        </a>
      </div>
      
      <!-- LISTADO DE ÓRDENES -->
      <div class="space-y-6">
        <?php if ($dbError): ?>
          <div class="text-center py-12">
            <div class="text-red-400 font-mono text-xl mb-2">
              // ERROR DE CONEXIÓN
            </div>
            <div class="text-amber-400/60 font-mono mb-6">
              No se pudieron cargar tus compras. Por favor, intenta más tarde.
            </div>
            <a href="/?sec=profile" class="inline-block bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider">
              <i class="fa-solid fa-arrow-left mr-2"></i>Volver a Mi Cuenta
            </a>
          </div>
        <?php elseif (empty($orders)): ?>
          <div class="empty-state bg-black/70 border border-amber-600/30 rounded-xl p-12 text-center backdrop-blur-sm">
            <div class="text-6xl mb-4 text-amber-500/50">
              <i class="fa-solid fa-inbox"></i>
            </div>
            <p class="text-amber-500 font-bold text-lg mb-2 uppercase tracking-wider">
              No hay compras registradas
            </p>
            <p class="text-amber-600/70 text-sm mb-6">
              Todavía no has realizado ninguna orden
            </p>
            <a href="/?sec=pacts" class="inline-block bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all hover:shadow-lg hover:shadow-amber-500/30 uppercase tracking-wider">
              <i class="fa-solid fa-file-contract mr-2"></i>Explorar Pactos
            </a>
          </div>
        <?php else: ?>
          <?php foreach ($orders as $order): ?>
            <?php
            // Determinar color según estado
            $statusColors = [
                'placed' => 'bg-yellow-600/20 text-yellow-400 border-yellow-600/40',
                'paid' => 'bg-blue-600/20 text-blue-400 border-blue-600/40',
                'fulfilled' => 'bg-green-600/20 text-green-400 border-green-600/40',
                'refunded' => 'bg-purple-600/20 text-purple-400 border-purple-600/40',
                'cancelled' => 'bg-red-600/20 text-red-400 border-red-600/40'
            ];
            $statusColor = $statusColors[$order->status] ?? 'bg-gray-600/20 text-gray-400 border-gray-600/40';
            
            $statusLabels = [
                'placed' => 'PENDIENTE',
                'paid' => 'PAGADA',
                'fulfilled' => 'COMPLETADA',
                'refunded' => 'REEMBOLSADA',
                'cancelled' => 'CANCELADA'
            ];
            $statusLabel = $statusLabels[$order->status] ?? strtoupper($order->status);
            ?>
            
            <div class="order-card bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden backdrop-blur-sm">
              <!-- Header de la orden -->
              <div class="bg-amber-600/10 border-b border-amber-600/30 p-6 flex flex-col md:flex-row justify-between md:items-center gap-4">
                <div>
                  <h3 class="text-amber-500 font-bold text-2xl mb-2 uppercase tracking-wider">
                    <i class="fa-solid fa-hashtag text-lg"></i><?= str_pad((string)$order->id, 6, '0', STR_PAD_LEFT) ?>
                  </h3>
                  <?php
                  // Convertir la fecha UTC a hora de Argentina
                  $dateUTC = new DateTime($order->placed_at, new DateTimeZone('UTC'));
                  $dateUTC->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
                  ?>
                  <p class="text-amber-600/70 text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-calendar mr-1"></i>
                    <span class="font-semibold">Realizada:</span> <?= $dateUTC->format('d/m/Y H:i') ?>
                  </p>
                </div>
                <div class="text-left md:text-right">
                  <span class="inline-block px-4 py-2 rounded border <?= $statusColor ?> text-sm font-bold uppercase tracking-wider mb-2">
                    <?= $statusLabel ?>
                  </span>
                  <p class="text-3xl font-bold text-amber-500">
                    <?= $order->total_credits ?> <i class="fa-solid fa-coins text-2xl"></i>
                  </p>
                </div>
              </div>

              <!-- Items de la orden -->
              <div class="p-6">
                <h4 class="text-amber-500 text-sm mb-4 uppercase tracking-wider border-b border-amber-600/30 pb-2 font-bold">
                  <i class="fa-solid fa-file-contract mr-2"></i>Pactos Adquiridos
                </h4>
                <div class="grid grid-cols-1 gap-4">
                  <?php foreach ($order->items as $item): ?>
                    <?php 
                    $snapshot = json_decode($item['snapshot'], true);
                    $pactName = $item['pact_name'] ?? $snapshot['name'] ?? 'Pacto Desconocido';
                    $demonName = $snapshot['demon_name'] ?? null;
                    $imageFileId = $snapshot['image_file_id'] ?? null;
                    
                    // si no esta el id de la imagen en el snapshot lo agarramos aca
                    if (!$imageFileId && isset($item['pact_id'])) {
                        $pdo = DbConnection::get();
                        $stmtPact = $pdo->prepare('SELECT image_file_id, demon_id FROM pacts WHERE id = ?');
                        $stmtPact->execute([$item['pact_id']]);
                        $pactData = $stmtPact->fetch(PDO::FETCH_ASSOC);
                        if ($pactData) {
                            $imageFileId = $pactData['image_file_id'];
                            // agarramos el nombre del demonio si no esta tambien
                            if (!$demonName && $pactData['demon_id']) {
                                $stmtDemon = $pdo->prepare('SELECT name FROM demons WHERE id = ?');
                                $stmtDemon->execute([$pactData['demon_id']]);
                                $demonName = $stmtDemon->fetchColumn();
                            }
                        }
                    }
                    
                    // obtenemos la imagen de la base de datos
                    $pactImage = null;
                    if ($imageFileId) {
                        $pdo = DbConnection::get();
                        $stmt = $pdo->prepare('SELECT filename FROM files WHERE id = ?');
                        $stmt->execute([$imageFileId]);
                        $file = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($file) {
                            $pactImage = '/assets/img/' . $file['filename'];
                        }
                    }
                    ?>
                    <div class="order-item bg-black/50 border border-amber-600/20 rounded-lg overflow-hidden flex flex-col sm:flex-row">
                      <!-- Imagen del pacto -->
                      <?php if ($pactImage): ?>
                        <div class="w-full sm:w-32 h-32 flex-shrink-0">
                          <img 
                            src="<?= htmlspecialchars($pactImage) ?>" 
                            alt="<?= htmlspecialchars($pactName) ?>"
                            class="w-full h-full object-cover"
                            onerror="this.src='/assets/img/pacts/16861331.png'"
                          >
                        </div>
                      <?php else: ?>
                        <div class="w-full sm:w-32 h-32 flex-shrink-0 bg-amber-900/20 flex items-center justify-center">
                          <i class="fa-solid fa-image text-amber-600/30 text-3xl"></i>
                        </div>
                      <?php endif; ?>
                      
                      <!-- información del pacto -->
                      <div class="flex-1 p-4 flex flex-col justify-between">
                        <div>
                          <p class="text-amber-300 font-bold text-lg mb-1"><?= htmlspecialchars($pactName) ?></p>
                          <?php if ($demonName): ?>
                            <p class="text-amber-500/70 text-xs uppercase tracking-wider mb-2">
                              <i class="fa-solid fa-skull mr-1"></i><?= htmlspecialchars($demonName) ?>
                            </p>
                          <?php endif; ?>
                          <?php if (isset($snapshot['summary'])): ?>
                            <p class="text-amber-600/60 text-sm line-clamp-2"><?= htmlspecialchars($snapshot['summary']) ?></p>
                          <?php endif; ?>
                        </div>
                        <div class="text-amber-500 font-bold text-xl mt-2">
                          <?= $item['unit_price_credits'] ?> <i class="fa-solid fa-coins"></i>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

                <!-- notas o acciones -->
                <div class="mt-6 pt-4 border-t border-amber-600/30 flex flex-col md:flex-row justify-between md:items-center gap-4">
                  <?php if ($order->notes): ?>
                    <p class="text-yellow-400 text-sm bg-yellow-600/10 border border-yellow-600/30 rounded px-4 py-2">
                      <i class="fa-solid fa-circle-exclamation mr-2"></i><?= htmlspecialchars($order->notes) ?>
                    </p>
                  <?php else: ?>
                    <div></div>
                  <?php endif; ?>
                  
                  <?php if ($order->status === 'paid'): ?>
                    <form method="POST" action="/?sec=actions&action=cancel-order" class="inline" id="cancelForm<?= $order->id ?>">
                      <input type="hidden" name="order_id" value="<?= $order->id ?>">
                      <button 
                        type="button" 
                        onclick="openCancelModal(<?= $order->id ?>)"
                        class="bg-red-600/20 hover:bg-red-600/30 border border-red-600/40 text-red-400 hover:text-red-300 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider">
                        <i class="fa-solid fa-xmark mr-2"></i>Cancelar Orden
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
</div>

<!-- modal de confirmación de cancelación -->
<div id="cancelModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center font-mono">
  <div class="bg-black border-2 border-red-600/40 rounded-xl max-w-md w-full mx-4 overflow-hidden shadow-2xl shadow-red-500/20">
    <!-- header -->
    <div class="bg-red-600/20 border-b border-red-600/40 p-6">
      <h3 class="text-2xl font-bold text-red-400 uppercase tracking-wider flex items-center gap-3">
        <i class="fa-solid fa-triangle-exclamation text-3xl"></i>
        Confirmar Cancelación
      </h3>
    </div>
    
    <!-- body -->
    <div class="p-6 space-y-4">
      <p class="text-amber-300 text-base">
        ¿Estás seguro que querés cancelar esta orden?
      </p>
      <p class="text-amber-600/70 text-sm">
        Esta acción no se puede deshacer y se liberarán los créditos a tu cuenta.
      </p>
    </div>
    
    <!-- footer -->
    <div class="bg-amber-600/10 border-t border-amber-600/30 p-6 flex gap-4 justify-end">
      <button 
        type="button" 
        onclick="closeCancelModal()"
        class="bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider">
        <i class="fa-solid fa-arrow-left mr-2"></i>No, Volver
      </button>
      <button 
        type="button" 
        onclick="confirmCancel()"
        class="bg-red-600/20 hover:bg-red-600/30 border border-red-600/40 text-red-400 hover:text-red-300 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider">
        <i class="fa-solid fa-xmark mr-2"></i>Sí, Cancelar
      </button>
    </div>
  </div>
</div>

<script>
let currentOrderId = null;

function openCancelModal(orderId) {
  currentOrderId = orderId;
  const modal = document.getElementById('cancelModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeCancelModal() {
  const modal = document.getElementById('cancelModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
  currentOrderId = null;
}

function confirmCancel() {
  if (currentOrderId) {
    document.getElementById('cancelForm' + currentOrderId).submit();
  }
}
// cerrar modal al hacer click fuera del contenido=
document.getElementById('cancelModal')?.addEventListener('click', function(e) {
  if (e.target === this) {
    closeCancelModal();
  }
});

// cerrar modal con ESC
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeCancelModal();
  }
});
</script>
