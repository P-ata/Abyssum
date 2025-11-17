<div class="min-h-[70vh] bg-black relative overflow-hidden px-6 py-16 font-mono flex items-center justify-center">
	<div class="pointer-events-none fixed inset-0 opacity-5"><div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div></div>
	<div class="max-w-3xl mx-auto relative z-10 text-center">
		<div class="text-7xl md:text-8xl font-black tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-amber-600 to-amber-500 drop-shadow-[0_0_20px_rgba(251,191,36,0.25)]">404</div>
		<p class="mt-4 text-amber-500/90 text-sm tracking-widest">// RECURSO NO ENCONTRADO</p>
		<p class="mt-2 text-amber-600/70 text-xs">El demonio o recurso que buscas no existe o fue movido a otro plano.</p>
		<div class="mt-8 flex items-center justify-center gap-4">
			<a href="/" class="px-5 py-2 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">VOLVER AL ABYSSUM</a>
			<a href="/?sec=pacts" class="px-5 py-2 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">VER PACTOS</a>
		</div>
	</div>
</div>

<script>
	// Animación de entrada suave (usa GSAP global ya incluido)
	if (window.gsap) {
		window.addEventListener('DOMContentLoaded', () => {
			const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
			tl.from('.text-7xl, .text-8xl', { y: 30, opacity: 0, duration: 0.6 })
				.from('p.tracking-widest', { y: 15, opacity: 0, stagger: 0.1, duration: 0.4 }, '-=0.25')
				.from('a', { y: 20, opacity: 0, stagger: 0.08, duration: 0.4 }, '-=0.2');
		});
	}
</script>
