<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($adminTitle ?? 'Panel') ?></title>
  <link rel="stylesheet" href="/assets/admin/css/tailwind.css" />
  
  <!-- Vite dev server para módulos ES (development) -->
  <?php if (($_SERVER['SERVER_NAME'] ?? 'localhost') === 'localhost'): ?>
    <script type="module" src="http://localhost:5173/@vite/client"></script>
  <?php endif; ?>
  
  <!-- JS específico por vista admin (como módulos ES) -->
  <script type="module" src="http://localhost:5173/public/assets/admin/js/dashboard.js"></script>
  <?php if (($adminView ?? '') === 'new-pact'): ?>
    <script type="module" src="http://localhost:5173/public/assets/admin/js/new-pact.js"></script>
  <?php endif; ?>
</head>
<body class="bg-black text-white">
