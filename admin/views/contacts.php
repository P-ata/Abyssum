<?php
require_once BASE_PATH . '/classes/Contact.php';

$stats = Contact::getStats();
$filter = $_GET['status'] ?? 'all';

$contacts = $filter === 'all' ? Contact::all() : Contact::byStatus($filter);

// mapeo de estados a colores
$statusColors = [
    'new' => 'yellow',
    'in_progress' => 'blue',
    'resolved' => 'green',
    'spam' => 'red'
];

$statusLabels = [
    'new' => 'NUEVO',
    'in_progress' => 'EN PROCESO',
    'resolved' => 'RESUELTO',
    'spam' => 'SPAM'
];
?>

<div class="min-h-screen bg-black relative overflow-hidden px-6 py-12 font-mono">
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
					<span class="block text-2xl mt-2 tracking-wide text-amber-600/80">// CONTACTOS</span>
				</h1>
			</div>
			<div class="flex gap-3">
				<a href="/?sec=admin" class="px-5 py-2.5 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/10 text-amber-500 text-sm tracking-wide transition">VOLVER</a>
			</div>
		</div>

		<!-- estadísticas -->
		<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TOTAL</div>
				<div class="text-amber-500 text-3xl font-bold"><?= $stats['total'] ?></div>
			</div>
			<div class="bg-black/70 border border-yellow-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-yellow-600/70 mb-1">NUEVOS</div>
				<div class="text-yellow-500 text-3xl font-bold"><?= $stats['new'] ?></div>
			</div>
			<div class="bg-black/70 border border-blue-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-blue-600/70 mb-1">EN PROCESO</div>
				<div class="text-blue-500 text-3xl font-bold"><?= $stats['in_progress'] ?></div>
			</div>
			<div class="bg-black/70 border border-green-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-green-600/70 mb-1">RESUELTOS</div>
				<div class="text-green-500 text-3xl font-bold"><?= $stats['resolved'] ?></div>
			</div>
			<div class="bg-black/70 border border-red-600/30 rounded-xl p-4 backdrop-filter" data-stat>
				<div class="text-xs uppercase tracking-widest text-red-600/70 mb-1">SPAM</div>
				<div class="text-red-500 text-3xl font-bold"><?= $stats['spam'] ?></div>
			</div>
		</div>

		<!-- filtros -->
		<div id="filterButtons" class="flex gap-3 mb-8">
			<a href="/?sec=admin&page=contacts&status=all" class="px-5 py-2.5 rounded border text-sm tracking-wide transition font-bold <?= $filter === 'all' ? 'border-amber-600/40 bg-amber-600/20 text-amber-500' : 'border-amber-600/30 text-amber-600 hover:bg-amber-600/10' ?>">
				TODOS
			</a>
			<a href="/?sec=admin&page=contacts&status=new" class="px-5 py-2.5 rounded border text-sm tracking-wide transition font-bold <?= $filter === 'new' ? 'border-yellow-600/40 bg-yellow-600/20 text-yellow-500' : 'border-yellow-600/30 text-yellow-600 hover:bg-yellow-600/10' ?>">
				NUEVOS
			</a>
			<a href="/?sec=admin&page=contacts&status=in_progress" class="px-5 py-2.5 rounded border text-sm tracking-wide transition font-bold <?= $filter === 'in_progress' ? 'border-blue-600/40 bg-blue-600/20 text-blue-500' : 'border-blue-600/30 text-blue-600 hover:bg-blue-600/10' ?>">
				EN PROCESO
			</a>
			<a href="/?sec=admin&page=contacts&status=resolved" class="px-5 py-2.5 rounded border text-sm tracking-wide transition font-bold <?= $filter === 'resolved' ? 'border-green-600/40 bg-green-600/20 text-green-500' : 'border-green-600/30 text-green-600 hover:bg-green-600/10' ?>">
				RESUELTOS
			</a>
			<a href="/?sec=admin&page=contacts&status=spam" class="px-5 py-2.5 rounded border text-sm tracking-wide transition font-bold <?= $filter === 'spam' ? 'border-red-600/40 bg-red-600/20 text-red-500' : 'border-red-600/30 text-red-600 hover:bg-red-600/10' ?>">
				SPAM
			</a>
		</div>

		<!-- lista de contactos -->
		<?php if (empty($contacts)): ?>
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 text-amber-400 text-center">
				No hay mensajes <?= $filter !== 'all' ? 'con este estado' : '' ?>
			</div>
		<?php else: ?>
			<div class="space-y-4">
				<?php foreach ($contacts as $contact): ?>
					<?php 
					$color = $statusColors[$contact->status];
					$statusLabel = $statusLabels[$contact->status];
					?>
					<div class="contact-card bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all">
						<!-- header del contacto -->
						<div class="bg-amber-900/10 border-b border-amber-600/30 p-4">
							<div class="flex justify-between items-start">
								<div class="flex-1">
									<div class="flex items-center gap-3 mb-2">
										<h3 class="text-amber-500 font-bold text-lg tracking-wide"><?= htmlspecialchars($contact->name) ?></h3>
										<span class="px-3 py-1 text-xs rounded border bg-<?= $color ?>-600/20 text-<?= $color ?>-400 border-<?= $color ?>-600/40 font-bold">
											<?= $statusLabel ?>
										</span>
									</div>
									<div class="flex gap-4 text-xs text-amber-600/70">
										<span><i class="fas fa-envelope mr-1"></i><?= htmlspecialchars($contact->email) ?></span>
										<span><i class="fas fa-calendar mr-1"></i><?php
										date_default_timezone_set('America/Argentina/Buenos_Aires');
										$datetime = new DateTime($contact->sent_at);
										echo $datetime->format('d/m/Y H:i');
										?></span>
										<?php if ($contact->ip_address): ?>
											<span><i class="fas fa-globe mr-1"></i><?= htmlspecialchars($contact->ip_address) ?></span>
										<?php endif; ?>
									</div>
									<?php if ($contact->subject): ?>
										<div class="mt-2 text-sm text-amber-400">
											<strong>Asunto:</strong> <?= htmlspecialchars($contact->subject) ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<!-- mensaje -->
						<div class="p-4 bg-black/50">
							<p class="text-amber-200/80 whitespace-pre-wrap text-sm"><?= htmlspecialchars($contact->message) ?></p>
						</div>

						<!-- acciones -->
						<div class="p-4 flex gap-3 border-t border-amber-600/20">
							<?php if ($contact->status !== 'in_progress'): ?>
								<form method="POST" action="/?sec=admin&action=update-contact-status" class="inline">
									<input type="hidden" name="contact_id" value="<?= $contact->id ?>">
									<input type="hidden" name="status" value="in_progress">
									<button type="submit" class="px-4 py-2 rounded border border-blue-600/40 bg-blue-600/10 text-blue-500 hover:bg-blue-600/20 text-xs tracking-wide transition">
										<i class="fas fa-spinner mr-1"></i> EN PROCESO
									</button>
								</form>
							<?php endif; ?>

							<?php if ($contact->status !== 'resolved'): ?>
								<form method="POST" action="/?sec=admin&action=update-contact-status" class="inline">
									<input type="hidden" name="contact_id" value="<?= $contact->id ?>">
									<input type="hidden" name="status" value="resolved">
									<button type="submit" class="px-4 py-2 rounded border border-green-600/40 bg-green-600/10 text-green-500 hover:bg-green-600/20 text-xs tracking-wide transition">
										<i class="fas fa-check mr-1"></i> RESUELTO
									</button>
								</form>
							<?php endif; ?>

							<?php if ($contact->status !== 'spam'): ?>
								<form method="POST" action="/?sec=admin&action=update-contact-status" class="inline">
									<input type="hidden" name="contact_id" value="<?= $contact->id ?>">
									<input type="hidden" name="status" value="spam">
									<button type="submit" class="px-4 py-2 rounded border border-red-600/40 bg-red-600/10 text-red-500 hover:bg-red-600/20 text-xs tracking-wide transition">
										<i class="fas fa-ban mr-1"></i> SPAM
									</button>
								</form>
							<?php endif; ?>

							<?php if ($contact->handled_by): ?>
								<span class="ml-auto text-xs text-amber-600/50">
									Gestionado por: <?= htmlspecialchars($contact->handler_name ?? 'Usuario #' . $contact->handled_by) ?>
								</span>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</div>
