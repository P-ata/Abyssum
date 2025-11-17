<?php
require_once BASE_PATH . '/classes/Order.php';
require_once BASE_PATH . '/classes/DbConnection.php';
require_once BASE_PATH . '/classes/Pact.php';

$orders = Order::all();
$stats = Order::getStats();

// Cargar items de cada orden
foreach ($orders as $order) {
    $order->items = $order->getItems();
}
?>

<div class="min-h-screen bg-black relative overflow-hidden px-6 py-12 font-mono">
	<!-- Ambient background grid & glow -->
	<div class="pointer-events-none fixed inset-0 opacity-5">
		<div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
	</div>
	<div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
	<div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

	<div class="max-w-7xl mx-auto relative z-10">
		<!-- Header -->
		<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-12">
			<div>
				<h1 id="dashTitle" class="text-6xl font-bold tracking-widest text-amber-500">
					<span class="block">ABYSSUM</span>
					<span class="block text-2xl mt-2 tracking-wide text-amber-600/80">// ÓRDENES</span>
				</h1>
			</div>
			<div class="flex gap-3">
				<a href="/?sec=admin" class="px-5 py-2.5 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/10 text-amber-500 text-sm tracking-wide transition">VOLVER</a>
			</div>
		</div>

		<!-- Estadísticas -->
		<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TOTAL ÓRDENES</div>
				<div class="text-amber-500 text-3xl font-bold"><?= $stats['total'] ?></div>
			</div>
			<div class="bg-black/70 border border-blue-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-blue-600/70 mb-1">PAGADAS</div>
				<div class="text-blue-500 text-3xl font-bold"><?= $stats['paid'] ?></div>
			</div>
			<div class="bg-black/70 border border-green-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-green-600/70 mb-1">COMPLETADAS</div>
				<div class="text-green-500 text-3xl font-bold"><?= $stats['fulfilled'] ?></div>
			</div>
			<div class="bg-black/70 border border-red-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-red-600/70 mb-1">CANCELADAS</div>
				<div class="text-red-500 text-3xl font-bold"><?= $stats['cancelled'] ?></div>
			</div>
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">INGRESOS TOTALES</div>
				<div class="text-amber-500 text-2xl font-bold"><?= number_format($stats['total_revenue']) ?> <i class="fas fa-coins text-xl"></i></div>
			</div>
		</div>

		<!-- Tabla de órdenes -->
		<?php if (empty($orders)): ?>
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 text-amber-400 text-center">
				No hay órdenes registradas.
			</div>
		<?php else: ?>
			<div class="space-y-4">
				<?php foreach ($orders as $order): ?>
					<?php
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
					
					<div class="order-card bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all">
						<!-- Header -->
						<div class="bg-amber-900/10 border-b border-amber-600/30 p-4">
							<div class="flex justify-between items-start">
								<div>
									<h3 class="text-amber-500 font-bold text-lg tracking-wide">
										ORDEN #<?= str_pad((string)$order->id, 6, '0', STR_PAD_LEFT) ?>
									</h3>
									<div class="mt-2 space-y-1 text-xs text-amber-600/70">
										<p><i class="fas fa-user text-amber-500/60 mr-2"></i>Usuario: <span class="text-amber-400"><?= htmlspecialchars($order->user_name ?? 'N/A') ?></span> (<?= htmlspecialchars($order->user_email ?? 'N/A') ?>)</p>
										<p><i class="fas fa-calendar text-amber-500/60 mr-2"></i>Fecha: <?= date('d/m/Y H:i', strtotime($order->placed_at)) ?></p>
										<?php if ($order->fulfilled_at): ?>
											<p><i class="fas fa-check-circle text-green-500/60 mr-2"></i>Completada: <?= date('d/m/Y H:i', strtotime($order->fulfilled_at)) ?></p>
										<?php endif; ?>
										<?php if ($order->cancelled_at): ?>
											<p><i class="fas fa-times-circle text-red-500/60 mr-2"></i>Cancelada: <?= date('d/m/Y H:i', strtotime($order->cancelled_at)) ?></p>
										<?php endif; ?>
									</div>
								</div>
								<div class="text-right">
									<span class="inline-block px-3 py-1 rounded border <?= $statusColor ?> text-sm font-bold mb-2">
										<?= $statusLabel ?>
									</span>
									<p class="text-3xl font-bold text-amber-500"><?= number_format($order->total_credits) ?> <i class="fas fa-coins text-2xl"></i></p>
								</div>
							</div>
						</div>

				<!-- Items -->
				<div class="p-4">
					<h4 class="text-amber-600/70 text-xs uppercase tracking-widest mb-3"><i class="fas fa-file-contract mr-2"></i>Pactos Adquiridos</h4>
					<div class="space-y-3 mb-4">
						<?php foreach ($order->items as $item): ?>
							<?php 
							$snapshot = json_decode($item['snapshot'], true);
							$pactName = $item['pact_name'] ?? $snapshot['name'] ?? 'Pacto Desconocido';
							$demonName = $snapshot['demon_name'] ?? 'Desconocido';
							$summary = $snapshot['summary'] ?? null;
							$duration = $snapshot['duration'] ?? null;
							$cooldown = $snapshot['cooldown'] ?? null;
							
							// Obtener imagen del snapshot o del pacto actual
							$pactImage = null;
							$imageFileId = $snapshot['image_file_id'] ?? null;
							
							// Si no hay en snapshot, intentar obtener del pacto actual
							if (!$imageFileId && isset($item['pact_id'])) {
								$pact = Pact::find((int)$item['pact_id']);
								if ($pact) {
									$imageFileId = $pact->image_file_id;
								}
							}
							
							// Obtener la ruta de la imagen
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
							<div class="bg-black/50 border border-amber-600/20 rounded-lg overflow-hidden hover:border-amber-600/40 transition-all flex flex-col sm:flex-row">
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
										<i class="fas fa-image text-amber-600/30 text-3xl"></i>
									</div>
								<?php endif; ?>
								
								<!-- Contenido del item -->
								<div class="flex-1 p-3 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
									<!-- Info del pacto -->
									<div class="flex-1 min-w-0">
										<h5 class="text-amber-300 font-bold text-sm mb-1"><?= htmlspecialchars($pactName) ?></h5>
										<p class="text-amber-500/70 text-xs uppercase tracking-wider mb-2">
											<i class="fas fa-skull mr-1"></i><?= htmlspecialchars($demonName) ?>
										</p>
										<?php if ($summary): ?>
											<p class="text-amber-600/60 text-xs mb-2"><?= htmlspecialchars($summary) ?></p>
										<?php endif; ?>
										<?php if ($duration || $cooldown): ?>
											<div class="flex gap-4 text-xs text-amber-500/50 uppercase tracking-wider">
												<?php if ($duration): ?>
													<span><i class="fas fa-clock mr-1"></i>Duración: <?= htmlspecialchars($duration) ?></span>
												<?php endif; ?>
												<?php if ($cooldown): ?>
													<span><i class="fas fa-rotate-right mr-1"></i>Cooldown: <?= htmlspecialchars($cooldown) ?></span>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</div>
									<!-- Precio -->
									<div class="flex items-center w-full md:w-auto justify-end">
										<span class="text-2xl font-bold text-amber-500 whitespace-nowrap">
											<?= number_format($item['unit_price_credits']) ?> <i class="fas fa-coins text-xl"></i>
										</span>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>							<?php if ($order->notes): ?>
								<div class="bg-yellow-900/20 border border-yellow-600/40 p-3 rounded mb-4">
									<p class="text-yellow-400 text-xs">
										<span class="font-bold">Nota:</span> <?= htmlspecialchars($order->notes) ?>
									</p>
								</div>
							<?php endif; ?>

							<!-- Acciones -->
							<div class="flex gap-3 pt-3 border-t border-amber-600/20">
								<?php if ($order->status === 'paid'): ?>
									<form method="POST" action="/?sec=admin&action=fulfill-order" class="flex-1">
										<input type="hidden" name="order_id" value="<?= $order->id ?>">
										<button 
											type="submit"
											class="w-full px-4 py-2 rounded border border-green-600/40 bg-green-600/10 text-green-500 hover:bg-green-600/20 text-xs tracking-wide transition">
											<i class="fas fa-check-circle mr-1"></i> OTORGAR PACTOS (COMPLETAR)
										</button>
									</form>
									<button 
										type="button"
										onclick="openCancelModal(<?= $order->id ?>)"
										class="flex-1 px-4 py-2 rounded border border-red-600/40 bg-red-600/10 text-red-500 hover:bg-red-600/20 text-xs tracking-wide transition">
										<i class="fas fa-times-circle mr-1"></i> CANCELAR ORDEN
									</button>
								<?php elseif ($order->status === 'fulfilled'): ?>
									<div class="flex-1 text-center text-green-400 text-sm py-2">
										<i class="fas fa-check mr-2"></i>Pactos otorgados correctamente
									</div>
								<?php elseif ($order->status === 'cancelled'): ?>
									<div class="flex-1 text-center text-red-400 text-sm py-2">
										<i class="fas fa-times mr-2"></i>Orden cancelada
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="mt-10 text-center text-xs tracking-widest text-amber-600/50">
			// GESTIÓN DE ÓRDENES :: ABYSSUM
		</div>
	</div>
