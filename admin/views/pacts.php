<?php
declare(strict_types=1);
require_once BASE_PATH . '/classes/DbConnection.php';
require_once BASE_PATH . '/classes/Pact.php';
require_once BASE_PATH . '/classes/Demon.php';
require_once BASE_PATH . '/classes/Category.php';

$pacts = Pact::all();
$totalPacts = count($pacts);

// Cargar demonios relacionados
/** @var array<int, Demon|null> $demons */
$demons = [];
foreach ($pacts as $p) {
		$demonId = (int)$p->demon_id;
		if (!isset($demons[$demonId])) {
				$demons[$demonId] = Demon::find($demonId);
		}
}
?>

<div class="min-h-screen bg-black relative overflow-hidden px-6 py-12 font-mono">
	
	<div class="pointer-events-none fixed inset-0 opacity-5">
		<div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
	</div>
	<div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
	<div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

	<div class="max-w-7xl mx-auto relative z-10">
		
		<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-12">
			<div>
				<h1 id="dashTitle" class="text-6xl font-bold tracking-widest text-amber-500">
					<span class="block">ABYSSUM</span>
					<span class="block text-2xl mt-2 tracking-wide text-amber-600/80">// PACTOS :: LISTADO</span>
				</h1>
			</div>
			<div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
				
				<div class="group bg-black/70 border border-amber-600/30 rounded-xl p-4 flex-1 min-w-[180px] backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TOTAL PACTOS</div>
					<div class="flex items-end justify-between">
						<div class="text-amber-500 text-2xl font-bold"><?= $totalPacts ?></div>
						<div class="text-xs text-gray-600">// activos</div>
					</div>
					<div class="mt-2 h-1 w-full bg-amber-600/20 relative overflow-hidden rounded">
						<div class="absolute inset-y-0 left-0 bg-amber-500/70 w-3/4" data-bar></div>
					</div>
				</div>
				<div class="group bg-black/70 border border-amber-600/30 rounded-xl p-4 flex-1 min-w-[180px] backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">ESTADO</div>
					<div class="flex items-end justify-between">
						<div class="text-green-500 text-2xl font-bold">OK</div>
						<div class="text-xs text-gray-600">// online</div>
					</div>
					<div class="mt-2 h-1 w-full bg-amber-600/20 relative overflow-hidden rounded">
						<div class="absolute inset-y-0 left-0 bg-green-500/70 w-full" data-bar></div>
					</div>
				</div>
			</div>
		</div>

		<!-- herramientas -->
		<div id="toolbar" class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between mb-10">
			<div class="flex items-center gap-3 w-full md:w-auto">
				<div class="relative flex-1 md:flex-none md:w-72">
					<input type="text" id="searchInput" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// buscar pacto..." />
					<span class="absolute right-3 top-1/2 -translate-y-1/2 text-amber-600/50 text-xs">CTRL+K</span>
				</div>
				<button class="px-4 py-2 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 rounded transition text-sm tracking-wide" type="button" id="clearBtn">LIMPIAR</button>
			</div>
			<div class="flex gap-3">
				<a href="/?sec=admin&page=new-pact&return_to=pacts" class="group relative inline-flex items-center gap-2 px-5 py-2 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/20 transition overflow-hidden">
					<span class="text-amber-500 text-sm tracking-wide font-semibold">+ CREAR PACTO</span>
					<span class="absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition bg-gradient-to-r from-amber-600/0 via-amber-600/20 to-amber-600/0"></span>
				</a>
				<a href="/?sec=admin" class="px-5 py-2.5 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/10 text-amber-500 text-sm tracking-wide transition">VOLVER</a>
			</div>
		</div>

		<!-- pactos -->
		<?php if (empty($pacts)): ?>
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 text-amber-400 text-center">
				No hay pactos cargados. <a href="/?sec=admin&page=new-pact" class="underline">Creá uno nuevo</a>.
			</div>
		<?php else: ?>
			<div id="pactsGrid" class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
				<?php foreach ($pacts as $p): 
					$d = Demon::find($p->demon_id);
				?>
					<div class="group relative bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all pact-card"
						 data-searchable="<?= htmlspecialchars(strtolower($p->name . ' ' . ($d?->name ?? ''))) ?>">
						<!-- Image -->
						<?php if (!empty($p->image_file_id)): ?>
							<div class="w-full overflow-hidden bg-black/50 border-b border-amber-600/20">
								<img src="/?file_id=<?= $p->image_file_id ?>" alt="<?= htmlspecialchars($p->name) ?>" class="w-full h-full object-cover" />
							</div>
						<?php else: ?>
							<div class="w-full h-32 flex items-center justify-center bg-gradient-to-br from-black/80 to-amber-950/20 border-b border-amber-600/20">
								<svg class="w-12 h-12 text-amber-600/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
								</svg>
							</div>
						<?php endif; ?>
						
						<div class="p-4">
							<div class="flex items-start justify-between mb-3">
								<h3 class="text-amber-500 font-semibold tracking-wide text-lg"><?= htmlspecialchars($p->name) ?></h3>
								<span class="text-xs px-2 py-1 rounded border border-amber-600/40 text-amber-600/70 tracking-wider"><?= (int)($p->price_credits ?? 0) ?> CR</span>
							</div>
							<div class="text-xs text-amber-600/70 mb-2">
								Demonio: <span class="text-amber-400 font-semibold"><?= htmlspecialchars($d?->name ?? 'Unknown') ?></span>
							</div>
							<p class="text-xs leading-relaxed text-gray-400 mb-4"><?= htmlspecialchars(substr($p->summary ?? '', 0, 120)) ?><?= strlen($p->summary ?? '') > 120 ? '...' : '' ?></p>
						<div class="flex gap-2">
						<a href="/?sec=admin&page=pact-detail&id=<?= urlencode((string)$p->id) ?>&return_to=pacts" class="flex-1 text-xs px-2 py-1.5 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition text-center">VER</a>
						<a href="/?sec=admin&page=edit-pact&id=<?= urlencode((string)$p->id) ?>&return_to=pacts" class="flex-1 text-xs px-2 py-1.5 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition text-center">EDITAR</a>
						<a href="#" onclick="showDeleteModal('/?sec=admin&action=delete-pact&id=<?= urlencode((string)$p->id) ?>&return_to=pacts', '¿Eliminar el pacto <?= htmlspecialchars($p->name) ?>?'); return false;" class="flex-1 text-xs px-2 py-1.5 rounded border border-red-600/40 text-red-500 bg-black/50 hover:bg-red-600/20 transition text-center">ELIMINAR</a>
						</div>
						</div>
						<div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 group-hover:w-full transition-all"></div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="mt-10 text-center text-xs tracking-widest text-amber-600/50">// LISTADO :: pacts</div>
	</div>
</div>
