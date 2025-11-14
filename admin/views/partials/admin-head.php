<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($adminTitle ?? 'Panel') ?></title>
  <link rel="stylesheet" href="/assets/admin/css/tailwind.css?v=<?= time() ?>" />
  
  <!-- Vite dev server para módulos ES (development) -->
  <?php if (($_SERVER['SERVER_NAME'] ?? 'localhost') === 'localhost'): ?>
    <script type="module" src="http://localhost:5173/@vite/client"></script>
  <?php endif; ?>
  
  <!-- GSAP for animations -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
  
  <!-- Toast system -->
  <script src="/assets/admin/js/toast.js"></script>
  
  <!-- JS específico por vista admin (como módulos ES) -->
  <?php if (($adminView ?? '') === 'dashboard'): ?>
    <script type="module" src="http://localhost:5173/public/assets/admin/js/dashboard.js"></script>
  <?php endif; ?>
  <?php if (($adminView ?? '') === 'new-pact'): ?>
    <script type="module" src="http://localhost:5173/public/assets/admin/js/new-pact.js"></script>
  <?php endif; ?>
  <?php if (($adminView ?? '') === 'new-demon'): ?>
    <script type="module" src="http://localhost:5173/public/assets/admin/js/new-demon.js"></script>
  <?php endif; ?>
  <?php if (($adminView ?? '') === 'edit-pact'): ?>
    <script type="module" src="http://localhost:5173/public/assets/admin/js/edit-pact.js"></script>
  <?php endif; ?>
  <?php if (($adminView ?? '') === 'edit-demon'): ?>
    <script type="module" src="http://localhost:5173/public/assets/admin/js/edit-demon.js"></script>
  <?php endif; ?>
</head>
<body class="bg-black text-white">
