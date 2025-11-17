import { gsap } from 'gsap';

// Animaciones de la página Abyssum
(() => {
	const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

		onReady(() => {
		// Calcular ancho dinámico de barras
		const statCards = document.querySelectorAll('[data-stat]');
		if (statCards.length) {
			// Obtener todos los valores
			const values = Array.from(statCards).map(card => {
				const value = parseInt(card.querySelector('[data-value]')?.getAttribute('data-value') || '0');
				return value;
			});
			
			// Encontrar valor máximo para cálculo de porcentaje
			const maxValue = Math.max(...values, 1); // Evitar división por cero
			
			// Establecer ancho de barras según porcentaje
			statCards.forEach((card, index) => {
				const bar = card.querySelector('[data-bar]');
				if (bar && values[index] !== undefined) {
					const percentage = (values[index] / maxValue) * 100;
					// Minimum 10% for visibility when value > 0
					const finalPercentage = values[index] > 0 ? Math.max(percentage, 10) : 0;
					bar.style.width = finalPercentage + '%';
				}
			});
		
			// Animar tarjetas de estadísticas
			gsap.from(statCards, {
				scale: 0.85,
				opacity: 0,
				duration: 0.9,
				stagger: 0.12,
				ease: 'back.out(1.4)',
				delay: 0.3
			});

			// Animar barras de estadísticas
			const statBars = document.querySelectorAll('[data-bar]');
			gsap.from(statBars, {
				scaleX: 0,
				transformOrigin: 'left center',
				duration: 1.2,
				stagger: 0.15,
				ease: 'power2.out',
				delay: 0.6
			});
		}

		// Animar tarjetas de pactos
		const pactCards = document.querySelectorAll('[data-pact-card]');
		if (pactCards.length > 0) {
			gsap.from(pactCards, { 
				y: 30, 
				opacity: 0, 
				stagger: 0.1, 
				duration: 0.8,
				ease: 'power3.out',
				delay: 0.7
			});
		}

		// Animate demon cards
		const demonCards = document.querySelectorAll('[data-demon-card]');
		if (demonCards.length > 0) {
			gsap.from(demonCards, { 
				y: 30, 
				opacity: 0, 
				stagger: 0.1, 
				duration: 0.8,
				ease: 'power3.out',
				delay: 0.8
			});
		}

		// Hero section animations
		const heroTitle = document.querySelector('.hero-title');
		if (heroTitle) {
			gsap.from(heroTitle.children, {
				y: -30,
				opacity: 0,
				duration: 1.2,
				stagger: 0.15,
				ease: 'power3.out'
			});
		}

		const heroSubtitle = document.querySelector('.hero-subtitle');
		if (heroSubtitle) {
			heroSubtitle.style.opacity = '1';
			heroSubtitle.style.visibility = 'visible';
			
			gsap.from(heroSubtitle, {
				y: 20,
				opacity: 0,
				duration: 0.8,
				ease: 'power2.out',
				delay: 0.2,
				clearProps: 'all'
			});
		}

		const heroDescription = document.querySelector('.hero-description');
		if (heroDescription) {
			heroDescription.style.opacity = '1';
			heroDescription.style.visibility = 'visible';
			
			gsap.from(heroDescription, {
				y: 20,
				opacity: 0,
				duration: 0.8,
				ease: 'power2.out',
				delay: 0.3,
				clearProps: 'all'
			});
		}

		const featurePills = document.querySelectorAll('.feature-pill');
		if (featurePills.length) {
			// Ensure pills are visible first
			featurePills.forEach(pill => {
				pill.style.opacity = '1';
				pill.style.visibility = 'visible';
			});
			
			gsap.from(featurePills, {
				scale: 0.8,
				opacity: 0,
				duration: 0.8,
				stagger: 0.1,
				ease: 'back.out(1.5)',
				delay: 0.4,
				clearProps: 'all'
			});
		}

		const ctaButtons = document.querySelectorAll('.cta-button');
		if (ctaButtons.length) {
			// Ensure buttons are visible first
			ctaButtons.forEach(btn => {
				btn.style.opacity = '1';
				btn.style.visibility = 'visible';
			});
			
			gsap.from(ctaButtons, {
				y: 20,
				opacity: 0,
				duration: 0.8,
				stagger: 0.1,
				ease: 'power2.out',
				delay: 0.6,
				clearProps: 'all'
			});
		}
		
		const statusBar = document.querySelector('.status-bar');
		if (statusBar) {
			statusBar.style.opacity = '1';
			statusBar.style.visibility = 'visible';
			
			gsap.from(statusBar, {
				y: 20,
				opacity: 0,
				duration: 0.8,
				ease: 'power2.out',
				delay: 0.7,
				clearProps: 'all'
			});
		}
	});
})();
