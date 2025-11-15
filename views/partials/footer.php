  <footer class="mt-16 text-center text-xs text-gray-600 font-mono">
    <!-- Public footer placeholder -->
    // ABYSSUM :: portal infernal experimental
  </footer>
  
  <!-- GSAP Library for animations -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
  
  <!-- Cart Animations -->
  <script src="/assets/js/cart-animations.js"></script>
  
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
