import { gsap } from 'gsap';

// new-demon page interactions
(() => {
  const $  = (sel, ctx=document) => ctx.querySelector(sel);
  const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

  onReady(() => {
    // Entrance animations
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    const title = $('#ndTitle');
    if (title && title.children.length) {
      tl.from(title.children, { y: 40, opacity: 0, stagger: 0.12, duration: 0.8 })
        .from('#mediaCard', { x: -50, opacity: 0, duration: 0.7 }, '-=0.4')
        .from('#newDemonForm', { x: 50, opacity: 0, duration: 0.7 }, '-=0.6')
        .from('#newDemonForm .form-section', { y: 20, opacity: 0, stagger: 0.05, duration: 0.4 }, '-=0.3');
    }

    // Drag & Drop image uploader (single image for demons)
    const dropZone  = $('#dropZone');
    const fileInput = $('#fileInput');
    const thumbs    = $('#thumbs');

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

    // Prevent defaults on drag events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
      dropZone.addEventListener(evt, prevent, false);
      document.body.addEventListener(evt, prevent, false);
    });

    // Highlight on drag
    ['dragenter', 'dragover'].forEach(evt => {
      dropZone.addEventListener(evt, () => setHover(true), false);
    });
    ['dragleave', 'drop'].forEach(evt => {
      dropZone.addEventListener(evt, () => setHover(false), false);
    });

    // Click dropZone to trigger file input
    dropZone.addEventListener('click', () => fileInput.click());

    // Drop handler - transfer files to input
    dropZone.addEventListener('drop', (e) => {
      const dt = e.dataTransfer;
      const files = dt.files;
      if (files.length > 0) {
        // Use DataTransfer to properly set files on input (works cross-browser)
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(files[0]); // Only first file for demon
        fileInput.files = dataTransfer.files;
        previewFile(files[0]);
      }
    }, false);

    // File input change - just preview
    fileInput.addEventListener('change', (e) => {
      if (e.target.files.length > 0) {
        previewFile(e.target.files[0]);
      }
    });

    function previewFile(file) {
      // Validate
      if (!file.type.startsWith('image/')) {
        alert(`${file.name} no es una imagen válida.`);
        fileInput.value = ''; // Clear invalid file
        return;
      }
      if (file.size > 5 * 1024 * 1024) {
        alert(`${file.name} excede el tamaño máximo de 5MB.`);
        fileInput.value = ''; // Clear oversized file
        return;
      }
      
      // Clear previous preview
      thumbs.innerHTML = '';
      
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = () => {
        const wrapper = document.createElement('div');
        wrapper.className = 'relative group bg-black/70 border border-amber-600/30 rounded-lg overflow-hidden aspect-square cursor-pointer hover:border-amber-500/60 transition';
        
        const img = document.createElement('img');
        img.src = reader.result;
        img.className = 'w-full h-full object-cover';
        img.alt = file.name;
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'absolute inset-0 flex items-center justify-center bg-black/80 opacity-0 group-hover:opacity-100 transition';
        removeBtn.innerHTML = `
          <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        `;
        removeBtn.title = 'Quitar imagen';
        
        removeBtn.addEventListener('click', () => {
          fileInput.value = ''; // Clear the file input
          gsap.to(wrapper, {
            scale: 0.8,
            opacity: 0,
            duration: 0.3,
            ease: 'power2.in',
            onComplete: () => wrapper.remove()
          });
        });

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        thumbs.innerHTML = ''; // Clear previous
        thumbs.appendChild(wrapper);

        // Entrance animation
        gsap.from(wrapper, {
          scale: 0.7,
          opacity: 0,
          duration: 0.4,
          ease: 'back.out(1.7)'
        });
      };
    }

    // Clear file on form reset
    const form = $('#newDemonForm');
    if (form) {
      form.addEventListener('reset', () => {
        fileInput.value = '';
        thumbs.innerHTML = '';
      });
    }
  });
})();
