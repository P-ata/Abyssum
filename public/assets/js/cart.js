import { gsap } from 'gsap';

document.addEventListener('DOMContentLoaded', () => {
  animateCartPage();
});

function animateCartPage() {
  // Título principal
  gsap.from('.cart-title h1', {
    y: -40,
    opacity: 0,
    scale: 0.9,
    duration: 0.8,
    ease: 'back.out(1.4)',
    clearProps: 'all'
  });

  // Subtítulo
  gsap.from('.cart-subtitle', {
    y: -20,
    opacity: 0,
    duration: 0.6,
    delay: 0.2,
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
      delay: 0.4,
      ease: 'back.out(1.2)',
      clearProps: 'all'
    });
  }

  // Contenedor de pactos (si existe)
  const cartContainer = document.querySelector('.cart-container');
  if (cartContainer) {
    gsap.from(cartContainer, {
      y: 30,
      opacity: 0,
      duration: 0.7,
      delay: 0.3,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Items del carrito
  const cartItems = document.querySelectorAll('.cart-item');
  if (cartItems.length) {
    gsap.from(cartItems, {
      x: -30,
      opacity: 0,
      duration: 0.6,
      stagger: 0.1,
      delay: 0.3,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Total (si existe)
  const cartTotal = document.querySelector('.cart-total');
  if (cartTotal) {
    gsap.from(cartTotal.parentElement.parentElement, {
      y: 30,
      opacity: 0,
      duration: 0.7,
      delay: 0.5 + (cartItems.length * 0.1),
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Botones de acción
  const actionButtons = document.querySelectorAll('.cart-actions > *');
  if (actionButtons.length) {
    gsap.from(actionButtons, {
      y: 20,
      opacity: 0,
      duration: 0.5,
      stagger: 0.1,
      delay: 0.6 + (cartItems.length * 0.1),
      ease: 'power2.out',
      clearProps: 'all'
    });
  }
}
