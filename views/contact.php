<?php
require_once BASE_PATH . '/classes/Toast.php';
?>

<div class="min-h-screen bg-black relative overflow-hidden py-20 px-4 font-mono">
  <!-- Ambient background grid & glow -->
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

  <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 relative z-10">
    
    <!-- Título -->
    <div class="text-center mb-6 contact-title">
      <h1 class="text-6xl font-bold tracking-widest text-amber-500">
        CONTACTO
      </h1>
    </div>

    <!-- Instrucciones -->
    <div class="text-center mb-12 contact-subtitle">
      <p class="text-amber-600/70 text-sm uppercase tracking-widest">
        // Envía tu mensaje al abismo digital
      </p>
    </div>
    
    <!-- Grid: Formulario + Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
      
      <!-- FORMULARIO (2/3) -->
      <div class="lg:col-span-2 contact-form">
        <div class="bg-black/70 border border-amber-600/30 rounded-xl p-8 backdrop-blur-sm">
          <form method="POST" action="/?sec=actions&action=send-contact" class="space-y-6">
            
            <!-- Nombre -->
            <div class="form-field">
              <label for="name" class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                <i class="fa-solid fa-user mr-2"></i>Nombre Completo
              </label>
              <input 
                type="text" 
                id="name" 
                name="name" 
                required
                maxlength="120"
                class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all"
                placeholder="Tu nombre..."
              >
            </div>

            <!-- Email -->
            <div class="form-field">
              <label for="email" class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                <i class="fa-solid fa-envelope mr-2"></i>Email
              </label>
              <input 
                type="email" 
                id="email" 
                name="email" 
                required
                maxlength="190"
                class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all"
                placeholder="tu@email.com"
              >
            </div>

            <!-- Asunto -->
            <div class="form-field">
              <label for="subject" class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                <i class="fa-solid fa-heading mr-2"></i>Asunto <span class="text-amber-600/50 text-[10px]">(opcional)</span>
              </label>
              <input 
                type="text" 
                id="subject" 
                name="subject"
                maxlength="200"
                class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all"
                placeholder="Asunto del mensaje..."
              >
            </div>

            <!-- Mensaje -->
            <div class="form-field">
              <label for="message" class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                <i class="fa-solid fa-message mr-2"></i>Mensaje
              </label>
              <textarea 
                id="message" 
                name="message" 
                required
                rows="8"
                class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all resize-none"
                placeholder="Escribe tu mensaje aquí..."
              ></textarea>
            </div>

            <!-- Botones -->
            <div class="flex gap-4 form-buttons">
              <a href="/" class="flex-1 bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 px-6 py-3 rounded text-center text-sm font-bold transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>VOLVER
              </a>
              <button 
                type="submit"
                class="flex-1 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all hover:shadow-lg hover:shadow-amber-500/30">
                <i class="fa-solid fa-paper-plane mr-2"></i>ENVIAR MENSAJE
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- INFO LATERAL (1/3) -->
      <div class="contact-info">
        <div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 backdrop-blur-sm space-y-6 h-full flex flex-col">
          
          <!-- Info de contacto -->
          <div>
            <h3 class="text-amber-500 text-sm font-bold mb-4 uppercase tracking-wider border-b border-amber-600/30 pb-2">
              <i class="fa-solid fa-circle-info mr-2"></i>Información
            </h3>
            <div class="space-y-3 text-xs text-amber-300/80">
              <p class="flex items-start gap-2">
                <i class="fa-solid fa-clock text-amber-500 mt-1"></i>
                <span>Tiempo de respuesta: <span class="text-amber-400 font-semibold">24-48 horas</span></span>
              </p>
              <p class="flex items-start gap-2">
                <i class="fa-solid fa-shield-halved text-amber-500 mt-1"></i>
                <span>Tus datos están protegidos y no serán compartidos</span>
              </p>
              <p class="flex items-start gap-2">
                <i class="fa-solid fa-headset text-amber-500 mt-1"></i>
                <span>Soporte técnico disponible para usuarios registrados</span>
              </p>
            </div>
          </div>

          <!-- Métodos alternativos -->
          <div class="flex-grow">
            <h3 class="text-amber-500 text-sm font-bold mb-4 uppercase tracking-wider border-b border-amber-600/30 pb-2">
              <i class="fa-solid fa-link mr-2"></i>Otros Canales
            </h3>
            <div class="space-y-3">
              <a href="#" class="flex items-center gap-3 p-3 bg-black/50 border border-amber-600/20 rounded hover:border-amber-600/40 hover:bg-amber-600/10 transition-all group">
                <i class="fa-brands fa-discord text-xl text-amber-500"></i>
                <div class="text-xs">
                  <p class="text-amber-400 font-semibold">Discord</p>
                  <p class="text-amber-600/70">Comunidad oficial</p>
                </div>
              </a>
              <a href="#" class="flex items-center gap-3 p-3 bg-black/50 border border-amber-600/20 rounded hover:border-amber-600/40 hover:bg-amber-600/10 transition-all group">
                <i class="fa-brands fa-x-twitter text-xl text-amber-500"></i>
                <div class="text-xs">
                  <p class="text-amber-400 font-semibold">X (Twitter)</p>
                  <p class="text-amber-600/70">@AbyssumDev</p>
                </div>
              </a>
              <a href="https://github.com" target="_blank" class="flex items-center gap-3 p-3 bg-black/50 border border-amber-600/20 rounded hover:border-amber-600/40 hover:bg-amber-600/10 transition-all group">
                <i class="fa-brands fa-github text-xl text-amber-500"></i>
                <div class="text-xs">
                  <p class="text-amber-400 font-semibold">GitHub</p>
                  <p class="text-amber-600/70">@AbyssumDev</p>
                </div>
              </a>
            </div>
          </div>

          <!-- Horario de atención -->
          <div>
            <h3 class="text-amber-500 text-sm font-bold mb-4 uppercase tracking-wider border-b border-amber-600/30 pb-2">
              <i class="fa-solid fa-clock mr-2"></i>Horarios
            </h3>
            <div class="space-y-2 text-xs">
              <div class="flex items-center justify-between">
                <span class="text-amber-300/80">Lun - Vie:</span>
                <span class="text-amber-400 font-semibold">9:00 - 18:00</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-amber-300/80">Sábados:</span>
                <span class="text-amber-400 font-semibold">10:00 - 14:00</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-amber-300/80">Domingos:</span>
                <span class="text-amber-600/70 font-semibold">Cerrado</span>
              </div>
              <div class="mt-3 pt-3 border-t border-amber-600/20">
                <p class="text-amber-300/70 text-[11px] italic">
                  <i class="fa-solid fa-moon mr-1"></i>
                  Zona horaria: UTC-3
                </p>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
    
  </div>
</div>
