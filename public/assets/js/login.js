import { gsap } from 'gsap';

// Animar página de login
function animateLoginPage() {
  // Título
  gsap.from('h1', {
    y: -40,
    opacity: 0,
    scale: 0.9,
    duration: 0.8,
    ease: 'back.out(1.4)',
    clearProps: 'all'
  });

  // Subtítulo/instrucciones
  gsap.from('.text-center.mb-12 p', {
    y: -20,
    opacity: 0,
    duration: 0.6,
    delay: 0.2,
    ease: 'power2.out',
    clearProps: 'all'
  });

  // Contenedor del formulario
  const formContainer = document.querySelector('.max-w-md');
  if (formContainer) {
    gsap.from(formContainer, {
      y: 30,
      opacity: 0,
      duration: 0.7,
      delay: 0.3,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Campos del formulario
  const formFields = document.querySelectorAll('form > div');
  if (formFields.length) {
    gsap.from(formFields, {
      x: -20,
      opacity: 0,
      duration: 0.5,
      stagger: 0.1,
      delay: 0.5,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Botón submit
  const submitBtn = document.querySelector('button[type="submit"]');
  if (submitBtn) {
    gsap.from(submitBtn, {
      y: 20,
      opacity: 0,
      duration: 0.5,
      delay: 0.8,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Links
  const links = document.querySelector('.mt-8.text-center');
  if (links) {
    gsap.from(links, {
      opacity: 0,
      duration: 0.5,
      delay: 1,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }
}

// Ejecutar cuando el DOM esté listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', animateLoginPage);
} else {
  animateLoginPage();
}
