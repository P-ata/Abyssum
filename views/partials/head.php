<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($sectionTitle ?? '') ?></title>
  <link rel="canonical" href="https://tailwindcss.com" />
  <!-- Tailwind CSS (público) -->
  <link rel="stylesheet" href="/assets/css/tailwind.css" />
  
  <!-- Vite dev server para módulos ES (development) -->
  <?php if (($_SERVER['SERVER_NAME'] ?? 'localhost') === 'localhost'): ?>
    <script type="module" src="http://localhost:5173/@vite/client"></script>
  <?php endif; ?>
  
  <!-- JS específico por vista (como módulos ES) -->
  <?php if (($view ?? '') === 'pacts'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/pacts.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'abyssum'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/demons.js"></script>
  <?php endif; ?>
</head>
<body>
