<?php
declare(strict_types=1);
require_once BASE_PATH . '/classes/DbConnection.php';
require_once BASE_PATH . '/classes/Demon.php';

$demons = Demon::all();
$totalDemons = count($demons);
?>

<div class="min-h-screen bg-black relative overflow-hidden px-6 py-12 font-mono">
	<!-- Ambient background grid & glow -->
	<div class="pointer-events-none fixed inset-0 opacity-5">
		<div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
	</div>
	<div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
	<div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

	<!-- Header / Title Row -->
	<div class="max-w-7xl mx-auto relative z-10">
		<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-12">
			<div>
				<h1 id="dashTitle" class="text-6xl font-bold tracking-widest text-amber-500">
					<span class="block">ABYSSUM</span>
					<span class="block text-2xl mt-2 tracking-wide text-amber-600/80">// DEMONIOS :: LISTADO</span>
				</h1>
			</div>
			<div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
				<div class="group bg-black/70 border border-amber-600/30 rounded-xl p-4 flex-1 min-w-[180px] backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TOTAL DEMONIOS</div>
					<div class="flex items-end justify-between">
						<div class="text-amber-500 text-2xl font-bold"><?= $totalDemons ?></div>
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

		<!-- Toolbar Row -->
				<!-- Toolbar con buscador y botón crear -->
		<div id="toolbar" class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between mb-10">
			<div class="flex items-center gap-3 w-full md:w-auto">
				<div class="relative flex-1 md:flex-none md:w-72">
					<input type="text" id="searchInput" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// buscar demonio..." />
					<span class="absolute right-3 top-1/2 -translate-y-1/2 text-amber-600/50 text-xs">CTRL+K</span>
				</div>
				<button class="px-4 py-2 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 rounded transition text-sm tracking-wide" type="button" id="clearBtn">LIMPIAR</button>
			</div>
			<div class="flex gap-3">
				<a href="/?sec=admin&page=new-demon&return_to=demons" class="group relative inline-flex items-center gap-2 px-5 py-2 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/20 transition overflow-hidden">
					<span class="text-amber-500 text-sm tracking-wide font-semibold">+ CREAR DEMONIO</span>
					<span class="absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition bg-gradient-to-r from-amber-600/0 via-amber-600/20 to-amber-600/0"></span>
				</a>
				<a href="/?sec=admin" class="px-5 py-2.5 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/10 text-amber-500 text-sm tracking-wide transition">VOLVER</a>
			</div>
		</div>

		<!-- Demons Section -->
		<?php if (!empty($demons)): ?>
			<div>
				<div class="grid gap-6 md:grid-cols-3 lg:grid-cols-4" id="demonsList">
					<?php foreach ($demons as $d): ?>
					<div class="demon-card bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:border-amber-500/50 transition group"
						 data-searchable="<?= htmlspecialchars(strtolower($d->name . ' ' . $d->slug)) ?>">
						<!-- Image -->
						<?php if (!empty($d->image_file_id)): ?>
							<div class="w-full overflow-hidden bg-black/50 border-b border-amber-600/20">
								<img src="/?file_id=<?= $d->image_file_id ?>" alt="<?= htmlspecialchars($d->name) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
							</div>
						<?php else: ?>
							<div class="w-full h-32 flex items-center justify-center bg-gradient-to-br from-black/80 to-amber-950/20 border-b border-amber-600/20">
								<svg class="w-12 h-12 text-amber-600/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
								</svg>
							</div>
						<?php endif; ?>
						
						<div class="p-5">
							<div class="text-sm text-amber-500 font-semibold mb-1"><?= htmlspecialchars($d->name) ?></div>
							<div class="text-xs text-amber-600/70 mb-2">ID: <?= htmlspecialchars($d->slug) ?></div>
						<div class="text-xs text-gray-400 mb-3 line-clamp-2"><?= htmlspecialchars(substr($d->summary ?? '', 0, 80)) ?><?= strlen($d->summary ?? '') > 80 ? '...' : '' ?></div>
						<div class="flex gap-2">
							<a href="/?sec=admin&page=demon-detail&id=<?= urlencode($d->slug) ?>&return_to=demons" class="flex-1 text-xs px-3 py-1.5 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition text-center">VER</a>
							<a href="/?sec=admin&page=edit-demon&id=<?= urlencode($d->slug) ?>&return_to=demons" class="flex-1 text-xs px-3 py-1.5 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition text-center">EDITAR</a>
								<a href="/?sec=admin&action=delete-demon&id=<?= urlencode($d->slug) ?>&return_to=demons" onclick="return confirm('¿Eliminar este demonio?')" class="flex-1 text-xs px-3 py-1.5 rounded border border-red-600/40 text-red-500 bg-black/50 hover:bg-red-600/20 transition text-center">ELIMINAR</a>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 text-amber-400 text-center">
				No hay demonios cargados. <a href="/?sec=admin&page=new-demon" class="underline">Creá uno nuevo</a>.
			</div>
		<?php endif; ?>

		<!-- Footer info strip -->
		<div class="mt-14 text-center text-xs tracking-widest text-amber-600/50">
			// DATABASE_DRIVEN :: ABYSSUM_ADMIN :: v1.0
		</div>
	</div>
</div>

<script>
// Fallback: ensure demon cards stay visible
document.querySelectorAll('.demon-card').forEach(el => {
	el.style.opacity = '1';
	el.style.transform = 'translateY(0)';
});
</script>
