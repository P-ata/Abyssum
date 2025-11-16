import { gsap } from 'gsap';

document.addEventListener('DOMContentLoaded', () => {
  animateProfilePage();
});

function animateProfilePage() {
  // Título principal
  gsap.from('.profile-title h1', {
    y: -40,
    opacity: 0,
    scale: 0.9,
    duration: 0.8,
    ease: 'back.out(1.4)',
    clearProps: 'all'
  });

  // Subtítulo
  gsap.from('.profile-subtitle', {
    y: -20,
    opacity: 0,
    duration: 0.8,
    delay: 0.1,
    ease: 'power2.out',
    clearProps: 'all'
  });

  // Quick Actions (los dos botones superiores)
  const quickActions = document.querySelectorAll('.quick-action');
  if (quickActions.length) {
    gsap.from(quickActions, {
      scale: 0.9,
      opacity: 0,
      duration: 0.6,
      stagger: 0.1,
      delay: 0.2,
      ease: 'back.out(1.3)',
      clearProps: 'all'
    });
  }

  // Tarjeta de información
  gsap.from('.info-card', {
    y: 30,
    opacity: 0,
    duration: 0.7,
    delay: 0.4,
    ease: 'power3.out',
    clearProps: 'all'
  });

  // Items de información con stagger
  const infoItems = document.querySelectorAll('.info-item');
  if (infoItems.length) {
    gsap.from(infoItems, {
      x: -20,
      opacity: 0,
      duration: 0.5,
      stagger: 0.08,
      delay: 0.6,
      ease: 'power2.out',
      clearProps: 'all'
    });
  }

  // Formulario de actualizar perfil
  gsap.from('.update-form', {
    y: 30,
    opacity: 0,
    duration: 0.7,
    delay: 0.8,
    ease: 'power3.out',
    clearProps: 'all'
  });

  // Formulario de cambiar contraseña
  gsap.from('.password-form', {
    y: 30,
    opacity: 0,
    duration: 0.7,
    delay: 0.9,
    ease: 'power3.out',
    clearProps: 'all'
  });

  // Botón de logout
  gsap.from('.logout-button', {
    scale: 0.9,
    opacity: 0,
    duration: 0.6,
    delay: 1.0,
    ease: 'back.out(1.3)',
    clearProps: 'all'
  });
}
