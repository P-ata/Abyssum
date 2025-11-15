// GSAP Animations para el carrito
// Solo efectos visuales, sin lógica de negocio

document.addEventListener('DOMContentLoaded', () => {
  // Animar entrada de items del carrito
  const cartItems = document.querySelectorAll('[data-cart-item]');
  
  if (cartItems.length > 0) {
    gsap.from(cartItems, {
      y: 30,
      opacity: 0,
      stagger: 0.1,
      duration: 0.6,
      ease: 'power3.out'
    });
  }

  // Animar contador del total
  const totalEl = document.querySelector('[data-cart-total]');
  
  if (totalEl) {
    const totalValue = parseInt(totalEl.textContent.replace(/[^0-9]/g, ''));
    
    if (totalValue > 0) {
      gsap.from(totalEl, {
        scale: 0.5,
        opacity: 0,
        duration: 0.8,
        ease: 'elastic.out(1, 0.5)',
        delay: 0.3
      });
    }
  }

  // Hover effects en cards de pactos expandibles
  const expandableCards = document.querySelectorAll('.expandable-card');
  
  expandableCards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      gsap.to(card, {
        scale: 1.05,
        duration: 0.3,
        ease: 'power2.out'
      });
    });

    card.addEventListener('mouseleave', () => {
      gsap.to(card, {
        scale: 1,
        duration: 0.3,
        ease: 'power2.out'
      });
    });
  });

  // Animar título principal con efecto glitch
  const mainTitle = document.querySelector('[data-main-title]');
  
  if (mainTitle) {
    gsap.from(mainTitle, {
      opacity: 0,
      y: -50,
      duration: 1,
      ease: 'power4.out'
    });
  }
});
