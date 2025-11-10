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

    // /admin → redirigir a /admin/dashboard para URL consistente
    if ($adminRoute === '') {
        header('Location: /admin/dashboard');
        exit;
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
    <?php require BASE_PATH . '/admin/views/partials/admin-head.php'; ?>
    <main>
        <?php require BASE_PATH . '/admin/views/' . $adminView . '.php'; ?>
    </main>
    <?php require BASE_PATH . '/admin/views/partials/admin-footer.php'; ?>
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
<?php require BASE_PATH . '/views/partials/head.php'; ?>
<main>
    <?php require BASE_PATH . '/views/' . $view . '.php'; ?>
</main>
<?php require BASE_PATH . '/views/partials/footer.php'; ?>