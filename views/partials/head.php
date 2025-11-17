<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($sectionTitle ?? '') ?></title>
  <link rel="canonical" href="https://tailwindcss.com" />
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <!-- Tailwind CSS (público) -->
  <link rel="stylesheet" href="/assets/css/tailwind.css?v=<?= time() ?>" />
  
  <!-- Vite dev server para módulos ES (development) -->
  <?php if (($_SERVER['SERVER_NAME'] ?? 'localhost') === 'localhost'): ?>
    <script type="module" src="http://localhost:5173/@vite/client"></script>
  <?php endif; ?>
  
  <!-- JS específico por vista (como módulos ES) -->
  <?php if (($view ?? '') === 'pacts'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/pacts.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'demons'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/demons.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'abyssum'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/abyssum.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'contact'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/contact.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'profile'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/profile.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'orders'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/orders.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'cart'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/cart.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'login'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/login.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'register'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/register.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'pact-detail'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/pact-detail.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'demon-detail'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/demon-detail.js"></script>
  <?php endif; ?>
  <?php if (($view ?? '') === 'sellador'): ?>
    <script type="module" src="http://localhost:5173/public/assets/js/sellador.js"></script>
  <?php endif; ?>
</head>
<body class="flex flex-col min-h-screen bg-black">
