<div class="min-h-screen bg-black relative overflow-hidden px-6 py-14 xl:py-16 font-mono">
  <!-- Ambient background grid & glow -->
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.10) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.10) 1px, transparent 1px); background-size: 60px 60px;"></div>
  </div>
  

  <div class="max-w-7xl mx-auto relative z-10">
    <!-- Title -->
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-10 mb-14">
      <h1 id="npTitle" class="text-5xl md:text-6xl font-bold tracking-widest leading-tight text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-amber-600 to-amber-500 drop-shadow-[0_0_10px_rgba(251,191,36,0.35)]">
        <span class="block">ABYSSUM</span>
        <span class="block text-xl md:text-2xl mt-3 tracking-wide text-amber-600/80">// PACTOS :: NUEVO</span>
      </h1>
      <div class="flex flex-wrap gap-3">
        <a href="/admin" class="px-5 py-2.5 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">VOLVER</a>
        <button type="button" class="px-5 py-2.5 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/25 text-amber-500 text-sm tracking-wide transition">GUARDAR BORRADOR</button>
        <button type="button" class="px-5 py-2.5 rounded border border-amber-600/60 bg-amber-600/20 hover:bg-amber-600/30 text-amber-400 text-sm tracking-wide transition shadow-[0_0_15px_-3px_rgba(251,191,36,0.35)]">PUBLICAR</button>
      </div>
    </div>

    <!-- Form layout wider spacing on desktop -->
  <div class="grid gap-10 xl:gap-16 md:grid-cols-2 items-start">
      <!-- Left: Media uploader -->
  <section class="md:col-span-1 space-y-8">
        <div class="bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden" id="mediaCard">
          <div class="p-6 xl:p-7 border-b border-amber-600/20">
            <h2 class="text-amber-500 tracking-widest text-sm">// IMÁGENES DEL PACTO</h2>
          </div>
          <div class="p-6 xl:p-7">
            <div id="dropZone" class="group relative flex flex-col items-center justify-center gap-4 border-2 border-dashed border-amber-600/30 rounded-xl bg-black/50 hover:border-amber-500/60 transition cursor-pointer p-10 text-center">
              <svg class="w-12 h-12 text-amber-600/60" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V8.25m0 0-3 3m3-3 3 3M6.75 19.5A4.5 4.5 0 0 1 2.25 15V7.5a4.5 4.5 0 0 1 4.5-4.5h10.5a4.5 4.5 0 0 1 4.5 4.5V15a4.5 4.5 0 0 1-4.5 4.5H6.75Z"/>
              </svg>
              <p class="text-amber-500 text-sm tracking-wide">Arrastrá y soltá imágenes aquí</p>
              <p class="text-xs text-amber-600/60">o <span class="underline">elegí archivos</span> desde tu dispositivo</p>
              <input id="fileInput" type="file" accept="image/*" multiple class="absolute inset-0 opacity-0 cursor-pointer" aria-label="Seleccionar imágenes" />
              <div class="absolute inset-0 rounded-xl pointer-events-none opacity-0 group-hover:opacity-100 transition shadow-[inset_0_0_50px_rgba(251,191,36,0.12)]"></div>
            </div>
            <div id="thumbs" class="mt-7 grid grid-cols-2 gap-5"></div>
            <p class="mt-5 text-xs text-amber-600/60 leading-relaxed">Formatos: JPG, PNG, WebP. Máx 5MB. Límite 12. Reordenado no implementado (mock). Click para quitar una imagen.</p>
          </div>
        </div>
        <div class="bg-black/60 border border-amber-600/20 rounded-lg p-5 text-xs text-amber-600/60 leading-relaxed">
          <p>// TIP: Mantener coherencia visual entre miniaturas ayuda al reconocimiento rápido del pacto.</p>
        </div>
      </section>

      <!-- Right: Form fields -->
  <section class="md:col-span-1">
        <form class="bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden" id="newPactForm" onsubmit="return false;">
          <div class="p-6 xl:p-7 border-b border-amber-600/20 flex items-center justify-between">
            <h2 class="text-amber-500 tracking-widest text-sm">// DATOS DEL PACTO</h2>
            <span class="text-[10px] text-amber-600/50 tracking-widest">FRONT ONLY :: MOCK</span>
          </div>
          <div class="p-6 xl:p-8 grid gap-8 md:grid-cols-2">
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">TÍTULO</label>
              <input type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// pacto, código o alias" />
            </div>
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">DESCRIPCIÓN</label>
              <textarea rows="6" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// detalles breves del pacto, condiciones, efectos, limitaciones"></textarea>
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">RIESGO</label>
              <select class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2.5 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition">
                <option>BAJO</option><option>MEDIO</option><option>ALTO</option><option>CRÍTICO</option>
              </select>
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">CATEGORÍA</label>
              <select class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2.5 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition">
                <option>INVOCACIÓN</option><option>PROTECCIÓN</option><option>INTERCAMBIO</option><option>VÍNCULO</option>
              </select>
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">PODER</label>
              <div class="flex items-center gap-4">
                <input id="powerRange" type="range" min="1" max="10" value="6" class="flex-1 accent-amber-500" />
                <span id="powerValue" class="text-amber-500 text-sm w-10 text-center font-semibold">6</span>
              </div>
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">DURACIÓN</label>
              <div class="flex flex-wrap items-center gap-4">
                <input id="durInput" type="number" min="0" value="2" class="w-24 bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 focus:outline-none focus:border-amber-500" />
                <select class="w-36 bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 focus:outline-none focus:border-amber-500">
                  <option>min</option><option>h</option><option>días</option>
                </select>
              </div>
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">ESTADO</label>
              <div class="flex items-center gap-4">
                <button type="button" id="toggleActive" class="px-4 py-2 rounded border border-amber-600/40 bg-black/60 text-amber-500 text-xs tracking-wide hover:bg-amber-600/20 transition" data-on="true">ACTIVO</button>
                <span class="text-xs text-amber-600/60">Click para alternar</span>
              </div>
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">VISIBILIDAD</label>
              <div class="flex flex-wrap items-center gap-5">
                <label class="inline-flex items-center gap-2 text-xs text-amber-600/70"><input type="checkbox" class="accent-amber-500" checked /> Público</label>
                <label class="inline-flex items-center gap-2 text-xs text-amber-600/70"><input type="checkbox" class="accent-amber-500" /> Destacado</label>
              </div>
            </div>
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">ETIQUETAS</label>
              <div id="tagInput" class="flex flex-wrap items-center gap-2 bg-black/60 border border-amber-600/30 rounded px-4 py-3">
                <input id="tagText" type="text" class="flex-1 bg-transparent outline-none text-sm text-amber-100 placeholder:text-amber-600/40" placeholder="// escribir y presionar Enter" />
              </div>
              <p class="mt-2 text-xs text-amber-600/60">Separá por Enter. Click para remover. Backspace borra la última si está vacío.</p>
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">ORIGEN</label>
              <input type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// grimorio, tradición, demonio" />
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">COSTO</label>
              <input type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// ofrendas, sangre, materiales" />
            </div>
          </div>
          <div class="px-6 xl:px-8 py-5 border-t border-amber-600/20 flex flex-wrap items-center justify-end gap-4">
            <button type="reset" class="px-5 py-2 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">LIMPIAR</button>
            <button type="button" class="px-5 py-2 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/30 text-amber-400 text-sm tracking-wide transition">GUARDAR</button>
          </div>
        </form>
      </section>
    </div>

    <div class="mt-16 text-center text-xs tracking-widest text-amber-600/50">// FORM_STATUS :: MOCK :: SIN BACKEND :: /admin/new-pact</div>
  </div>
</div>
