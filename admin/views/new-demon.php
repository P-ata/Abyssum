<div class="min-h-screen bg-black relative overflow-hidden px-6 py-14 xl:py-16 font-mono">
  <!-- Ambient background grid & glow -->
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.10) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.10) 1px, transparent 1px); background-size: 60px 60px;"></div>
  </div>

  <div class="max-w-7xl mx-auto relative z-10">
    <!-- Title -->
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-10 mb-14">
      <h1 id="ndTitle" class="text-5xl md:text-6xl font-bold tracking-widest leading-tight text-amber-500">
        <span class="block">ABYSSUM</span>
        <span class="block text-xl md:text-2xl mt-3 tracking-wide text-amber-600/80">// DEMONIOS :: NUEVO</span>
      </h1>
      <div class="flex flex-wrap gap-3">
        <a href="/admin/dashboard" class="px-5 py-2.5 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">VOLVER</a>
      </div>
    </div>

    <?php if (isset($_SESSION['flash_error'])): ?>
      <div class="mb-6 p-4 bg-red-900/30 border border-red-600/50 rounded text-red-400 text-sm">
        <?= htmlspecialchars($_SESSION['flash_error']) ?>
        <?php unset($_SESSION['flash_error']); ?>
      </div>
    <?php endif; ?>

    <!-- Form layout wider spacing on desktop -->
    <div class="grid gap-10 xl:gap-16 md:grid-cols-2 items-start">
      <!-- Left: Media uploader -->
      <section class="md:col-span-1 space-y-8">
        <div class="bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden" id="mediaCard">
          <div class="p-6 xl:p-7 border-b border-amber-600/20">
            <h2 class="text-amber-500 tracking-widest text-sm">// IMAGEN DEL DEMONIO</h2>
          </div>
          <div class="p-6 xl:p-7">
            <div id="dropZone" class="group relative flex flex-col items-center justify-center gap-4 border-2 border-dashed border-amber-600/30 rounded-xl bg-black/50 hover:border-amber-500/60 transition cursor-pointer p-10 text-center">
              <svg class="w-12 h-12 text-amber-600/60" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V8.25m0 0-3 3m3-3 3 3M6.75 19.5A4.5 4.5 0 0 1 2.25 15V7.5a4.5 4.5 0 0 1 4.5-4.5h10.5a4.5 4.5 0 0 1 4.5 4.5V15a4.5 4.5 0 0 1-4.5 4.5H6.75Z"/>
              </svg>
              <p class="text-amber-500 text-sm tracking-wide">Arrastrá y soltá la imagen aquí</p>
              <p class="text-xs text-amber-600/60">o <span class="underline">elegí un archivo</span> desde tu dispositivo</p>
              <div class="absolute inset-0 rounded-xl pointer-events-none opacity-0 group-hover:opacity-100 transition shadow-[inset_0_0_50px_rgba(251,191,36,0.12)]"></div>
            </div>
            <div id="thumbs" class="mt-7"></div>
          </div>
        </div>
      </section>

      <!-- Right: Form fields -->
      <section class="md:col-span-1">
        <form action="/admin/actions/create-demon" method="post" enctype="multipart/form-data" class="bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden" id="newDemonForm">
          <!-- Hidden file input -->
          <input id="fileInput" name="image" type="file" accept="image/*" class="hidden" aria-label="Seleccionar imagen" />
          
          <div class="p-6 xl:p-7 border-b border-amber-600/20 flex items-center justify-between">
            <h2 class="text-amber-500 tracking-widest text-sm">// DATOS DEL DEMONIO</h2>
          </div>
          <div class="p-6 xl:p-8 grid gap-8 md:grid-cols-2">
            <!-- Basic Info -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">NOMBRE *</label>
              <input required name="name" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="Aurelia" />
            </div>
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">URL (opcional)</label>
              <input name="slug" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="aurelia" />
              <p class="text-xs text-amber-600/50 mt-1">Se genera automáticamente del nombre si se deja vacío</p>
            </div>
            
            <!-- Species & Gender -->
            <div class="md:col-span-1 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">ESPECIE</label>
              <input name="species" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="e.g. Súcubo, Íncubo" />
            </div>
            <div class="md:col-span-1 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">GÉNERO</label>
              <input name="gender" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="e.g. Femenino, Masculino" />
            </div>

            <!-- Age -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">EDAD REAL</label>
              <input name="age_real" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="e.g. 347 años, Milenario" />
            </div>

            <!-- Aliases (JSON array - 3 inputs) -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">ALIAS</label>
              <input name="alias_1" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2" placeholder="Alias 1" />
              <input name="alias_2" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2" placeholder="Alias 2" />
              <input name="alias_3" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="Alias 3" />
            </div>

            <!-- Summary -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">RESUMEN</label>
              <textarea name="summary" rows="4" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// descripción breve del demonio, características principales"></textarea>
            </div>

            <!-- Lore -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">LORE</label>
              <textarea name="lore" rows="6" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// historia completa, origen, eventos relevantes del demonio"></textarea>
            </div>

            <!-- Personality (JSON array - 3 traits) -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">PERSONALIDAD</label>
              <input name="personality_1" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2" placeholder="Rasgo 1" />
              <input name="personality_2" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2" placeholder="Rasgo 2" />
              <input name="personality_3" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="Rasgo 3" />
            </div>

            <!-- Abilities Summary -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">HABILIDADES</label>
              <textarea name="abilities_summary" rows="4" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// resumen de habilidades y poderes especiales"></textarea>
            </div>

            <!-- Stats -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-3">ESTADÍSTICAS (0-100)</label>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs text-amber-600/50 mb-1">Fuerza</label>
                  <input name="stat_strength" type="number" min="0" max="100" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition" placeholder="0" />
                </div>
                <div>
                  <label class="block text-xs text-amber-600/50 mb-1">Destreza</label>
                  <input name="stat_dexterity" type="number" min="0" max="100" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition" placeholder="0" />
                </div>
                <div>
                  <label class="block text-xs text-amber-600/50 mb-1">Inteligencia</label>
                  <input name="stat_intelligence" type="number" min="0" max="100" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition" placeholder="0" />
                </div>
                <div>
                  <label class="block text-xs text-amber-600/50 mb-1">Salud</label>
                  <input name="stat_health" type="number" min="0" max="100" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition" placeholder="0" />
                </div>
                <div>
                  <label class="block text-xs text-amber-600/50 mb-1">Reflejos</label>
                  <input name="stat_reflexes" type="number" min="0" max="100" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition" placeholder="0" />
                </div>
                <div>
                  <label class="block text-xs text-amber-600/50 mb-1">Sigilo</label>
                  <input name="stat_stealth" type="number" min="0" max="100" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition" placeholder="0" />
                </div>
              </div>
            </div>

            <!-- Weaknesses (JSON array - 3 inputs) -->
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">DEBILIDADES / LÍMITES</label>
              <input name="weakness_1" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2" placeholder="Debilidad 1" />
              <input name="weakness_2" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2" placeholder="Debilidad 2" />
              <input name="weakness_3" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="Debilidad 3" />
            </div>
          </div>
          <div class="px-6 xl:px-8 py-5 border-t border-amber-600/20 flex flex-wrap items-center justify-end gap-4">
            <button type="reset" class="px-5 py-2 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">LIMPIAR</button>
            <button type="submit" class="px-5 py-2 rounded border border-amber-600/40 bg-amber-600/20 hover:bg-amber-600/30 text-amber-400 text-sm tracking-wide transition">GUARDAR</button>
          </div>
        </form>
      </section>
    </div>

    <div class="mt-16 text-center text-xs tracking-widest text-amber-600/50">// ADMIN :: NEW-DEMON</div>
  </div>
</div>
