<!-- CARRITO -->
<div class="min-h-screen bg-black text-white py-12 px-4">
  <div class="max-w-5xl mx-auto">
    
    <!-- TÍTULO -->
    <h1 class="text-4xl font-bold text-amber-500 mb-8">🛒 TU CARRITO</h1>
    
    <!-- CONTENEDOR DE ITEMS -->
    <div id="cart-container" class="bg-gray-900 border-2 border-amber-600 rounded-lg p-6 mb-6">
      <!-- Se llena con JS -->
    </div>
    
    <!-- TOTAL -->
    <div class="bg-gray-900 border-2 border-amber-600 rounded-lg p-6 flex justify-between items-center mb-6">
      <span class="text-2xl font-bold text-amber-400">TOTAL:</span>
      <span id="cart-total" class="text-4xl font-bold text-amber-500">0 ⛧</span>
    </div>
    
    <!-- BOTONES -->
    <div class="flex gap-4">
      <a href="/pacts" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded font-bold flex-1 text-center">
        ← SEGUIR COMPRANDO
      </a>
      <button onclick="checkout()" class="bg-amber-600 hover:bg-amber-700 text-black px-6 py-3 rounded font-bold flex-1">
        FINALIZAR COMPRA
      </button>
      <button onclick="clearCart()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded font-bold">
        VACIAR
      </button>
    </div>
    
  </div>
</div>

<script>
// CARGAR CARRITO
function loadCart() {
  const cart = JSON.parse(localStorage.getItem('cart') || '[]');
  const container = document.getElementById('cart-container');
  const totalEl = document.getElementById('cart-total');
  
  if (cart.length === 0) {
    container.innerHTML = '<p class="text-gray-400 text-center py-8">Tu carrito está vacío</p>';
    totalEl.textContent = '0 ⛧';
    return;
  }
  
  let html = '<div class="space-y-4">';
  let total = 0;
  
  cart.forEach((item, index) => {
    const subtotal = item.price * item.quantity;
    total += subtotal;
    
    html += `
      <div class="bg-gray-800 p-4 rounded flex justify-between items-center">
        <div>
          <h3 class="font-bold text-lg text-amber-400">${item.name}</h3>
          <p class="text-gray-400 text-sm">Precio: ${item.price} ⛧</p>
        </div>
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-2">
            <button onclick="updateQuantity(${index}, -1)" class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded font-bold">-</button>
            <span class="font-bold text-lg">${item.quantity}</span>
            <button onclick="updateQuantity(${index}, 1)" class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded font-bold">+</button>
          </div>
          <div class="text-right">
            <p class="font-bold text-amber-500">${subtotal} ⛧</p>
          </div>
          <button onclick="removeItem(${index})" class="text-red-500 hover:text-red-400 font-bold text-xl">✕</button>
        </div>
      </div>
    `;
  });
  
  html += '</div>';
  container.innerHTML = html;
  totalEl.textContent = total + ' ⛧';
}

function updateQuantity(index, change) {
  let cart = JSON.parse(localStorage.getItem('cart') || '[]');
  cart[index].quantity += change;
  
  if (cart[index].quantity <= 0) {
    cart.splice(index, 1);
  }
  
  localStorage.setItem('cart', JSON.stringify(cart));
  localStorage.setItem('cartCount', cart.reduce((sum, item) => sum + item.quantity, 0));
  loadCart();
  if (window.updateCartCount) updateCartCount();
}

function removeItem(index) {
  let cart = JSON.parse(localStorage.getItem('cart') || '[]');
  cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  localStorage.setItem('cartCount', cart.reduce((sum, item) => sum + item.quantity, 0));
  loadCart();
  if (window.updateCartCount) updateCartCount();
}

function clearCart() {
  if (confirm('¿Seguro que querés vaciar el carrito?')) {
    localStorage.removeItem('cart');
    localStorage.setItem('cartCount', '0');
    loadCart();
    if (window.updateCartCount) updateCartCount();
  }
}

function checkout() {
  const cart = JSON.parse(localStorage.getItem('cart') || '[]');
  if (cart.length === 0) {
    alert('El carrito está vacío');
    return;
  }
  
  // ACA VA TU BACKEND - Ejemplo:
  alert('ACA VA TU LÓGICA DE CHECKOUT\\n\\nDatos:\\n' + JSON.stringify(cart, null, 2));
  
  /*
  fetch('/actions/checkout.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ cart: cart })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('¡Compra realizada!');
      clearCart();
      window.location.href = '/';
    }
  });
  */
}