</div>

<!-- Modal de Cancelación -->
<div id="cancelModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm">
	<div class="bg-black border-2 border-red-500/50 rounded-xl max-w-md w-full mx-4 p-6 shadow-[0_0_50px_rgba(239,68,68,0.3)]">
									<h3 class="text-2xl font-bold text-red-500 mb-4 tracking-wide flex items-center gap-2"><i class="fas fa-exclamation-triangle"></i> CANCELAR ORDEN</h3>
		<p class="text-amber-200/80 mb-6 text-sm">
			¿Estás seguro que querés cancelar esta orden? Esta acción no se puede deshacer.
		</p>
		<form id="cancelForm" method="POST" action="/?sec=admin&action=cancel-order">
			<input type="hidden" name="order_id" id="cancelOrderId">
			<div class="flex gap-3">
				<button 
					type="button"
					onclick="closeCancelModal()"
					class="flex-1 px-4 py-2 rounded border border-amber-600/40 bg-black/60 text-amber-400 hover:bg-amber-600/10 tracking-wide transition">
					VOLVER
				</button>
				<button 
					type="submit"
					class="flex-1 px-4 py-2 rounded border border-red-600/40 bg-red-600/10 text-red-500 hover:bg-red-600/20 tracking-wide transition font-bold">
					CONFIRMAR
				</button>
			</div>
		</form>
	</div>
</div>

<script>
function openCancelModal(orderId) {
	document.getElementById('cancelOrderId').value = orderId;
	document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
	document.getElementById('cancelModal').classList.add('hidden');
}

// Cerrar modal con ESC
document.addEventListener('keydown', (e) => {
	if (e.key === 'Escape') {
		closeCancelModal();
	}
});

// Cerrar modal al hacer click fuera
document.getElementById('cancelModal')?.addEventListener('click', (e) => {
	if (e.target.id === 'cancelModal') {
		closeCancelModal();
	}
});
</script>
