import { gsap } from 'gsap';

// Optional JS enhancements for the dashboard
(() => {
	const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

	onReady(() => {
		// Title animation with stagger
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

		// Stats cards animation
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

			// Animate stat bars
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

		// Toolbar animation
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

		// Ensure all cards are visible (fallback)
		document.querySelectorAll('.pact-card').forEach(el => {
			el.style.opacity = '1';
			el.style.transform = 'translateY(0)';
		});

		// Animate pact cards entrance
		const pactCards = document.querySelectorAll('#pactsGrid .pact-card');
		if (pactCards.length > 0) {
			gsap.from(pactCards, { 
				y: 50, 
				opacity: 0, 
				stagger: 0.08, 
				duration: 0.9,
				ease: 'power3.out',
				delay: 0.7,
				clearProps: 'all' // Clear inline styles after animation
			});
		}

		// Hover animations (idempotent)
		document.querySelectorAll('.pact-card').forEach(card => {
			card.addEventListener('mouseenter', () => gsap.to(card, { scale: 1.02, duration: 0.25, ease: 'power2.out' }));
			card.addEventListener('mouseleave', () => gsap.to(card, { scale: 1, duration: 0.3, ease: 'power2.out' }));
		});

		// Clear button functionality
		const clearBtn = document.getElementById('clearBtn');
		if (clearBtn) {
			clearBtn.addEventListener('click', () => {
				const searchInput = document.querySelector('input[type="text"]');
				if (searchInput) searchInput.value = '';
			});
		}
	});
})();