// Cargar al inicio
document.addEventListener('DOMContentLoaded', loadCart);
</script>
    
    <!-- Left Info Panel -->
    <div class="w-[400px] h-[80vh] bg-black/80 border border-amber-600/20 p-8 relative z-10 ml-8">
      <div class="h-full flex flex-col">
        <div class="text-amber-500 text-xs font-mono mb-4 uppercase tracking-wider">Featured</div>
        <h3 class="demon-name text-2xl font-serif mb-3 text-white tracking-wide">Demon Name</h3>
        <p class="demon-description text-sm text-gray-400 font-mono leading-relaxed mb-4">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.
        </p>
        <div class="demon-stats space-y-2">
          <div class="flex items-center">
            <span class="text-amber-600 text-xs">LEVEL:</span>
            <span class="text-gray-300 text-xs ml-2">05</span>
          </div>
          <div class="flex items-center">
            <span class="text-amber-600 text-xs">TYPE:</span>
            <span class="text-gray-300 text-xs ml-2">Arcane</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Center Stage - Main Carousel -->
    <div class="flex-1 h-[80vh] flex flex-col relative">
      <!-- Carousel Track -->
      <div class="flex-1 relative overflow-hidden flex items-center justify-center">
        <div class="relative w-full h-full">
          <!-- Slides will be dynamically inserted here -->
          <div class="carousel-slide active absolute w-full h-full flex items-center justify-center opacity-100">
            <div class="w-full h-full relative flex items-center justify-center px-1">
              <img src="assets/img/demons/1.png" alt="Demon 1" class="w-full h-full object-contain" style="filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.5));">
            </div>
          </div>
          <div class="carousel-slide absolute w-full h-full flex items-center justify-center opacity-0">
            <div class="w-full h-full relative flex items-center justify-center px-1">
              <img src="assets/img/demons/2.png" alt="Demon 2" class="w-full h-full object-contain" style="filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.5));">
            </div>
          </div>
          <div class="carousel-slide absolute w-full h-full flex items-center justify-center opacity-0">
            <div class="w-full h-full relative flex items-center justify-center px-1">
              <img src="assets/img/demons/3.png" alt="Demon 3" class="w-full h-full object-contain" style="filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.5));">
            </div>
          </div>
          <div class="carousel-slide absolute w-full h-full flex items-center justify-center opacity-0">
            <div class="w-full h-full relative flex items-center justify-center px-1">
              <img src="assets/img/demons/4.png" alt="Demon 4" class="w-full h-full object-contain" style="filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.5));">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Info Panel -->
    <div class="w-[400px] h-[80vh] bg-black/80 border border-amber-600/20 p-8 relative z-10 mr-8">
      <div class="h-full flex flex-col">
        <!-- Small Gallery -->
        <div class="grid grid-cols-2 gap-2 mb-6">
          <div class="mini-card aspect-square border border-amber-600/20 p-2 cursor-pointer transition-all bg-black/50 hover:border-amber-600 hover:bg-amber-600/10 hover:shadow-[0_0_20px_rgba(251,191,36,0.2)] active" data-index="0">
            <img src="./assets/img/demons/1.png" alt="Demon 1 thumb" class="w-full h-full object-contain">
          </div>
          <div class="mini-card aspect-square border border-amber-600/20 p-2 cursor-pointer transition-all bg-black/50 hover:border-amber-600 hover:bg-amber-600/10 hover:shadow-[0_0_20px_rgba(251,191,36,0.2)]" data-index="1">
            <img src="./assets/img/demons/2.png" alt="Demon 2 thumb" class="w-full h-full object-contain">
          </div>
          <div class="mini-card aspect-square border border-amber-600/20 p-2 cursor-pointer transition-all bg-black/50 hover:border-amber-600 hover:bg-amber-600/10 hover:shadow-[0_0_20px_rgba(251,191,36,0.2)]" data-index="2">
            <img src="./assets/img/demons/3.png" alt="Demon 3 thumb" class="w-full h-full object-contain">
          </div>
          <div class="mini-card aspect-square border border-amber-600/20 p-2 cursor-pointer transition-all bg-black/50 hover:border-amber-600 hover:bg-amber-600/10 hover:shadow-[0_0_20px_rgba(251,191,36,0.2)]" data-index="3">
            <img src="./assets/img/demons/4.png" alt="Demon 4 thumb" class="w-full h-full object-contain">
          </div>
        </div>

        <!-- Technical Info -->
        <div class="mt-auto">
          <div class="text-amber-600 text-xs font-mono mb-3 uppercase">Technical Data</div>
          <div class="space-y-2 text-xs font-mono text-gray-400">
            <div class="flex justify-between">
              <span>Power:</span>
              <span class="text-amber-500">████░░</span>
            </div>
            <div class="flex justify-between">
              <span>Speed:</span>
              <span class="text-amber-500">███░░░</span>
            </div>
            <div class="flex justify-between">
              <span>Defense:</span>
              <span class="text-amber-500">█████░</span>
            </div>
          </div>
        </div>

        <!-- Bottom corner indicators -->
        <div class="mt-8">
          <div class="text-xs text-gray-600 font-mono">01 ━━━━━━━━ 04</div>
          <div class="text-xs text-amber-600 font-mono mt-2">▸ SCROLL</div>
        </div>
      </div>
    </div>

    

  </div>
</div>