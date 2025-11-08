// new-pact page interactions (front only)
(() => {
  const $$ = (sel, ctx=document) => Array.from(ctx.querySelectorAll(sel));
  const $  = (sel, ctx=document) => ctx.querySelector(sel);
  const onReady = (fn) => (document.readyState !== 'loading') ? fn() : document.addEventListener('DOMContentLoaded', fn);

  onReady(() => {
    // Entrance animations
    if (window.gsap) {
      const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
      tl.from('#npTitle span', { y: 40, opacity: 0, stagger: 0.12, duration: 0.8 })
        .from('#mediaCard', { y: 30, opacity: 0, duration: 0.5 }, '-=0.4')
        .from('#newPactForm .form-section', { y: 20, opacity: 0, stagger: 0.06, duration: 0.4 }, '-=0.2');
    }

    // Power live value
    const powerRange = $('#powerRange');
    const powerValue = $('#powerValue');
    if (powerRange && powerValue) {
      const sync = () => powerValue.textContent = powerRange.value;
      powerRange.addEventListener('input', sync);
      sync();
    }

    // Toggle ACTIVE
    const toggle = $('#toggleActive');
    if (toggle) {
      toggle.addEventListener('click', () => {
        const on = toggle.getAttribute('data-on') === 'true';
        toggle.setAttribute('data-on', String(!on));
        toggle.textContent = on ? 'INACTIVO' : 'ACTIVO';
        if (window.gsap) gsap.fromTo(toggle, { opacity: 0.6 }, { opacity: 1, duration: 0.2 });
      });
    }

    // Drag & Drop images + previews (front only)
    const dropZone  = $('#dropZone');
    const fileInput = $('#fileInput');
    const thumbs    = $('#thumbs');
    const maxFiles  = 12;

    const prevent = (e) => { e.preventDefault(); e.stopPropagation(); };
    const setHover = (on) => dropZone && dropZone.classList[on ? 'add' : 'remove']('ring-1', 'ring-amber-500/40');

    const toFilesArray = (dt) => {
      const items = dt.items ? Array.from(dt.items).map(i => i.getAsFile()).filter(Boolean) : Array.from(dt.files);
      return items.filter(f => /^image\//.test(f.type));
    };

    const renderThumb = (file) => {
      const url = URL.createObjectURL(file);
      const el = document.createElement('div');
      el.className = 'relative group rounded-lg overflow-hidden border border-amber-600/30 bg-black/40';
      el.innerHTML = `
        <img src="${url}" alt="preview" class="w-full h-32 lg:h-36 object-cover" />
        <button type="button" class="absolute top-2 right-2 text-[10px] px-2 py-1 rounded bg-black/70 border border-amber-600/40 text-amber-500 opacity-0 group-hover:opacity-100 transition">Quitar</button>
      `;
      el.querySelector('button').addEventListener('click', () => {
        el.remove();
        URL.revokeObjectURL(url);
      });
      thumbs.appendChild(el);
    };

    const handleFiles = (files) => {
      const current = thumbs.children.length;
      const allowed = Math.max(0, maxFiles - current);
      files.slice(0, allowed).forEach(renderThumb);
    };

    if (dropZone && fileInput && thumbs) {
      ['dragenter','dragover','dragleave','drop'].forEach(ev => dropZone.addEventListener(ev, prevent));
      ['dragenter','dragover'].forEach(() => dropZone.addEventListener('dragover', () => setHover(true)));
      ['dragleave','drop'].forEach(() => dropZone.addEventListener('dragleave', () => setHover(false)));
      dropZone.addEventListener('drop', (e) => handleFiles(toFilesArray(e.dataTransfer)));
      dropZone.addEventListener('click', () => fileInput.click());
      fileInput.addEventListener('change', (e) => handleFiles(Array.from(e.target.files)));
    }

    // Tags chips
    const tagText = $('#tagText');
    const tagInput = $('#tagInput');
    const addTag = (value) => {
      const v = (value || '').trim();
      if (!v) return;
      const chip = document.createElement('button');
      chip.type = 'button';
      chip.className = 'px-2 py-1 text-[11px] rounded border border-amber-600/40 text-amber-400 bg-black/50 hover:bg-amber-600/20 transition';
      chip.textContent = v;
      chip.addEventListener('click', () => chip.remove());
      tagInput.insertBefore(chip, tagText);
    };
    if (tagText && tagInput) {
      tagText.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault();
          addTag(tagText.value);
          tagText.value = '';
        }
        if (e.key === 'Backspace' && !tagText.value && tagInput.children.length > 1) {
          const last = tagInput.children[tagInput.children.length - 2];
          last && last.remove();
        }
      });
    }

    // Desktop niceties: expand thumbs grid on larger screens
    const thumbsEl = $('#thumbs');
    if (thumbsEl) {
      thumbsEl.classList.add('sm:grid-cols-3', 'xl:grid-cols-4');
    }
  });
})();
