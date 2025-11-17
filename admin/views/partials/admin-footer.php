  <footer class="mt-10 text-center text-xs text-amber-600/40 font-mono">
  
  </footer>

  <!-- modal de confirmación de eliminación -->
  <div id="deleteModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="bg-black border-2 border-red-600/40 rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl shadow-red-500/20">
      <div class="flex items-center gap-4 mb-6">
        <div class="w-12 h-12 rounded-full bg-red-600/20 flex items-center justify-center">
          <i class="fa-solid fa-exclamation-triangle text-red-500 text-xl"></i>
        </div>
        <div>
          <h3 class="text-xl font-bold text-red-500 tracking-wider">CONFIRMAR ELIMINACIÓN</h3>
          <p class="text-xs text-amber-600/70 uppercase tracking-widest">// Esta acción no se puede deshacer</p>
        </div>
      </div>
      
      <p class="text-amber-300 text-sm mb-6 leading-relaxed" id="deleteModalMessage">
        ¿Estás seguro de que deseas eliminar este elemento?
      </p>
      
      <div class="flex gap-3">
        <button id="cancelDelete" class="flex-1 px-4 py-2.5 rounded border border-amber-600/40 bg-black/60 hover:bg-amber-600/10 text-amber-500 text-sm tracking-wide transition">
          CANCELAR
        </button>
        <a id="confirmDelete" href="#" class="flex-1 px-4 py-2.5 rounded border border-red-600/40 bg-red-900/30 hover:bg-red-900/50 text-red-500 text-sm font-bold tracking-wide transition text-center">
          ELIMINAR
        </a>
      </div>
    </div>
  </div>
  
  <!-- toasts -->
  <script src="/assets/admin/js/toast.js"></script>
  
  <script src="/assets/admin/js/search.js"></script>

  <!-- script del modal -->
  <script>
    const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const deleteModalMessage = document.getElementById('deleteModalMessage');

    function showDeleteModal(url, message) {
      deleteModalMessage.textContent = message;
      confirmDelete.href = url;
      deleteModal.classList.remove('hidden');
      deleteModal.classList.add('flex');
    }

    function hideDeleteModal() {
      deleteModal.classList.add('hidden');
      deleteModal.classList.remove('flex');
    }

    cancelDelete?.addEventListener('click', hideDeleteModal);
    deleteModal?.addEventListener('click', (e) => {
      if (e.target === deleteModal) hideDeleteModal();
    });

    // cerrar con ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
        hideDeleteModal();
      }
    });
  </script>
  
  <!-- si hay toasts -->
  <?php
  require_once BASE_PATH . '/admin/classes/Toast.php';
  if (Toast::hasToasts()) {
    $toasts = Toast::getAll();
    echo '<script>window.TOAST_DATA = ' . json_encode($toasts) . ';</script>';
  }
  ?>
</body>
</html>
