  <footer class="mt-16 text-center text-xs text-gray-600 font-mono">
    <!-- Public footer placeholder -->
    // ABYSSUM :: portal infernal experimental
  </footer>
  
  <!-- Toast System -->
  <?php
  require_once BASE_PATH . '/admin/classes/Toast.php';
  if (Toast::hasToasts()): 
  ?>
    <script>
      window.TOAST_DATA = <?= json_encode(Toast::getAll()) ?>;
    </script>
    <script src="/assets/admin/js/toast.js"></script>
  <?php endif; ?>
</body>
</html>
