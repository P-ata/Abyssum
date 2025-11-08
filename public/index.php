<?php
declare(strict_types=1);

session_start();

// Base del proyecto (un nivel arriba de /public)
define('BASE_PATH', dirname(__DIR__));

// Includes con ruta absoluta
require_once BASE_PATH . '/classes/Sections.php';
require_once BASE_PATH . '/admin/classes/AdminSections.php';
require_once BASE_PATH . '/admin/auth.php';

// =======================
// RESOLVER RUTA UNA SOLA VEZ
// =======================

// Primero intento con URL linda: /algo, /admin/login, etc.
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Si hay algo en el path, eso es la ruta.
// Si no hay nada (estás en "/"), uso ?r= si existe; sino queda null.
if ($path !== '') {
    $route = $path;              // ej: "abyssum", "admin/login"
} else {
    $route = $_GET['r'] ?? null; // compatibilidad: ?r=...
}

// =======================
// RUTAS ADMIN (MISMA LÓGICA, PREFIJO admin)
// =======================
if ($route !== null && str_starts_with($route, 'admin')) {

    // se saca el admin/ para ver que le sigue
    $adminRoute = trim(substr($route, strlen('admin')), '/');

    // /admin/login
    if ($adminRoute === 'login') {
        require BASE_PATH . '/admin/login.php';
        exit;
    }

    // /admin/logout
    if ($adminRoute === 'logout') {
        require BASE_PATH . '/admin/logout.php';
        exit;
    }

    // resto del admin requiere estar logueado
    if (!isAdmin()) {
        header('Location: /admin/login');
        exit;
    }

    // /admin → dashboard por defecto
    if ($adminRoute === '') {
        $adminRoute = 'dashboard';
    }

    // misma lógica que público pero con AdminSections
    $validAdmin = AdminSections::validSections();
    $adminView  = in_array($adminRoute, $validAdmin, true) ? $adminRoute : '404';

    $adminSections = AdminSections::sectionsOfSite();
    $adminTitle    = 'Panel de administración';

    foreach ($adminSections as $section) {
        if ($section->getUrl() === $adminView) {
            $adminTitle = $section->getTitle();
            break;
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($adminTitle) ?></title>
        <link rel="stylesheet" href="/assets/admin/css/tailwind.css">
        <!-- GSAP for admin animations -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
        <script src="/assets/admin/js/dashboard.js" defer></script>
        <?php if ($adminView === 'new-pact'): ?>
        <script src="/assets/admin/js/new-pact.js" defer></script>
        <?php endif; ?>
    </head>
    <body class="bg-black text-white">
        <main>
            <?php require BASE_PATH . '/admin/views/' . $adminView . '.php'; ?>
        </main> 
    </body>
    </html>
    <?php
    exit;
}

// =======================
// RUTAS PÚBLICAS (MISMA IDEA QUE YA TENÍAS)
// =======================

$validSections = Sections::validSections();
$menuSections  = Sections::menuSections();

// si no vino nada → abyssum
$section = $route ?? 'abyssum';

// si no es válida → 404
$view = in_array($section, $validSections, true) ? $section : '404';

$sections = Sections::sectionsOfSite();
$sectionTitle = '';

foreach ($sections as $value) {
    if ($value->getUrl() === $view) {
        $sectionTitle = $value->getTitle();
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($sectionTitle) ?></title>

  <link rel="canonical" href="https://tailwindcss.com">
  <link rel="stylesheet" href="/assets/css/tailwind.css">

  <!-- GSAP -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

  <!-- JS -->
  <script type="module" src="/assets/js/pacts.js"></script>
  <script type="module" src="/assets/js/demons.js"></script>
</head>
<body>
  <main>
    <?php require BASE_PATH . '/views/' . $view . '.php'; ?>
  </main>
</body>
</html>