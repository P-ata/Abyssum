/**
 * Header animations and interactions
 * Handles menu toggle, burger animation, and demons carousel expansion
 */

document.addEventListener('DOMContentLoaded', function() {
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const overlay = document.getElementById('overlay');
  const closeBtn = document.querySelector('[data-action="close-menu"]');
  
  if (!menuBtn || !mobileMenu || !overlay) return;
  
  const topBar = menuBtn.querySelector('.bar-top');
  const midBar = menuBtn.querySelector('.bar-mid');
  const botBar = menuBtn.querySelector('.bar-bot');
  
  // Establecer estado inicial del menú
  gsap.set(mobileMenu, { x: '-120%' });
  gsap.set(overlay, { opacity: 0, pointerEvents: 'none' });
  
  // NO usar gsap.set en las barras para que mantengan su CSS original
  // Solo vamos a animar con x en lugar de xPercent para evitar conflictos
  
  /**
   * Open menu with animations
   */
  function openMenu() {
    // Animate menu slide-in
    gsap.to(mobileMenu, {
      x: 0,
      duration: 0.5,
      ease: 'power3.out'
    });
    
    // Animate overlay fade-in
    gsap.to(overlay, {
      opacity: 1,
      duration: 0.3,
      onStart: () => {
        overlay.style.pointerEvents = 'auto';
      }
    });
    
    // Las barras se esconden hacia la derecha más rápido y con fade
    gsap.to(topBar, {
      x: 50,
      opacity: 0,
      duration: 0.1,
      ease: 'power2.in',
      force3D: false
    });
    
    gsap.to(midBar, {
      x: 50,
      opacity: 0,
      duration: 0.1,
      delay: 0.015,
      ease: 'power2.in',
      force3D: false
    });
    
    gsap.to(botBar, {
      x: 50,
      opacity: 0,
      duration: 0.1,
      delay: 0.03,
      ease: 'power2.in',
      force3D: false
    });
    
    // Quitar el focus del botón después de un tiempo
    setTimeout(() => {
      menuBtn.blur();
    }, 300);
    
    menuBtn.setAttribute('aria-expanded', 'true');
  }
  
  /**
   * Close menu with animations
   */
  function closeMenu() {
    // Animate menu slide-out
    gsap.to(mobileMenu, {
      x: '-120%',
      duration: 0.4,
      ease: 'power3.in'
    });
    
    // Animate overlay fade-out
    gsap.to(overlay, {
      opacity: 0,
      duration: 0.3,
      onComplete: () => {
        overlay.style.pointerEvents = 'none';
      }
    });
    
    // Las barras vuelven desde la derecha y aparecen (más lento)
    gsap.fromTo(topBar, 
      { x: 50, opacity: 0 },
      {
        x: 0,
        opacity: 1,
        duration: 0.4,
        ease: 'back.out(1.5)',
        force3D: false,
        clearProps: 'transform',
        onComplete: () => {
          gsap.set(topBar, { clearProps: 'all' });
        }
      }
    );
    
    gsap.fromTo(midBar,
      { x: 50, opacity: 0 },
      {
        x: 0,
        opacity: 1,
        duration: 0.4,
        delay: 0.08,
        ease: 'back.out(1.5)',
        force3D: false,
        clearProps: 'transform',
        onComplete: () => {
          gsap.set(midBar, { clearProps: 'all' });
        }
      }
    );
    
    gsap.fromTo(botBar,
      { x: 50, opacity: 0 },
      {
        x: 0,
        opacity: 1,
        duration: 0.4,
        delay: 0.16,
        ease: 'back.out(1.5)',
        force3D: false,
        clearProps: 'transform',
        onComplete: () => {
          gsap.set(botBar, { clearProps: 'all' });
        }
      }
    );
    
    menuBtn.setAttribute('aria-expanded', 'false');
  }
  
  /**
   * Toggle menu state
   */
  function toggleMenu() {
    const isOpen = menuBtn.getAttribute('aria-expanded') === 'true';
    isOpen ? closeMenu() : openMenu();
  }
  
  // Event listeners
  menuBtn.addEventListener('click', toggleMenu);
  closeBtn?.addEventListener('click', closeMenu);
  overlay.addEventListener('click', closeMenu);
  
  // Close menu with ESC key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && menuBtn.getAttribute('aria-expanded') === 'true') {
      closeMenu();
    }
  });
  
  // Demons carousel expansion effect
  initDemonsCarousel();
});

/**
 * Initialize demons carousel with expansion animations
 */
function initDemonsCarousel() {
  const demonsContainer = document.getElementById('demonsContainer');
  const demonItems = document.querySelectorAll('.demon-item');
  const totalItems = demonItems.length;
  
  if (!demonsContainer || totalItems === 0) return;
  
  demonItems.forEach((item, index) => {
    item.addEventListener('mouseenter', () => {
      expandDemon(index, demonItems, totalItems);
    });
  });
  
  // Reset on mouse leave
  demonsContainer.addEventListener('mouseleave', () => {
    resetDemons(demonItems, totalItems);
  });
}

/**
 * Expand a specific demon item
 */
function expandDemon(activeIndex, demonItems, totalItems) {
  const expandedWidth = 50; // Active item takes 50%
  const collapsedWidth = (100 - expandedWidth) / (totalItems - 1); // Others share remaining space
  
  demonItems.forEach((item, index) => {
    if (index === activeIndex) {
      // Expand active item
      const expandedLeft = collapsedWidth * index;
      
      gsap.to(item, {
        left: expandedLeft + '%',
        width: expandedWidth + '%',
        duration: 0.5,
        ease: 'power2.out'
      });
      
      gsap.to(item.querySelector('.demon-name'), {
        opacity: 1,
        scale: 1.15,
        duration: 0.3
      });
    } else {
      // Collapse other items
      let newLeft = 0;
      if (index < activeIndex) {
        newLeft = index * collapsedWidth;
      } else {
        newLeft = (collapsedWidth * activeIndex) + expandedWidth + (index - activeIndex - 1) * collapsedWidth;
      }
      
      gsap.to(item, {
        left: newLeft + '%',
        width: collapsedWidth + '%',
        duration: 0.5,
        ease: 'power2.out'
      });
      
      gsap.to(item.querySelector('.demon-name'), {
        opacity: 0.5,
        scale: 0.85,
        duration: 0.3
      });
    }
  });
}

/**
 * Reset all demons to equal width
 */
function resetDemons(demonItems, totalItems) {
  const normalWidth = 100 / totalItems;
  
  demonItems.forEach((item, index) => {
    gsap.to(item, {
      left: index * normalWidth + '%',
      width: normalWidth + '%',
      duration: 0.5,
      ease: 'power2.out'
    });
    
    gsap.to(item.querySelector('.demon-name'), {
      opacity: 1,
      scale: 1,
      duration: 0.3
    });
  });
}
