import { gsap } from 'gsap';


// edit-demon page interactions
(() => {
  const $  = (sel, ctx=document) => ctx.querySelector(sel);
  const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

  onReady(() => {
    // Animar entrada de elementos
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    const title = $('#edTitle');
    if (title && title.children.length) {
      tl.from(title.children, { y: 40, opacity: 0, stagger: 0.12, duration: 0.8 })
        .from('#mediaCard', { x: -50, opacity: 0, duration: 0.7 }, '-=0.4')
        .from('#editDemonForm', { x: 50, opacity: 0, duration: 0.7 }, '-=0.6')
        .from('#editDemonForm .form-section', { y: 20, opacity: 0, stagger: 0.05, duration: 0.4 }, '-=0.3');
    }

    // Cargador de imágenes con arrastrar y soltar
    const dropZone  = $('#dropZone');
    const fileInput = $('#fileInput');
    const thumbs    = $('#thumbs');
    const currentPreview = $('#currentImagePreview');
    let uploadedFile = null;

    if (!dropZone || !fileInput || !thumbs) return;

    const prevent = (e) => { e.preventDefault(); e.stopPropagation(); };
    const setHover = (on) => {
      if (on) {
        dropZone.classList.add('border-amber-500');
        dropZone.classList.remove('border-amber-600/30');
      } else {
        dropZone.classList.remove('border-amber-500');
        dropZone.classList.add('border-amber-600/30');
      }
    };

    // Evitar comportamiento predeterminado en eventos de arrastre
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
      dropZone.addEventListener(evt, prevent, false);
      document.body.addEventListener(evt, prevent, false);
    });

    // Resaltar al arrastrar
    ['dragenter', 'dragover'].forEach(evt => {
      dropZone.addEventListener(evt, () => setHover(true), false);
    });
    ['dragleave', 'drop'].forEach(evt => {
      dropZone.addEventListener(evt, () => setHover(false), false);
    });

    // Manejar soltar archivo
    dropZone.addEventListener('drop', (e) => {
      const files = e.dataTransfer.files;
      if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
          handleFile(file);
        }
      }
    });

    // Abrir navegador al hacer clic
    dropZone.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', (e) => {
      if (e.target.files.length > 0) handleFile(e.target.files[0]);
    });

    function handleFile(file) {
      uploadedFile = file;
      const dt = new DataTransfer();
      dt.items.add(file);
      fileInput.files = dt.files;

      // Ocultar preview actual y mostrar nueva imagen
      if (currentPreview) {
        currentPreview.style.display = 'none';
      }

      // Mostrar nueva miniatura
      thumbs.innerHTML = '';
      const reader = new FileReader();
      reader.onload = (ev) => {
        thumbs.innerHTML = ''; // Limpiar anterior
        
        const wrapper = document.createElement('div');
        wrapper.className = 'relative group border border-amber-600/30 rounded-lg overflow-hidden';
        
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.className = 'h-auto max-h-screen';
        wrapper.appendChild(img);

        // Botón para quitar imagen (visible al pasar el mouse)
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500';
        removeBtn.innerHTML = `
          <svg class="w-7 h-7 text-amber-500 drop-shadow-lg" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        `;
        removeBtn.title = 'Quitar imagen';
        removeBtn.addEventListener('click', async () => {
          // Obtener ID del archivo desde input oculto
          const fileIdInput = document.querySelector('input[name="current_image_file_id"]');
          const fileId = fileIdInput ? parseInt(fileIdInput.value) : null;
          
          // Eliminar de la BD si existe ID de archivo
          if (fileId) {
            try {
              const formData = new FormData();
              formData.append('id', fileId);
              
              const response = await fetch('/admin/actions/delete-file', {
                method: 'POST',
                body: formData
              });
              
              if (!response.ok) {
                console.error('Error al eliminar archivo:', response.statusText);
              }
            } catch (error) {
              console.error('Error en la solicitud:', error);
            }
          }
          
          // Clear the hidden input
          if (fileIdInput) {
            fileIdInput.value = '';
          }
          
          gsap.to(wrapper, {
            scale: 0.8,
            opacity: 0,
            duration: 0.6,
            ease: 'power2.in',
            onComplete: () => {
              thumbs.innerHTML = '';
              uploadedFile = null;
              fileInput.value = '';
              // Mostrar preview anterior
              if (currentPreview) {
                currentPreview.style.display = 'block';
              }
            }
          });
        });
        
        wrapper.appendChild(removeBtn);
        thumbs.appendChild(wrapper);
        
        gsap.from(wrapper, { scale: 0.9, opacity: 0, duration: 0.5, ease: 'back.out(1.7)' });
      };
      reader.readAsDataURL(file);
    }

    // Toggle JSON array inputs (aliases, personality, weaknesses, abilities)
    const toggleButtons = document.querySelectorAll('[data-toggle-group]');
    toggleButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        const groupId = btn.getAttribute('data-toggle-group');
        const container = document.getElementById(groupId);
        if (container) {
          const isHidden = container.style.display === 'none';
          container.style.display = isHidden ? 'block' : 'none';
          btn.textContent = isHidden ? '− OCULTAR' : '+ VER';
        }
      });
    });

    // Add input for aliases, personality, weaknesses, abilities
    document.querySelectorAll('[data-add-input]').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.getAttribute('data-add-input');
        const container = document.getElementById(target);
        if (container) {
          const input = document.createElement('input');
          input.type = 'text';
          input.name = target + '[]';
          input.className = 'w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2';
          input.placeholder = `Nuevo ${target.slice(0, -1)}...`;
          container.appendChild(input);
          gsap.from(input, { y: -10, opacity: 0, duration: 0.3 });
        }
      });
    });
  });
})();
