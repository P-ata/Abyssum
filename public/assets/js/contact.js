import { gsap } from 'gsap';

document.addEventListener('DOMContentLoaded', () => {
  animateContactPage();
  initFormAnimations();
});

function animateContactPage() {
  // Título principal
  gsap.from('.contact-title h1', {
    y: -40,
    opacity: 0,
    scale: 0.9,
    duration: 0.8,
    ease: 'back.out(1.4)'
  });

  // Subtítulo
  gsap.from('.contact-subtitle', {
    y: -20,
    opacity: 0,
    duration: 0.8,
    delay: 0.1,
    ease: 'power2.out'
  });

  // Formulario (slide desde la izquierda)
  gsap.from('.contact-form', {
    x: -40,
    opacity: 0,
    duration: 0.8,
    delay: 0.2,
    ease: 'power3.out'
  });

  // Panel de información (slide desde la derecha)
  gsap.from('.contact-info', {
    x: 40,
    opacity: 0,
    duration: 0.8,
    delay: 0.3,
    ease: 'power3.out'
  });

  // Campos del formulario con stagger
  gsap.from('.form-field', {
    y: 20,
    opacity: 0,
    duration: 0.5,
    stagger: 0.08,
    delay: 0.5,
    ease: 'power2.out'
  });

  // Botones del formulario
  gsap.from('.form-buttons', {
    y: 20,
    opacity: 0,
    scale: 0.95,
    duration: 0.6,
    delay: 0.9,
    ease: 'back.out(1.2)'
  });
}

function initFormAnimations() {
  const inputs = document.querySelectorAll('input, textarea');
  
  inputs.forEach(input => {
    // Efecto de foco
    input.addEventListener('focus', function() {
      gsap.to(this, {
        scale: 1.01,
        duration: 0.2,
        ease: 'power2.out'
      });
      
      // Brillo en el label
      const label = this.previousElementSibling;
      if (label && label.tagName === 'LABEL') {
        gsap.to(label, {
          color: '#f59e0b',
          duration: 0.2,
          ease: 'power2.out'
        });
      }
    });

    input.addEventListener('blur', function() {
      gsap.to(this, {
        scale: 1,
        duration: 0.2,
        ease: 'power2.out'
      });
      
      // Restaurar label
      const label = this.previousElementSibling;
      if (label && label.tagName === 'LABEL') {
        gsap.to(label, {
          color: '#f59e0b',
          duration: 0.2,
          ease: 'power2.out'
        });
      }
    });
  });

  // Animación del botón de enviar
  const submitBtn = document.querySelector('button[type="submit"]');
  if (submitBtn) {
    submitBtn.addEventListener('mouseenter', function() {
      gsap.to(this, {
        scale: 1.02,
        duration: 0.3,
        ease: 'back.out(1.4)'
      });
    });

    submitBtn.addEventListener('mouseleave', function() {
      gsap.to(this, {
        scale: 1,
        duration: 0.3,
        ease: 'power2.out'
      });
    });
  }
}
