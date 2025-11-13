import { gsap } from 'gsap';

// edit-pact page interactions
(() => {
  const $$ = (sel, ctx=document) => Array.from(ctx.querySelectorAll(sel));
  const $  = (sel, ctx=document) => ctx.querySelector(sel);
  const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

  onReady(() => {
    // Entrance animations
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    const title = $('#epTitle');
    if (title && title.children.length) {
      tl.from(title.children, { y: 40, opacity: 0, stagger: 0.12, duration: 0.8 })
        .from('#mediaCard', { x: -50, opacity: 0, duration: 0.7 }, '-=0.4')
        .from('#editPactForm', { x: 50, opacity: 0, duration: 0.7 }, '-=0.6')
        .from('#editPactForm .form-section', { y: 20, opacity: 0, stagger: 0.06, duration: 0.4 }, '-=0.3');
    }

    // Drag & Drop image uploader (single image for pact)
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
  });
})();
