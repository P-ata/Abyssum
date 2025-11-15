<div class="min-h-screen bg-black relative overflow-hidden py-20 px-6">
	<!-- Gold frame + grid background -->
	<div class="fixed inset-4 border-2 border-amber-600/50 pointer-events-none z-40"></div>
	<div class="fixed inset-0 opacity-5 pointer-events-none">
		<div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.10) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.10) 1px, transparent 1px); background-size: 55px 55px;"></div>
	</div>

	<div class="max-w-5xl mx-auto relative z-10 text-center">
		<div class="text-8xl md:text-9xl font-black tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-amber-600 to-amber-500 drop-shadow-[0_0_25px_rgba(251,191,36,0.25)] select-none">404</div>
		<p class="mt-4 text-amber-500/90 text-base md:text-lg font-mono tracking-widest uppercase">// Página no encontrada</p>
		<p class="mt-2 text-amber-600/70 text-xs md:text-sm font-mono">El demonio que buscas no está aquí. Quizás fue invocado a otro plano.</p>

		<div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
			<a href="/" class="px-6 py-3 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">VOLVER AL ABYSSUM</a>
			<a href="/?sec=pacts" class="px-6 py-3 rounded border border-amber-600/60 bg-amber-600/20 hover:bg-amber-600/30 text-amber-400 text-sm tracking-wide transition">VER PACTOS</a>
		</div>
	</div>

	<!-- Minimal decorative rings -->
	<div class="absolute -top-10 -left-10 w-72 h-72 rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.4), transparent 70%);"></div>
	<div class="absolute -bottom-10 -right-10 w-96 h-96 rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.3), transparent 70%);"></div>
</div>

<script>
	// Soft entrance animation (uses global GSAP already included for public)
	if (window.gsap) {
		window.addEventListener('DOMContentLoaded', () => {
			const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
			tl.from('div.text-8xl, div.text-9xl', { y: 30, opacity: 0, duration: 0.6 })
				.from('p.font-mono', { y: 15, opacity: 0, stagger: 0.1, duration: 0.4 }, '-=0.25')
				.from('a', { y: 20, opacity: 0, stagger: 0.08, duration: 0.4 }, '-=0.2');
		});
	}
</script>
