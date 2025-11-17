import { gsap } from 'gsap';

// Inicializar animaciones cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  animatePageElements();
});

function animatePageElements() {
  // Título principal con la misma animación que demons/pacts
  gsap.from('.text-5xl.sm\\:text-6xl', {
    y: -40,
    opacity: 0,
    scale: 0.9,
    duration: 0.8,
    ease: 'back.out(1.4)'
  });

  // Subtítulo del título
  gsap.from('.text-amber-600\\/70.text-sm', {
    duration: 0.8,
    opacity: 0,
    y: -20,
    delay: 0.1,
    ease: 'power3.out'
  });

  // Foto del sellador con fade y scale
  gsap.from('.lg\\:col-span-2 > div', {
    duration: 1,
    opacity: 0,
    scale: 0.95,
    delay: 0.3,
    ease: 'power2.out'
  });

  // Secciones del contenido (bio) con stagger
  gsap.from('.lg\\:col-span-3 > section, .lg\\:col-span-3 > div', {
    duration: 0.8,
    opacity: 0,
    y: 30,
    stagger: 0.15,
    delay: 0.5,
    ease: 'power2.out'
  });

  // Pulso sutil en los botones CTA
  gsap.to('.flex.gap-3 a', {
    scale: 1.02,
    duration: 2,
    ease: 'sine.inOut',
    yoyo: true,
    repeat: -1,
    stagger: 0.3
  });
}
