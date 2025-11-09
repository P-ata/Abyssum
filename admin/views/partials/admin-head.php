<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($adminTitle ?? 'Panel') ?></title>
  <link rel="stylesheet" href="/assets/admin/css/tailwind.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
  <script src="/assets/admin/js/dashboard.js" defer></script>
  <?php if (($adminView ?? '') === 'new-pact'): ?>
    <script src="/assets/admin/js/new-pact.js" defer></script>
  <?php endif; ?>
</head>
<body class="bg-black text-white">
