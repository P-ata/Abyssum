<!-- REGISTRO PÚBLICO -->
<div class="min-h-screen bg-black text-white flex items-center justify-center px-4 py-12">
  <div class="bg-gray-900 border-2 border-amber-600 rounded-lg p-8 w-full max-w-md">
    <h1 class="text-3xl font-bold text-amber-500 mb-6 text-center">CREAR CUENTA</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-900 border border-red-600 text-red-200 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>
    
    <form action="/actions/register" method="POST" class="space-y-4">
      <!-- NOMBRE -->
      <div>
        <label class="block text-gray-300 mb-2 font-bold">Nombre:</label>
        <input 
          type="text" 
          name="display_name" 
          required 
          class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-2 text-white focus:border-amber-600 focus:outline-none"
          placeholder="Tu nombre"
        >
      </div>
      
      <!-- EMAIL -->
      <div>
        <label class="block text-gray-300 mb-2 font-bold">Email:</label>
        <input 
          type="email" 
          name="email" 
          required 
          class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-2 text-white focus:border-amber-600 focus:outline-none"
          placeholder="tu@email.com"
        >
      </div>
      
      <!-- PASSWORD -->
      <div>
        <label class="block text-gray-300 mb-2 font-bold">Contraseña:</label>
        <input 
          type="password" 
          name="password" 
          required 
          minlength="6"
          class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-2 text-white focus:border-amber-600 focus:outline-none"
          placeholder="Mínimo 6 caracteres"
        >
      </div>
      
      <!-- SUBMIT -->
      <button 
        type="submit" 
        class="w-full bg-amber-600 hover:bg-amber-700 text-black font-bold py-3 rounded transition"
      >
        REGISTRARSE
      </button>
    </form>
    
    <!-- LINKS -->
    <div class="mt-6 text-center">
      <p class="text-gray-400 text-sm">
        ¿Ya tenés cuenta? <a href="/login" class="text-amber-500 hover:text-amber-400">Iniciá sesión</a>
      </p>
    </div>
  </div>
</div>
