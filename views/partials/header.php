
<header>
  <nav class="bg-gray-800 text-white p-4 flex justify-between items-center">
    <ul class="flex space-x-4">
      <li><a href="/" class="hover:underline bg-black/50 p-5">HOME</a></li>
      <li><a href="/pacts" class="hover:underline bg-black/50 p-5">PACTOS</a></li>
    </ul>
    <div class="flex gap-4">
      <!-- CARRITO -->
      <a href="/car" class="bg-amber-600 hover:bg-amber-700 text-black px-4 py-2 rounded font-bold flex items-center gap-2">
        🛒 CARRITO
        <span id="cart-count" class="bg-red-600 text-white px-2 py-1 rounded-full text-xs" style="display:none;">0</span>
      </a>
      
      <?php if (isLoggedIn()): ?>
        <!-- MI CUENTA -->
        <a href="/profile" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold">
          👤 MI CUENTA
        </a>
      <?php else: ?>
        <!-- LOGIN -->
        <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-bold">
          LOGIN
        </a>
      <?php endif; ?>
    </div>
  </nav>
  
  <div>
    <!-- Decorative top border -->
    <div class="h-1 bg-gradient-to-r from-amber-500 via-amber-600 to-amber-500"></div>
    <div>
        
    </div>
  </div>
</header>