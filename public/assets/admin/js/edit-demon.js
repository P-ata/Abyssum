import { gsap } from 'gsap';

// edit-demon page interactions
(() => {
  const $  = (sel, ctx=document) => ctx.querySelector(sel);
  const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

  onReady(() => {
    // Entrance animations
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    const title = $('#edTitle');
    if (title && title.children.length) {
      tl.from(title.children, { y: 40, opacity: 0, stagger: 0.12, duration: 0.8 })
        .from('#mediaCard', { x: -50, opacity: 0, duration: 0.7 }, '-=0.4')
        .from('#editDemonForm', { x: 50, opacity: 0, duration: 0.7 }, '-=0.6')
        .from('#editDemonForm .form-section', { y: 20, opacity: 0, stagger: 0.05, duration: 0.4 }, '-=0.3');
    }

    // Drag & Drop image uploader (single image for demons)
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

    // Handle drop
    dropZone.addEventListener('drop', (e) => {
      const files = e.dataTransfer.files;
      if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
          handleFile(file);
        }
      }
    });

    // Click to browse
    dropZone.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', (e) => {
      if (e.target.files.length > 0) handleFile(e.target.files[0]);
    });

    function handleFile(file) {
      uploadedFile = file;
      const dt = new DataTransfer();
      dt.items.add(file);
      fileInput.files = dt.files;

      // Hide current image preview and show new upload preview
      if (currentPreview) {
        currentPreview.style.display = 'none';
      }

      // Show new thumbnail
      thumbs.innerHTML = '';
      const reader = new FileReader();
      reader.onload = (ev) => {
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.className = 'w-full h-64 object-cover rounded-md border-2 border-amber-600/30';
        thumbs.appendChild(img);

        gsap.from(img, { scale: 0.9, opacity: 0, duration: 0.5, ease: 'back.out(1.7)' });

        // Create remove button
        const removeBtn = document.createElement('button');
        removeBtn.textContent = '✕ Eliminar';
        removeBtn.type = 'button';
        removeBtn.className = 'mt-2 text-xs text-red-500 border border-red-600/40 px-3 py-1 rounded hover:bg-red-600/20 transition w-full';
        removeBtn.addEventListener('click', () => {
          thumbs.innerHTML = '';
          uploadedFile = null;
          fileInput.value = '';
          // Restore current image preview
          if (currentPreview) {
            currentPreview.style.display = 'block';
          }
        });
        thumbs.appendChild(removeBtn);
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
