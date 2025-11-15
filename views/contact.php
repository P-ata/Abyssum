<?php
// No hay mensaje de éxito específico, se usa Toast
?>

<div class="min-h-screen bg-black text-white py-12 px-4 relative overflow-hidden">
  <!-- Grid cyberpunk background -->
  <div class="fixed inset-0 opacity-20 pointer-events-none">
    <div class="absolute inset-0" style="background-image: linear-gradient(cyan 1px, transparent 1px), linear-gradient(90deg, cyan 1px, transparent 1px); background-size: 50px 50px;"></div>
  </div>
  
  <!-- Glowing orbs -->
  <div class="fixed top-20 left-20 w-96 h-96 bg-cyan-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
  <div class="fixed bottom-20 right-20 w-96 h-96 bg-fuchsia-500 rounded-full blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>

  <div class="max-w-3xl mx-auto relative z-10">
    
    <!-- TÍTULO -->
    <h1 class="text-5xl font-bold text-center mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-fuchsia-500 to-purple-600 font-mono tracking-wider" data-main-title>
      📡 CONTACTO
    </h1>
    <p class="text-center text-cyan-300 mb-8 text-sm font-mono">
      // Envía_tu_mensaje_al_abismo.exe
    </p>
    
    <!-- FORMULARIO -->
    <div class="bg-black/70 border-2 border-cyan-600/40 rounded-lg p-8 backdrop-blur-sm">
      <form method="POST" action="/?sec=actions&action=send-contact" class="space-y-6">
        
        <!-- Nombre -->
        <div>
          <label for="name" class="block text-cyan-300 font-mono text-sm mb-2">
            &gt; NOMBRE_COMPLETO:
          </label>
          <input 
            type="text" 
            id="name" 
            name="name" 
            required
            maxlength="120"
            class="w-full bg-black/50 border border-cyan-500/30 rounded px-4 py-3 text-white font-mono focus:outline-none focus:border-fuchsia-500/50 transition"
            placeholder="Tu nombre..."
          >
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-cyan-300 font-mono text-sm mb-2">
            &gt; EMAIL_ADDRESS:
          </label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            required
            maxlength="190"
            class="w-full bg-black/50 border border-cyan-500/30 rounded px-4 py-3 text-white font-mono focus:outline-none focus:border-fuchsia-500/50 transition"
            placeholder="tu@email.com"
          >
        </div>

        <!-- Asunto -->
        <div>
          <label for="subject" class="block text-cyan-300 font-mono text-sm mb-2">
            &gt; SUBJECT (opcional):
          </label>
          <input 
            type="text" 
            id="subject" 
            name="subject"
            maxlength="200"
            class="w-full bg-black/50 border border-cyan-500/30 rounded px-4 py-3 text-white font-mono focus:outline-none focus:border-fuchsia-500/50 transition"
            placeholder="Asunto del mensaje..."
          >
        </div>

        <!-- Mensaje -->
        <div>
          <label for="message" class="block text-cyan-300 font-mono text-sm mb-2">
            &gt; MESSAGE_CONTENT:
          </label>
          <textarea 
            id="message" 
            name="message" 
            required
            rows="8"
            class="w-full bg-black/50 border border-cyan-500/30 rounded px-4 py-3 text-white font-mono focus:outline-none focus:border-fuchsia-500/50 transition resize-none"
            placeholder="Escribe tu mensaje aquí..."
          ></textarea>
        </div>

        <!-- Botón -->
        <div class="flex gap-4">
          <a href="/" class="flex-1 bg-black/70 hover:bg-cyan-900/30 border border-cyan-500/50 text-cyan-300 px-6 py-3 rounded font-bold text-center font-mono transition">
            ← VOLVER
          </a>
          <button 
            type="submit"
            class="flex-1 bg-gradient-to-r from-cyan-500 to-fuchsia-600 hover:from-cyan-400 hover:to-fuchsia-500 text-black px-6 py-3 rounded font-bold font-mono shadow-[0_0_20px_rgba(0,255,255,0.5)] transition">
            📡 ENVIAR MENSAJE
          </button>
        </div>
      </form>
    </div>

    <!-- Info adicional -->
    <div class="mt-8 text-center text-cyan-500/50 text-xs font-mono">
      <p>// Tu mensaje será procesado por nuestros administradores</p>
      <p>// Tiempo de respuesta estimado: 24-48 horas</p>
    </div>
    
  </div>
</div>
