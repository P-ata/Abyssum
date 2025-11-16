import { gsap } from 'gsap';

document.addEventListener('DOMContentLoaded', () => {
  animateOrdersPage();
});

function animateOrdersPage() {
  // Título principal
  gsap.from('.orders-title h1', {
    y: -40,
    opacity: 0,
    scale: 0.9,
    duration: 0.8,
    ease: 'back.out(1.4)',
    clearProps: 'all'
  });

  // Subtítulo
  gsap.from('.orders-subtitle', {
    y: -20,
    opacity: 0,
    duration: 0.6,
    delay: 0.2,
    ease: 'power2.out',
    clearProps: 'all'
  });

  // Botón volver
  gsap.from('.back-button', {
    x: -30,
    opacity: 0,
    duration: 0.6,
    delay: 0.3,
    ease: 'power2.out',
    clearProps: 'all'
  });

  // Estado vacío
  const emptyState = document.querySelector('.empty-state');
  if (emptyState) {
    gsap.from(emptyState, {
      scale: 0.9,
      opacity: 0,
      duration: 0.8,
      delay: 0.5,
      ease: 'back.out(1.2)',
      clearProps: 'all'
    });
  }

  // Tarjetas de órdenes
  const orderCards = document.querySelectorAll('.order-card');
  if (orderCards.length) {
    gsap.from(orderCards, {
      y: 40,
      opacity: 0,
      duration: 0.6,
      stagger: 0.15,
      delay: 0.4,
      ease: 'power2.out',
      clearProps: 'all'
    });

    // Animar items dentro de cada orden
    orderCards.forEach((card, index) => {
      const items = card.querySelectorAll('.order-item');
      if (items.length) {
        gsap.from(items, {
          x: -20,
          opacity: 0,
          duration: 0.4,
          stagger: 0.08,
          delay: 0.6 + (index * 0.15),
          ease: 'power2.out',
          clearProps: 'all'
        });
      }
    });
  }
}
