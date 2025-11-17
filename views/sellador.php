<?php
require_once BASE_PATH . '/classes/Toast.php';

?>

<div class="min-h-screen bg-black relative overflow-hidden py-20 px-4 font-mono">
  
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

  <div class="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8 relative z-10">

    <!-- title -->
    <div class="text-center mb-10">
      <h1 class="text-5xl sm:text-6xl font-bold tracking-widest text-amber-500">
        EL SELLADOR
      </h1>
      <p class="text-amber-600/70 text-sm mt-3 uppercase tracking-widest">// Puente entre entidades y mortales</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
      <!-- photo / avatar -->
      <div class="lg:col-span-2">
        <div class="bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden shadow-2xl shadow-amber-500/20">
          <div class="aspect-[4/5] flex items-center justify-center bg-gradient-to-br from-black/80 to-amber-950/10">
              <img src="../assets/img/sellador.webp" alt="Foto del Sellador" class="w-full h-full object-cover"/>
          </div>
          <div class="p-5 border-t border-amber-600/20">
            <div class="flex items-center justify-between">
              <span class="text-amber-500 font-bold tracking-wider">IDENTIDAD</span>
              <span class="text-xs text-amber-600/60">// confidencial</span>
            </div>
          </div>
        </div>
    
      </div>

      <!-- bio -->
      <div class="lg:col-span-3 space-y-6">
        <section class="bg-black/70 border border-amber-600/30 rounded-xl p-6">
          <h2 class="text-amber-500 text-xl font-bold mb-3 tracking-widest">MANIFIESTO</h2>
          <p class="text-amber-100/80 leading-relaxed">
            Soy el Sellador: trazo los puentes que no existen. Donde el hierro canta y la noche respira neón, enlace vórtices de intención con entidades del abismo. 
            Mi trabajo no es invocar por invocar, sino sincronizar pulsos: el de quien pide, el de quien responde, y el del mundo que debe sostener el pacto.
          </p>
        </section>

        <section class="grid sm:grid-cols-3 gap-4">
          <div class="bg-black/70 border border-amber-600/30 rounded-xl p-5">
            <div class="text-amber-500 font-bold text-sm mb-2 tracking-wider">ESCUCHA</div>
            <p class="text-amber-100/70 text-sm">Traducción de necesidad real: separo deseo de propósito. La palabra justa abre la puerta correcta.</p>
          </div>
          <div class="bg-black/70 border border-amber-600/30 rounded-xl p-5">
            <div class="text-amber-500 font-bold text-sm mb-2 tracking-wider">SELECCIÓN</div>
            <p class="text-amber-100/70 text-sm">Cada demonio es un vector distinto. Analizo afinidad, riesgo y costo para un encaje preciso.</p>
          </div>
          <div class="bg-black/70 border border-amber-600/30 rounded-xl p-5">
            <div class="text-amber-500 font-bold text-sm mb-2 tracking-wider">SELLADO</div>
            <p class="text-amber-100/70 text-sm">Defino límites, precios y salvaguardas. Un buen sello protege tanto como habilita.</p>
          </div>
        </section>

        

        

        <div class="flex gap-3">
          <a href="/?sec=contact" class="flex-1 text-center bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 font-bold py-3 px-6 rounded-lg transition-all">
            HABLAR CON EL SELLADOR
          </a>
          <a href="/?sec=demons" class="flex-1 text-center bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 font-bold py-3 px-6 rounded-lg transition-all">
            VER DEMONIOS
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
