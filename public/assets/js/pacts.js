import { gsap } from 'gsap';

// Inicializar las cards cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  initPactCards();
});

function initPactCards() {
  // Inicializar las expandable cards
  initExpandableCards();

  // Animaciones de texto
  gsap.from('h1', {
    opacity: 0,
    y: -30,
    duration: 1,
    ease: 'power3.out'
  });

  gsap.from('h1 + p', {
    opacity: 0,
    y: -20,
    duration: 1,
    delay: 0.2,
    ease: 'power3.out'
  });
  
  gsap.from('h1 + p + p', {
    opacity: 0,
    y: -20,
    duration: 1,
    delay: 0.3,
    ease: 'power3.out'
  });
}

function initExpandableCards() {
  const cards = document.querySelectorAll('.expandable-card');
  
  cards.forEach(card => {
    const panels = {
      left: card.querySelector('.menu-left'),
      right: card.querySelector('.menu-right'),
      top: card.querySelector('.menu-top'),
      bottom: card.querySelector('.menu-bottom')
    };

    let hoverTimeout = null;
    let isHovering = false;

    // Configuración inicial
    gsap.set([panels.left, panels.right, panels.top, panels.bottom], {
      opacity: 0
    });

    // Animación de entrada
    gsap.from(card, {
      opacity: 0,
      scale: 0.8,
      duration: 1,
      ease: 'back.out(1.7)',
      delay: 0.4
    });

    // Hover: expandir paneles con delay
    card.addEventListener('mouseenter', () => {
      isHovering = true;
      
      // Esperar 200ms antes de abrir
      hoverTimeout = setTimeout(() => {
        if (!isHovering) return;

        // Panel izquierdo
        gsap.to(panels.left, {
          x: 0,
          opacity: 1,
          duration: 0.5,
          ease: 'power3.out',
          delay: 0
        });

        // Panel derecho
        gsap.to(panels.right, {
          x: 0,
          opacity: 1,
          duration: 0.5,
          ease: 'power3.out',
          delay: 0.1
        });

        // Panel superior
        gsap.to(panels.top, {
          y: 0,
          opacity: 1,
          duration: 0.5,
          ease: 'power3.out',
          delay: 0.2
        });

        // Panel inferior
        gsap.to(panels.bottom, {
          y: 0,
          opacity: 1,
          duration: 0.5,
          ease: 'power3.out',
          delay: 0.3
        });

        // Efecto de brillo en la imagen
        gsap.to(card.querySelector('.card-image'), {
          scale: 1.05,
          duration: 0.5,
          ease: 'power2.out'
        });
      }, 201);
    });

    // Mouse leave: contraer paneles
    card.addEventListener('mouseleave', () => {
      isHovering = false;
      
      // Cancelar timeout si sale antes de los 200ms
      if (hoverTimeout) {
        clearTimeout(hoverTimeout);
        hoverTimeout = null;
      }

      gsap.to(panels.left, {
        x: -150,
        opacity: 0,
        duration: 0.4,
        ease: 'power2.in'
      });

      gsap.to(panels.right, {
        x: 150,
        opacity: 0,
        duration: 0.4,
        ease: 'power2.in'
      });

      gsap.to(panels.top, {
        y: -100,
        opacity: 0,
        duration: 0.4,
        ease: 'power2.in'
      });

      gsap.to(panels.bottom, {
        y: 100,
        opacity: 0,
        duration: 0.4,
        ease: 'power2.in'
      });

      gsap.to(card.querySelector('.card-image'), {
        scale: 1,
        duration: 0.4,
        ease: 'power2.out'
      });
    });
  });
}

export { initPactCards };