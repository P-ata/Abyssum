<?php
require_once BASE_PATH . '/classes/Cart.php';
$cartCount = Cart::count();
?>

<header>
  <nav class="bg-gray-800 text-white p-4 flex justify-between items-center">
    <ul class="flex space-x-4">
      <li><a href="/?sec=abyssum" class="hover:underline bg-black/50 p-5">HOME</a></li>
      <li><a href="/?sec=pacts" class="hover:underline bg-black/50 p-5">PACTS</a></li>
      <li><a href="/?sec=contact" class="hover:underline bg-black/50 p-5">CONTACTO</a></li>
    </ul>
    <div class="flex gap-4">
      <!-- CARRITO -->
      <a href="/?sec=cart" class="relative group">
        🛒 CARRITO
        <?php if ($cartCount > 0): ?>
          <span class="bg-red-600 text-white px-2 py-1 rounded-full text-xs font-mono">
            <?= $cartCount ?>
          </span>
        <?php endif; ?>
      </a>
      
      <?php if (isLoggedIn()): ?>
        <!-- MI CUENTA -->
        <a href="/?sec=profile" class="nav-link group relative">
          👤 MI CUENTA
        </a>
      <?php else: ?>
        <!-- LOGIN -->
        <a href="/?sec=login" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-bold">
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