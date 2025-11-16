import { gsap } from 'gsap';

// Animar página de detalle de pacto
function animatePactDetailPage() {
  // Botón volver
  const backBtn = document.querySelector('.pact-back');
  if (backBtn) {
    gsap.from(backBtn, {
      x: -30,
      opacity: 0,
      duration: 0.6,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Imagen
  const image = document.querySelector('.pact-image');
  if (image) {
    gsap.from(image, {
      x: -40,
      opacity: 0,
      duration: 0.8,
      delay: 0.2,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Header (título y demonio)
  const header = document.querySelector('.pact-header');
  if (header) {
    gsap.from(header, {
      y: -30,
      opacity: 0,
      duration: 0.7,
      delay: 0.3,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Categorías
  const categories = document.querySelector('.pact-categories');
  if (categories) {
    gsap.from(categories, {
      x: 20,
      opacity: 0,
      duration: 0.6,
      delay: 0.5,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Resumen
  const summary = document.querySelector('.pact-summary');
  if (summary) {
    gsap.from(summary, {
      y: 20,
      opacity: 0,
      duration: 0.6,
      delay: 0.6,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Detalles técnicos (boxes)
  const details = document.querySelectorAll('.pact-details > div');
  if (details.length) {
    gsap.from(details, {
      scale: 0.9,
      opacity: 0,
      duration: 0.5,
      stagger: 0.1,
      delay: 0.7,
      ease: 'back.out(1.2)',
      clearProps: 'all'
    });
  }

  // Limitaciones
  const limitations = document.querySelector('.pact-limitations');
  if (limitations) {
    gsap.from(limitations, {
      y: 20,
      opacity: 0,
      duration: 0.6,
      delay: 1,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Botones de acción
  const actions = document.querySelector('.pact-actions');
  if (actions) {
    gsap.from(actions, {
      y: 30,
      opacity: 0,
      duration: 0.6,
      delay: 1.2,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }
}

// Ejecutar cuando el DOM esté listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', animatePactDetailPage);
} else {
  animatePactDetailPage();
}
