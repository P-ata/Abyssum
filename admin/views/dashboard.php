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
				<h1 class="text-6xl font-bold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-amber-600 to-amber-500 drop-shadow-[0_0_10px_rgba(251,191,36,0.35)]" id="dashTitle">
					<span class="block">ABYSSUM</span>
					<span class="block text-2xl mt-2 tracking-wide text-amber-600/80">// PACTOS :: PANEL</span>
				</h1>
			</div>
			<div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto" id="quickStats">
				<!-- Stat card -->
				<div class="group bg-black/70 border border-amber-600/30 rounded-xl p-4 flex-1 min-w-[180px] backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TOTAL PACTOS</div>
					<div class="flex items-end justify-between">
						<div class="text-amber-500 text-2xl font-bold" data-value="42">42</div>
						<div class="text-xs text-gray-600">// activos</div>
					</div>
					<div class="mt-2 h-1 w-full bg-amber-600/20 relative overflow-hidden rounded">
						<div class="absolute inset-y-0 left-0 bg-amber-500/70 w-3/4" data-bar></div>
					</div>
				</div>
				<div class="group bg-black/70 border border-amber-600/30 rounded-xl p-4 flex-1 min-w-[180px] backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">NUEVOS HOY</div>
						<div class="flex items-end justify-between">
							<div class="text-amber-500 text-2xl font-bold" data-value="3">3</div>
							<div class="text-xs text-gray-600">// indexados</div>
						</div>
						<div class="mt-2 h-1 w-full bg-amber-600/20 relative overflow-hidden rounded">
							<div class="absolute inset-y-0 left-0 bg-amber-500/70 w-1/5" data-bar></div>
						</div>
				</div>
				<div class="group bg-black/70 border border-amber-600/30 rounded-xl p-4 flex-1 min-w-[180px] backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">RIESGO ALTO</div>
						<div class="flex items-end justify-between">
							<div class="text-amber-500 text-2xl font-bold" data-value="7">7</div>
							<div class="text-xs text-gray-600">// monitoreo</div>
						</div>
						<div class="mt-2 h-1 w-full bg-amber-600/20 relative overflow-hidden rounded">
							<div class="absolute inset-y-0 left-0 bg-red-500/70 w-2/5" data-bar></div>
						</div>
				</div>
			</div>
		</div>

		<!-- Toolbar Row -->
		<div class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between mb-10" id="toolbar">
			<div class="flex items-center gap-3 w-full md:w-auto">
				<div class="relative flex-1 md:flex-none md:w-72">
					<input type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// buscar pacto..." />
					<span class="absolute right-3 top-1/2 -translate-y-1/2 text-amber-600/50 text-xs">CTRL+K</span>
				</div>
				<button class="px-4 py-2 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 rounded transition text-sm tracking-wide" type="button" id="clearBtn">LIMPIAR</button>
			</div>
			<div class="flex gap-4">
				<a href="/admin/new-pact" class="group relative inline-flex items-center gap-2 px-5 py-2 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/20 transition overflow-hidden">
					<span class="text-amber-500 text-sm tracking-wide font-semibold">+ CREAR PACTO</span>
					<span class="absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition bg-gradient-to-r from-amber-600/0 via-amber-600/20 to-amber-600/0"></span>
				</a>
				<button class="px-5 py-2 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/20 text-sm text-amber-500 tracking-wide transition" type="button">EXPORTAR</button>
			</div>
		</div>

			<!-- Pactos Grid -->
			<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3" id="pactsGrid">
				<!-- 6 cards estáticas (mock) para que se vean siempre -->
				<div class="group relative bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all pact-card" data-risk="MEDIO">
					<div class="p-5 flex flex-col h-full">
						<div class="flex items-start justify-between mb-4">
							<h3 class="text-amber-500 font-semibold tracking-wide text-xl">Pacto #1</h3>
							<span class="text-xs px-2 py-1 rounded border border-amber-600/40 text-amber-600/70 tracking-wider">ACTIVO</span>
						</div>
						<p class="text-xs leading-relaxed text-gray-400 mb-4 flex-1">Descriptor sintético del pacto infernal número 1 con rasgos energéticos y umbrales de uso.</p>
						<div class="mt-auto space-y-2">
							<div class="flex justify-between text-xs text-amber-600/70"><span>PODER</span><span class="text-amber-500">7/10</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>DURACIÓN</span><span class="text-amber-500">3h</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>RIESGO</span><span class="text-amber-500">MEDIO</span></div>
						</div>
						<div class="mt-5 flex gap-3">
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">VER</button>
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">ACCIONES</button>
						</div>
					</div>
					<div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 group-hover:w-full transition-all"></div>
				</div>

				<div class="group relative bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all pact-card" data-risk="ALTO">
					<div class="p-5 flex flex-col h-full">
						<div class="flex items-start justify-between mb-4">
							<h3 class="text-amber-500 font-semibold tracking-wide text-xl">Pacto #2</h3>
							<span class="text-xs px-2 py-1 rounded border border-amber-600/40 text-amber-600/70 tracking-wider">CRÍTICO</span>
						</div>
						<p class="text-xs leading-relaxed text-gray-400 mb-4 flex-1">Descriptor sintético del pacto infernal número 2 con rasgos energéticos y umbrales de uso.</p>
						<div class="mt-auto space-y-2">
							<div class="flex justify-between text-xs text-amber-600/70"><span>PODER</span><span class="text-amber-500">9/10</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>DURACIÓN</span><span class="text-amber-500">2h</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>RIESGO</span><span class="text-amber-500">ALTO</span></div>
						</div>
						<div class="mt-5 flex gap-3">
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">VER</button>
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">ACCIONES</button>
						</div>
					</div>
					<div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 group-hover:w-full transition-all"></div>
				</div>

				<div class="group relative bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all pact-card" data-risk="MEDIO">
					<div class="p-5 flex flex-col h-full">
						<div class="flex items-start justify-between mb-4">
							<h3 class="text-amber-500 font-semibold tracking-wide text-xl">Pacto #3</h3>
							<span class="text-xs px-2 py-1 rounded border border-amber-600/40 text-amber-600/70 tracking-wider">ACTIVO</span>
						</div>
						<p class="text-xs leading-relaxed text-gray-400 mb-4 flex-1">Descriptor sintético del pacto infernal número 3 con rasgos energéticos y umbrales de uso.</p>
						<div class="mt-auto space-y-2">
							<div class="flex justify-between text-xs text-amber-600/70"><span>PODER</span><span class="text-amber-500">6/10</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>DURACIÓN</span><span class="text-amber-500">5h</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>RIESGO</span><span class="text-amber-500">MEDIO</span></div>
						</div>
						<div class="mt-5 flex gap-3">
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">VER</button>
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">ACCIONES</button>
						</div>
					</div>
					<div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 group-hover:w-full transition-all"></div>
				</div>

				<div class="group relative bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all pact-card" data-risk="BAJO">
					<div class="p-5 flex flex-col h-full">
						<div class="flex items-start justify-between mb-4">
							<h3 class="text-amber-500 font-semibold tracking-wide text-xl">Pacto #4</h3>
							<span class="text-xs px-2 py-1 rounded border border-amber-600/40 text-amber-600/70 tracking-wider">ACTIVO</span>
						</div>
						<p class="text-xs leading-relaxed text-gray-400 mb-4 flex-1">Descriptor sintético del pacto infernal número 4 con rasgos energéticos y umbrales de uso.</p>
						<div class="mt-auto space-y-2">
							<div class="flex justify-between text-xs text-amber-600/70"><span>PODER</span><span class="text-amber-500">5/10</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>DURACIÓN</span><span class="text-amber-500">2h</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>RIESGO</span><span class="text-amber-500">BAJO</span></div>
						</div>
						<div class="mt-5 flex gap-3">
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">VER</button>
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">ACCIONES</button>
						</div>
					</div>
					<div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 group-hover:w-full transition-all"></div>
				</div>

				<div class="group relative bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all pact-card" data-risk="ALTO">
					<div class="p-5 flex flex-col h-full">
						<div class="flex items-start justify-between mb-4">
							<h3 class="text-amber-500 font-semibold tracking-wide text-xl">Pacto #5</h3>
							<span class="text-xs px-2 py-1 rounded border border-amber-600/40 text-amber-600/70 tracking-wider">CRÍTICO</span>
						</div>
						<p class="text-xs leading-relaxed text-gray-400 mb-4 flex-1">Descriptor sintético del pacto infernal número 5 con rasgos energéticos y umbrales de uso.</p>
						<div class="mt-auto space-y-2">
							<div class="flex justify-between text-xs text-amber-600/70"><span>PODER</span><span class="text-amber-500">8/10</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>DURACIÓN</span><span class="text-amber-500">4h</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>RIESGO</span><span class="text-amber-500">ALTO</span></div>
						</div>
						<div class="mt-5 flex gap-3">
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">VER</button>
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">ACCIONES</button>
						</div>
					</div>
					<div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 group-hover:w-full transition-all"></div>
				</div>

				<div class="group relative bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden hover:shadow-[0_0_25px_-4px_rgba(251,191,36,0.35)] transition-all pact-card" data-risk="MEDIO">
					<div class="p-5 flex flex-col h-full">
						<div class="flex items-start justify-between mb-4">
							<h3 class="text-amber-500 font-semibold tracking-wide text-xl">Pacto #6</h3>
							<span class="text-xs px-2 py-1 rounded border border-amber-600/40 text-amber-600/70 tracking-wider">ACTIVO</span>
						</div>
						<p class="text-xs leading-relaxed text-gray-400 mb-4 flex-1">Descriptor sintético del pacto infernal número 6 con rasgos energéticos y umbrales de uso.</p>
						<div class="mt-auto space-y-2">
							<div class="flex justify-between text-xs text-amber-600/70"><span>PODER</span><span class="text-amber-500">6/10</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>DURACIÓN</span><span class="text-amber-500">1h</span></div>
							<div class="flex justify-between text-xs text-amber-600/70"><span>RIESGO</span><span class="text-amber-500">MEDIO</span></div>
						</div>
						<div class="mt-5 flex gap-3">
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">VER</button>
							<button class="flex-1 text-xs px-3 py-2 rounded border border-amber-600/40 text-amber-500 bg-black/50 hover:bg-amber-600/20 transition">ACCIONES</button>
						</div>
					</div>
					<div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 group-hover:w-full transition-all"></div>
				</div>
			</div>

		<!-- Footer info strip -->
		<div class="mt-14 text-center text-xs tracking-widest text-amber-600/50">
			// ENDPOINT_STATUS :: OK :: LATENCIA < 120ms
		</div>
	</div>
</div>

<script>
// Fallback: ensure pact cards stay visible even if GSAP fails
document.querySelectorAll('.pact-card').forEach(el => {
  el.style.opacity = '1';
  el.style.transform = 'translateY(0)';
});
</script>
