<?php
declare(strict_types=1);
require_once BASE_PATH . '/classes/DbConnection.php';
require_once BASE_PATH . '/classes/Pact.php';
require_once BASE_PATH . '/classes/Demon.php';
require_once BASE_PATH . '/classes/Category.php';

$pacts = Pact::all();

// Build a map of demon_id => Demon for quick access
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

	<div class="max-w-7xl mx-auto relative z-10">
		<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-10">
			<h1 class="text-5xl font-bold tracking-widest text-amber-500">
				<span class="block">ABYSSUM</span>
				<span class="block text-xl mt-2 tracking-wide text-amber-600/80">// PACTOS :: LISTADO</span>
			</h1>
			<div class="flex gap-3">
				<a href="/admin/new-pact" class="px-5 py-2.5 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">+ NUEVO</a>
				<a href="/admin" class="px-5 py-2.5 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/10 text-amber-500 text-sm tracking-wide transition">VOLVER</a>
			</div>
		</div>

		<?php if (empty($pacts)): ?>
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 text-amber-400">
				No hay pactos cargados. Importá los datos o creá uno nuevo.
			</div>
		<?php else: ?>
			<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" id="pactsList">
				<?php foreach ($pacts as $p): ?>
					<?php 
					$demonId = (int)$p->demon_id;
					$d = $demons[$demonId] ?? null; 
					$cats = $p->categories(); 
					?>
					<div class="group relative bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all">
						<div class="p-5 flex flex-col h-full">
							<div class="flex items-start justify-between mb-3">
								<h3 class="text-amber-500 font-semibold tracking-wide text-lg"><?= htmlspecialchars($p->name) ?></h3>
								<span class="text-xs px-2 py-1 rounded border border-amber-600/40 text-amber-600/70 tracking-wider">CRÉDITOS: <?= (int)($p->price_credits ?? 0) ?></span>
							</div>
							<div class="text-xs text-amber-600/70 mb-2">
								Demonio: <span class="text-amber-400 font-semibold"><?= htmlspecialchars($d?->name ?? $p->demon_id) ?></span>
							</div>
							<p class="text-xs leading-relaxed text-gray-400 mb-3 flex-1"><?= htmlspecialchars($p->summary ?? '') ?></p>

							<?php if (!empty($cats)): ?>
								<div class="mb-3 flex flex-wrap gap-2">
									<?php foreach ($cats as $c): ?>
										<span class="text-[10px] px-2 py-1 rounded border border-amber-600/40 text-amber-500 tracking-wider"><?= htmlspecialchars($c->display_name) ?></span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<div class="mt-auto flex gap-3">
								<a href="#" class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">VER</a>
								<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition" disabled>ACCIONES</button>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="mt-10 text-center text-xs tracking-widest text-amber-600/50">// LISTADO GENERADO DESDE DB :: pacts</div>
	</div>
</div>
