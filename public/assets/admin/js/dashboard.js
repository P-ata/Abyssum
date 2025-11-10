import { gsap } from 'gsap';

// Optional JS enhancements for the dashboard
(() => {
	const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

	onReady(() => {
		// Entrance timeline (single run)
		const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
		tl.from('#dashTitle span', { y: 40, opacity: 0, stagger: 0.15, duration: 0.9 })
			.from('#quickStats [data-stat]', { y: 30, opacity: 0, stagger: 0.12, duration: 0.6 }, '-=0.5')
			.from('#toolbar', { y: 25, opacity: 0, duration: 0.5 }, '-=0.35')
			.from('#pactsGrid .pact-card', { y: 50, opacity: 0, stagger: 0.07, duration: 0.55 }, '-=0.25');

		// Ensure visible in any case
		document.querySelectorAll('.pact-card').forEach(el => {
			el.style.opacity = '1';
			el.style.transform = 'translateY(0)';
		});

		// Hover animations (idempotent)
		document.querySelectorAll('.pact-card').forEach(card => {
			card.addEventListener('mouseenter', () => gsap.to(card, { scale: 1.02, duration: 0.25, ease: 'power2.out' }));
			card.addEventListener('mouseleave', () => gsap.to(card, { scale: 1, duration: 0.3, ease: 'power2.out' }));
		});

		// Clear button
		const clearBtn = document.getElementById('clearBtn');
		if (clearBtn) {
			clearBtn.addEventListener('click', () => {
				const input = document.querySelector('input[placeholder*="buscar pacto"]');
				if (input) {
					input.value = '';
					gsap.fromTo(input, { opacity: 0.4 }, { opacity: 1, duration: 0.25 });
				}
			});
		}
	});
})();

