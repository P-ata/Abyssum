<div class="min-h-screen bg-black relative overflow-hidden">
  <!-- Gold border frame -->
  <div class="fixed inset-4 border-2 border-amber-600/60 pointer-events-none z-50"></div>
  
  <!-- Subtle grid background -->
  <div class="fixed inset-0 opacity-5 pointer-events-none">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
  </div>

  <!-- Carousel Container -->
  <div class="flex items-center justify-between h-screen p-8 relative">
    
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

    <!-- Center logo/emblem -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1] pointer-events-none">
      <div class="w-[150px] h-[150px]">
        <svg viewBox="0 0 100 100" class="w-full h-full animate-spin" style="animation-duration: 20s;">
          <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="1" class="text-amber-600/30"/>
          <circle cx="50" cy="50" r="35" fill="none" stroke="currentColor" stroke-width="1" class="text-amber-600/50"/>
          <circle cx="50" cy="50" r="5" fill="currentColor" class="text-amber-600"/>
        </svg>
      </div>
    </div>

  </div>
</div>

<style>
  /* Carousel slide transitions */
  .carousel-slide {
    transition: opacity 0.5s ease, transform 0.5s ease;
    transform: scale(0.8);
  }

  .carousel-slide.active {
    opacity: 1 !important;
    transform: scale(1) !important;
    z-index: 2;
  }

  /* Mini card active state */
  .mini-card.active {
    border-color: rgb(251, 191, 36) !important;
    background: rgba(251, 191, 36, 0.1) !important;
    box-shadow: 0 0 20px rgba(251, 191, 36, 0.2) !important;
  }
</style>
</style>
