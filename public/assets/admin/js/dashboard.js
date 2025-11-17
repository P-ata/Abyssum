import { gsap } from 'gsap';

// Mejoras JavaScript opcionales para el dashboard
(() => {
	const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

	onReady(() => {
		// Animar título con desfase
		const title = document.getElementById('dashTitle');
		if (title && title.children.length) {
			gsap.from(title.children, {
				y: -30,
				opacity: 0,
				duration: 1.2,
				stagger: 0.15,
				ease: 'power3.out'
			});
		} else if (title) {
			gsap.from(title, { y: 20, opacity: 0, duration: 0.6, ease: 'power3.out' });
		}

		// Animar tarjetas de estadísticas
		const statCards = document.querySelectorAll('[data-stat]');
		if (statCards.length) {
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

		// Animar barra de herramientas
		const toolbar = document.getElementById('toolbar');
		if (toolbar) {
			gsap.from(toolbar, {
				y: -20,
				opacity: 0,
				duration: 0.8,
				ease: 'power2.out',
				delay: 0.5
			});
		}

		// Las tarjetas se animan automáticamente
		
		// Animar entrada de tarjetas de pactos
		const pactCards = document.querySelectorAll('#pactsGrid .pact-card');
		if (pactCards.length > 0) {
			gsap.from(pactCards, { 
				y: 50, 
				opacity: 0, 
				stagger: 0.08, 
				duration: 0.9,
				ease: 'power3.out',
				delay: 0.7,
				clearProps: 'all',
			onComplete: () => {
				// Reactivar efectos hover al completarse
				pactCards.forEach(card => card.classList.add('animation-complete'));
				}
			});
		}

		// Animar entrada de tarjetas de demonios
		const demonCards = document.querySelectorAll('.demon-card');
		if (demonCards.length > 0) {
			gsap.from(demonCards, { 
				y: 50, 
				opacity: 0, 
				stagger: 0.08, 
				duration: 0.9,
				ease: 'power3.out',
				delay: 0.7,
				clearProps: 'all',
			onComplete: () => {
				// Reactivar efectos hover al completarse
				demonCards.forEach(card => card.classList.add('animation-complete'));
				}
			});
		}

		// Animar filas de la tabla de usuarios
		const userRows = document.querySelectorAll('.user-row');
		if (userRows.length > 0) {
			gsap.from(userRows, {
				x: -30,
				opacity: 0,
				stagger: 0.05,
				duration: 0.7,
				ease: 'power3.out',
				delay: 0.7,
				clearProps: 'all'
			});
		}

		// Animar contenedor de tabla de usuarios
		const usersTable = document.getElementById('usersTable');
		if (usersTable) {
			gsap.from(usersTable, {
				y: 30,
				opacity: 0,
				duration: 0.8,
				ease: 'power3.out',
				delay: 0.5
			});
		}

		// Animar tarjetas de órdenes
		const orderCards = document.querySelectorAll('.order-card');
		if (orderCards.length > 0) {
			gsap.from(orderCards, {
				y: 50,
				opacity: 0,
				stagger: 0.1,
				duration: 0.8,
				ease: 'power3.out',
				delay: 0.7,
				clearProps: 'all'
			});
		}

		// Animar tarjetas de contactos
		const contactCards = document.querySelectorAll('.contact-card');
		if (contactCards.length > 0) {
			gsap.from(contactCards, {
				y: 50,
				opacity: 0,
				stagger: 0.1,
				duration: 0.8,
				ease: 'power3.out',
				delay: 0.7,
				clearProps: 'all'
			});
		}

		// Animar botones de filtro
		const filterButtons = document.getElementById('filterButtons');
		if (filterButtons && filterButtons.children.length) {
			gsap.from(filterButtons.children, {
				scale: 0.8,
				opacity: 0,
				stagger: 0.08,
				duration: 0.6,
				ease: 'back.out(1.5)',
				delay: 0.5,
				clearProps: 'all'
			});
		}

		// Animar tarjetas de salud
		const healthCards = document.querySelectorAll('.health-card');
		if (healthCards.length > 0) {
			gsap.from(healthCards, {
				y: 40,
				opacity: 0,
				stagger: 0.15,
				duration: 0.8,
				ease: 'power3.out',
				delay: 0.6,
				clearProps: 'all'
			});
		}

		// Animaciones en hover - Solo para tarjetas que finalizaron
		document.addEventListener('mouseenter', (e) => {
			const card = e.target.closest('.pact-card, .demon-card');
			if (card && card.classList.contains('animation-complete')) {
				gsap.to(card, { scale: 1.02, duration: 0.25, ease: 'power2.out', overwrite: true });
			}
		}, true);
		
		document.addEventListener('mouseleave', (e) => {
			const card = e.target.closest('.pact-card, .demon-card');
			if (card && card.classList.contains('animation-complete')) {
				gsap.to(card, { scale: 1, duration: 0.3, ease: 'power2.out', overwrite: true });
			}
		}, true);

		// Funcionalidad del botón limpiar
		const clearBtn = document.getElementById('clearBtn');
		if (clearBtn) {
			clearBtn.addEventListener('click', () => {
				const searchInput = document.querySelector('input[type="text"]');
				if (searchInput) searchInput.value = '';
			});
		}
	});
})();