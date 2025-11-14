<main>
  <?php if (isLoggedIn()): ?>
    <div class="bg-black text-amber-500 border border-amber-600 rounded-lg p-6 m-6">
      <h2 class="text-2xl font-bold">Hola, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?>!</h2>
    </div>
  <?php endif; ?>
</main>