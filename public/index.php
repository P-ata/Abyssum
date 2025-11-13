<?php
declare(strict_types=1);

session_start();

// Base del proyecto (un nivel arriba de /public)
define('BASE_PATH', dirname(__DIR__));

// Includes con ruta absoluta
require_once BASE_PATH . '/classes/Sections.php';
require_once BASE_PATH . '/admin/classes/AdminSections.php';
require_once BASE_PATH . '/includes/auth.php';

// =======================
// RUTA ESPECIAL: SERVIR ARCHIVOS DESDE BD
// =======================
if (isset($_GET['file_id'])) {
    require_once BASE_PATH . '/admin/classes/File.php';
    $fileId = (int)$_GET['file_id'];
    File::serve($fileId);
    exit;
}

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

    // /admin/actions/login (POST handler - NO requiere auth)
    if ($adminRoute === 'actions/login' || $adminRoute === 'actions/login') {
        require BASE_PATH . '/admin/actions/login.php';
        exit;
    }

    // /admin/actions/logout (session destroy - NO requiere auth)
    if ($adminRoute === 'actions/logout' || $adminRoute === 'actions/logout') {
        require BASE_PATH . '/admin/actions/logout.php';
        exit;
    }

    // /admin/actions/edit-pact (POST)
    if ($adminRoute === 'actions/edit-pact') {
        require BASE_PATH . '/admin/actions/edit-pact.php';
        exit;
    }

    // /admin/actions/delete-pact (GET/POST)
    if ($adminRoute === 'actions/delete-pact') {
        require BASE_PATH . '/admin/actions/delete-pact.php';
        exit;
    }

    // /admin/actions/create-demon (POST)
    if ($adminRoute === 'actions/create-demon') {
        require BASE_PATH . '/admin/actions/create-demon.php';
        exit;
    }

    // /admin/actions/edit-demon (POST)
    if ($adminRoute === 'actions/edit-demon') {
        require BASE_PATH . '/admin/actions/edit-demon.php';
        exit;
    }

    // /admin/actions/delete-demon (GET/POST)
    if ($adminRoute === 'actions/delete-demon') {
        require BASE_PATH . '/admin/actions/delete-demon.php';
        exit;
    }

    // /admin/actions/delete-demon (GET/POST)
    if ($adminRoute === 'actions/delete-demon') {
        require BASE_PATH . '/admin/actions/delete-demon.php';
        exit;
    }

    // /admin/login (GET form view - NO requiere auth)
    if ($adminRoute === 'login') {
        require BASE_PATH . '/admin/views/login.php';
        exit;
    }

    // /admin/logout (legacy, redirect to action)
    if ($adminRoute === 'logout') {
        require BASE_PATH . '/admin/actions/logout.php';
        exit;
    }

    // resto del admin requiere estar logueado
    requireAdmin();

    // /admin → redirigir a /admin/dashboard para URL consistente
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