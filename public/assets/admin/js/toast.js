/**
 * Toast notification system with GSAP animations
 * Toasts slide up from bottom center and auto-dismiss
 */

(function() {
  'use strict';
  
  if (window.toastSystemInitialized) {
    return;
  }
  window.toastSystemInitialized = true;

  const TOAST_CONFIG = {
    success: {
      bgClass: 'bg-green-100 dark:bg-green-900',
      borderClass: 'border-l-4 border-green-500 dark:border-green-700',
      textClass: 'text-green-900 dark:text-green-100',
      iconClass: 'text-green-600',
      hoverClass: 'hover:bg-green-200 dark:hover:bg-green-800',
      icon: `<svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-5 w-5 flex-shrink-0 mr-2" xmlns="http://www.w3.org/2000/svg">
        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
      </svg>`
    },
    error: {
      bgClass: 'bg-red-100 dark:bg-red-900',
      borderClass: 'border-l-4 border-red-500 dark:border-red-700',
      textClass: 'text-red-900 dark:text-red-100',
      iconClass: 'text-red-600',
      hoverClass: 'hover:bg-red-200 dark:hover:bg-red-800',
      icon: `<svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-5 w-5 flex-shrink-0 mr-2" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
      </svg>`
    },
    warning: {
      bgClass: 'bg-yellow-100 dark:bg-yellow-900',
      borderClass: 'border-l-4 border-yellow-500 dark:border-yellow-700',
      textClass: 'text-yellow-900 dark:text-yellow-100',
      iconClass: 'text-yellow-600',
      hoverClass: 'hover:bg-yellow-200 dark:hover:bg-yellow-800',
      icon: `<svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-5 w-5 flex-shrink-0 mr-2" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
      </svg>`
    },
    info: {
      bgClass: 'bg-blue-100 dark:bg-blue-900',
      borderClass: 'border-l-4 border-blue-500 dark:border-blue-700',
      textClass: 'text-blue-900 dark:text-blue-100',
      iconClass: 'text-blue-600',
      hoverClass: 'hover:bg-blue-200 dark:hover:bg-blue-800',
      icon: `<svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-5 w-5 flex-shrink-0 mr-2" xmlns="http://www.w3.org/2000/svg">
        <path d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
      </svg>`
    }
  };

  const TOAST_DURATION = 4000;
  const ANIMATION_DURATION = 0.5;

  function getToastContainer() {
    let container = document.getElementById('toast-container');
    
    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      container.style.cssText = 'position: fixed; bottom: 2rem; left: 50%; transform: translateX(-50%); z-index: 9999;';
      container.className = 'flex flex-col gap-2 pointer-events-none';
      document.body.appendChild(container);
    }
    
    return container;
  }

  function showToast(type, message) {
    const config = TOAST_CONFIG[type] || TOAST_CONFIG.info;
    const container = getToastContainer();
    
    const toast = document.createElement('div');
    toast.setAttribute('role', 'alert');
    toast.className = `pointer-events-auto ${config.bgClass} ${config.borderClass} ${config.textClass} p-2 rounded-lg flex items-center ${config.hoverClass} min-w-[300px] max-w-[500px]`;
    
    const iconDiv = document.createElement('div');
    iconDiv.className = config.iconClass;
    iconDiv.innerHTML = config.icon;
    toast.appendChild(iconDiv);
    
    const messageEl = document.createElement('p');
    messageEl.className = 'text-xs font-semibold flex-1';
    messageEl.textContent = message;
    toast.appendChild(messageEl);
    
    const closeBtn = document.createElement('button');
    closeBtn.className = 'ml-4 opacity-60 hover:opacity-100 transition-opacity';
    closeBtn.innerHTML = `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
    </svg>`;
    closeBtn.addEventListener('click', () => dismissToast(toast));
    toast.appendChild(closeBtn);
    
    container.appendChild(toast);
    
    if (typeof gsap !== 'undefined') {
      gsap.set(toast, { y: 50, opacity: 0, scale: 0.8 });
      gsap.to(toast, {
        y: 0,
        opacity: 1,
        scale: 1,
        duration: 0.5,
        ease: 'back.out(1.4)'
      });
    } else {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(50px) scale(0.8)';
      setTimeout(() => {
        toast.style.transition = 'all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)';
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0) scale(1)';
      }, 10);
    }
    
    setTimeout(() => dismissToast(toast), TOAST_DURATION);
  }

  function dismissToast(toast) {
    if (typeof gsap !== 'undefined') {
      gsap.to(toast, {
        y: 100,
        opacity: 0,
        scale: 0.8,
        duration: 0.4,
        ease: 'back.in(1.4)',
        onComplete: () => removeToast(toast)
      });
    } else {
      toast.style.transition = 'all 0.4s cubic-bezier(0.6, -0.28, 0.735, 0.045)';
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(100px) scale(0.8)';
      setTimeout(() => removeToast(toast), 400);
    }
  }

  function removeToast(toast) {
    toast.remove();
    const container = document.getElementById('toast-container');
    if (container && container.children.length === 0) {
      container.remove();
    }
  }

  function initToasts() {
    // Primero intenta window.TOAST_DATA (inyectado en footer)
    let toasts = window.TOAST_DATA;
    
    // Si no existe, intenta data-toasts del body (legacy)
    if (!toasts) {
      const toastsData = document.body.dataset.toasts;
      
      if (toastsData) {
        try {
          toasts = JSON.parse(toastsData);
          delete document.body.dataset.toasts;
        } catch (error) {
          console.error('[Toast] Error parsing toasts:', error);
          return;
        }
      }
    }
    
    if (toasts && Array.isArray(toasts) && toasts.length > 0) {
      toasts.forEach((toast, index) => {
        setTimeout(() => {
          showToast(toast.type, toast.message);
        }, index * 150);
      });
      
      // Limpiar
      delete window.TOAST_DATA;
    }
  }

  window.showToast = showToast;

  function loadGSAPAndInit() {
    if (typeof gsap !== 'undefined') {
      initToasts();
      return;
    }
    
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js';
    script.onload = () => initToasts();
    script.onerror = () => initToasts();
    document.head.appendChild(script);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadGSAPAndInit);
  } else {
    loadGSAPAndInit();
  }

})();
