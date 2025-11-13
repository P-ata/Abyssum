<?php
require_once BASE_PATH . '/classes/Demon.php';
$demons = Demon::all();
?>

<div class="min-h-screen bg-black relative overflow-hidden px-6 py-14 xl:py-16 font-mono">
  <!-- Ambient background grid & glow -->
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.10) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.10) 1px, transparent 1px); background-size: 60px 60px;"></div>
  </div>
  
  <div class="max-w-7xl mx-auto relative z-10">
    <!-- Title -->
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-10 mb-14">
      <h1 id="npTitle" class="text-5xl md:text-6xl font-bold tracking-widest leading-tight text-amber-500">
        <span class="block">ABYSSUM</span>
        <span class="block text-xl md:text-2xl mt-3 tracking-wide text-amber-600/80">// PACTOS :: NUEVO</span>
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
            <h2 class="text-amber-500 tracking-widest text-sm">// IMÁGENES DEL PACTO</h2>
          </div>
          <div class="p-6 xl:p-7">
            <div id="dropZone" class="group relative flex flex-col items-center justify-center gap-4 border-2 border-dashed border-amber-600/30 rounded-xl bg-black/50 hover:border-amber-500/60 transition cursor-pointer p-10 text-center">
              <svg class="w-12 h-12 text-amber-600/60" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V8.25m0 0-3 3m3-3 3 3M6.75 19.5A4.5 4.5 0 0 1 2.25 15V7.5a4.5 4.5 0 0 1 4.5-4.5h10.5a4.5 4.5 0 0 1 4.5 4.5V15a4.5 4.5 0 0 1-4.5 4.5H6.75Z"/>
              </svg>
              <p class="text-amber-500 text-sm tracking-wide">Arrastrá y soltá imágenes aquí</p>
              <p class="text-xs text-amber-600/60">o <span class="underline">elegí archivos</span> desde tu dispositivo</p>
              <div class="absolute inset-0 rounded-xl pointer-events-none opacity-0 group-hover:opacity-100 transition shadow-[inset_0_0_50px_rgba(251,191,36,0.12)]"></div>
            </div>
            <div id="thumbs" class="mt-7 grid grid-cols-2 gap-5"></div>
          </div>
        </div>
      </section>

      <!-- Right: Form fields -->
      <section class="md:col-span-1">
        <form action="/admin/actions/create-pact" method="post" enctype="multipart/form-data" class="bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden" id="newPactForm">
          <!-- Hidden file input -->
          <input id="fileInput" name="image" type="file" accept="image/*" class="hidden" aria-label="Seleccionar imagen" />
          
          <div class="p-6 xl:p-7 border-b border-amber-600/20 flex items-center justify-between">
            <h2 class="text-amber-500 tracking-widest text-sm">// DATOS DEL PACTO</h2>
          </div>
          <div class="p-6 xl:p-8 grid gap-8 md:grid-cols-2">
            <div class="md:col-span-1 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">DEMON *</label>
              <select required name="demon_id" class="w-full bg-black/60 border border-amber-600/30 rounded px-4 py-2.5 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition">
                <option value="">-- Seleccionar Demonio --</option>
                <?php foreach ($demons as $d): ?>
                  <option value="<?= $d->id ?>"><?= htmlspecialchars($d->name) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="md:col-span-1 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">TÍTULO *</label>
              <input required name="name" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="Overclock de Corona" />
            </div>
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">URL (opcional)</label>
              <input name="slug" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="overclock-de-corona" />
              <p class="text-xs text-amber-600/50 mt-1">Se genera automáticamente del título si se deja vacío</p>
            </div>
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">DESCRIPCIÓN</label>
              <textarea name="summary" rows="6" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="// detalles breves del pacto, condiciones, efectos, limitaciones"></textarea>
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">DURACIÓN</label>
              <input name="duration" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="e.g. 1 minuto, 2h" />
            </div>
            <div class="form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">COOLDOWN</label>
              <input name="cooldown" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="e.g. 5 minutos" />
            </div>
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">LIMITACIONES</label>
              <input name="limitation_1" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2" placeholder="Limitación 1" />
              <input name="limitation_2" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition mb-2" placeholder="Limitación 2" />
              <input name="limitation_3" type="text" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 placeholder:text-amber-600/40 focus:outline-none focus:border-amber-500 transition" placeholder="Limitación 3" />
            </div>
            <div class="md:col-span-2 form-section">
              <label class="block text-xs text-amber-600/70 tracking-widest mb-2">PRECIO (créditos)</label>
              <input name="price_credits" type="number" min="0" value="0" class="w-full bg-black/60 border border-amber-600/30 rounded px-5 py-3 text-sm text-amber-100 focus:outline-none focus:border-amber-500 transition" />
            </div>
          </div>
          <div class="px-6 xl:px-8 py-5 border-t border-amber-600/20 flex flex-wrap items-center justify-end gap-4">
            <button type="reset" class="px-5 py-2 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/20 text-amber-500 text-sm tracking-wide transition">LIMPIAR</button>
            <button type="submit" class="px-5 py-2 rounded border border-amber-600/40 bg-amber-600/20 hover:bg-amber-600/30 text-amber-400 text-sm tracking-wide transition">GUARDAR</button>
          </div>
        </form>
      </section>
    </div>

    <div class="mt-16 text-center text-xs tracking-widest text-amber-600/50">// ADMIN :: NEW-PACT</div>
  </div>
</div>
