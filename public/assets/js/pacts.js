import { gsap } from 'gsap';

// Inicializar las cards cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  initPactCards();
  animatePageElements();
  initSelectArrows();
});

function initSelectArrows() {
  const selects = document.querySelectorAll('.filter-item select');
  
  selects.forEach(select => {
    const arrow = select.parentElement.querySelector('.fa-chevron-down');
    
    if (!arrow) return;
    
    // Detectar cuando se abre el select
    select.addEventListener('mousedown', () => {
      arrow.classList.add('rotate-180');
    });
    
    // Detectar cuando se cierra el select
    select.addEventListener('blur', () => {
      arrow.classList.remove('rotate-180');
    });
    
    select.addEventListener('change', () => {
      arrow.classList.remove('rotate-180');
    });
  });
}

function animatePageElements() {
  // Animar título
  gsap.from('.pacts-title h1', {
    y: -40,
    opacity: 0,
    scale: 0.9,
    duration: 0.8,
    ease: 'back.out(1.4)'
  });

  // Animar instrucciones superiores
  gsap.from('.pacts-instructions', {
    y: -20,
    opacity: 0,
    duration: 0.8,
    delay: 0.1,
    ease: 'power3.out'
  });

  // Animar buscador
  gsap.from('.search-container', {
    y: -20,
    opacity: 0,
    duration: 0.7,
    delay: 0.2,
    ease: 'power3.out'
  });

  // Animar contenedor de filtros
  gsap.from('.filters-container', {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.1,
    ease: 'power3.out'
  });

  // Animar cada filtro individualmente
  gsap.from('.filter-item', {
    x: -20,
    opacity: 0,
    duration: 0.5,
    stagger: 0.1,
    delay: 0.3,
    ease: 'power2.out'
  });

  // Animar botones de filtro
  gsap.from('.filter-buttons', {
    scale: 0.9,
    opacity: 0,
    duration: 0.5,
    delay: 0.6,
    ease: 'back.out(1.4)'
  });
}

function initPactCards() {
  // Inicializar las expandable cards
  initExpandableCards();

  // Animar las cards con efecto de cascada mejorado
  const cards = document.querySelectorAll('.expandable-card-container');
  
  gsap.from(cards, {
    y: 60,
    opacity: 0,
    scale: 0.9,
    rotation: 2,
    duration: 0.8,
    stagger: {
      amount: 0.8,
      from: 'start',
      ease: 'power2.out'
    },
    ease: 'back.out(1.2)',
    delay: 0.8,
    clearProps: 'all'
  });
}

function initExpandableCards() {
  const cards = document.querySelectorAll('.expandable-card');
  
  cards.forEach(card => {
    const container = card.closest('.expandable-card-container');
    const cardInfo = card.querySelector('.card-info');
    const panels = {
      left: card.querySelector('.menu-left'),
      right: card.querySelector('.menu-right'),
      top: card.querySelector('.menu-top'),
      bottom: card.querySelector('.menu-bottom')
    };

    let hoverTimeout = null;
    let isHovering = false;
    let isMouseInside = false;

    // Configuración inicial
    gsap.set([panels.left, panels.right, panels.top, panels.bottom], {
      opacity: 0
    });
    
    // Desactivar pointer events inicialmente
    [panels.left, panels.right, panels.top, panels.bottom].forEach(panel => {
      if (panel) panel.style.pointerEvents = 'none';
    });

    // Configurar estado inicial visible para las cards (sin animación de entrada individual)
    gsap.set(card, {
      clearProps: 'all'
    });

    // Hover deshabilitado - no expandir paneles
    card.addEventListener('mouseenter', (e) => {
      // Verificar que el mouse realmente está sobre esta card
      const rect = card.getBoundingClientRect();
      const x = e.clientX;
      const y = e.clientY;
      
      if (x < rect.left || x > rect.right || y < rect.top || y > rect.bottom) {
        return;
      }
      
      isHovering = true;
      isMouseInside = true;
      
      // Efecto de escala en hover
      gsap.to(container, {
        scale: 1.05,
        duration: 0.3,
        ease: 'power2.out'
      });
      
      // Esperar 50ms antes de abrir
      hoverTimeout = setTimeout(() => {
        if (!isHovering || !isMouseInside) return;
        
        // Matar cualquier animación previa en los paneles
        gsap.killTweensOf([panels.left, panels.right, panels.top, panels.bottom, cardInfo]);
        
        // Activar pointer events
        [panels.left, panels.right, panels.top, panels.bottom].forEach(panel => {
          if (panel) panel.style.pointerEvents = 'auto';
        });
        
        // Ocultar card-info inmediatamente
        gsap.to(cardInfo, {
          opacity: 0,
          duration: 0.2,
          ease: 'power2.out'
        });

        // Panel izquierdo
        gsap.to(panels.left, {
          x: 0,
          opacity: 1,
          duration: 0.3,
          ease: 'power3.out',
          delay: 0
        });

        // Panel derecho
        gsap.to(panels.right, {
          x: 0,
          opacity: 1,
          duration: 0.3,
          ease: 'power3.out',
          delay: 0.05
        });

        // Panel superior
        gsap.to(panels.top, {
          y: 0,
          opacity: 1,
          duration: 0.3,
          ease: 'power3.out',
          delay: 0.1
        });

        // Panel inferior
        gsap.to(panels.bottom, {
          y: 0,
          opacity: 1,
          duration: 0.3,
          ease: 'power3.out',
          delay: 0.15
        });

        // REMOVIDO: Efecto de escala en la imagen
      }, 51);
    });

    // Mouse leave deshabilitado
    card.addEventListener('mouseleave', (e) => {
      isHovering = false;
      isMouseInside = false;
      
      // Cancelar timeout si sale antes de los 200ms
      if (hoverTimeout) {
        clearTimeout(hoverTimeout);
        hoverTimeout = null;
      }
      
      // Volver a escala normal
      gsap.to(container, {
        scale: 1,
        duration: 0.3,
        ease: 'power2.out'
      });
      
      // Matar cualquier animación activa inmediatamente
      gsap.killTweensOf([panels.left, panels.right, panels.top, panels.bottom, cardInfo]);
      
      // Desactivar pointer events inmediatamente
      [panels.left, panels.right, panels.top, panels.bottom].forEach(panel => {
        if (panel) panel.style.pointerEvents = 'none';
      });
      
      // Mostrar card-info con delay de 0.7s
      gsap.to(cardInfo, {
        opacity: 1,
        duration: 0.15,
        delay: 0.7,
        ease: 'power2.out'
      });

      gsap.to(panels.left, {
        x: -150,
        opacity: 0,
        duration: 0.3,
        ease: 'power2.in'
      });

      gsap.to(panels.right, {
        x: 150,
        opacity: 0,
        duration: 0.3,
        ease: 'power2.in'
      });

      gsap.to(panels.top, {
        y: -100,
        opacity: 0,
        duration: 0.3,
        ease: 'power2.in'
      });

      gsap.to(panels.bottom, {
        y: 100,
        opacity: 0,
        duration: 0.3,
        ease: 'power2.in'
      });

      // REMOVIDO: Efecto de escala en la imagen
    });
  });
}

export { initPactCards };