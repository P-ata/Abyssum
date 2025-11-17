import { gsap } from 'gsap';

document.addEventListener('DOMContentLoaded', () => {
  animateDemonDetail();
});

function animateDemonDetail() {
  // Animar botón volver
  gsap.from('.demon-back', {
    x: -30,
    opacity: 0,
    duration: 0.6,
    ease: 'power3.out'
  });

  // Animar imagen
  gsap.from('.demon-image', {
    x: -50,
    opacity: 0,
    duration: 0.8,
    delay: 0.2,
    ease: 'power3.out'
  });

  // Animar header (título y especie)
  gsap.from('.demon-header', {
    y: 30,
    opacity: 0,
    duration: 0.7,
    delay: 0.3,
    ease: 'power3.out'
  });

  // Animar aliases
  gsap.from('.demon-aliases', {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay: 0.4,
    ease: 'power2.out'
  });

  // Animar resumen
  gsap.from('.demon-summary', {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay: 0.5,
    ease: 'power2.out'
  });

  // Animar demographics
  gsap.from('.demon-demographics', {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay: 0.6,
    ease: 'power2.out'
  });

  // Animar lore
  gsap.from('.demon-lore', {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay: 0.7,
    ease: 'power2.out'
  });

  // Animar habilidades
  gsap.from('.demon-abilities', {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay: 0.8,
    ease: 'power2.out'
  });

  // Animar estadísticas
  gsap.from('.demon-stats', {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay: 0.9,
    ease: 'power2.out'
  });

  // Animar personalidad
  gsap.from('.demon-personality', {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay: 1.0,
    ease: 'power2.out'
  });

  // Animar debilidades
  gsap.from('.demon-weaknesses', {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay: 1.1,
    ease: 'power2.out'
  });

  // Animar botones de acción
  gsap.from('.demon-actions', {
    y: 30,
    opacity: 0,
    duration: 0.7,
    delay: 1.2,
    ease: 'back.out(1.4)'
  });
}
