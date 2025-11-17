  <footer class="mt-10 text-center text-xs text-amber-600/40 font-mono">
    <!-- Admin footer placeholder -->
    // ABYSSUM_ADMIN :: v1.0
  </footer>
  
  <!-- Toast system (always load for manual toasts) -->
  <script src="/assets/admin/js/toast.js"></script>
  
  <!-- Search system (for lists with search) -->
  <script src="/assets/admin/js/search.js"></script>
  
  <!-- Toast data injection -->
  <?php
  require_once BASE_PATH . '/admin/classes/Toast.php';
  if (Toast::hasToasts()) {
    $toasts = Toast::getAll();
    echo '<script>window.TOAST_DATA = ' . json_encode($toasts) . ';</script>';
  }
  ?>
</body>
</html>
