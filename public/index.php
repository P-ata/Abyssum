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
// RESOLVER RUTA CON PARÁMETROS GET EXPLÍCITOS
// =======================

// Sistema de routing con parámetros visibles:
// Público: ?sec=pacts
// Admin: ?sec=admin&page=dashboard
// Acciones: ?sec=actions&action=login o ?sec=admin&action=create-pact

$section = $_GET['sec'] ?? null;

// =======================
// RUTAS ADMIN
// =======================
if ($section === 'admin') {

    $adminPage = $_GET['page'] ?? null;
    $adminAction = $_GET['action'] ?? null;

    // Admin actions (no requieren auth para login/logout)
    if ($adminAction === 'login') {
        require BASE_PATH . '/admin/actions/login.php';
        exit;
    }

    if ($adminAction === 'logout') {
        require BASE_PATH . '/admin/actions/logout.php';
        exit;
    }

    // Resto de acciones admin requieren autenticación
    if ($adminAction) {
        requireAdmin();
        
        $validActions = [
            'edit-pact', 'create-pact', 'delete-pact',
            'create-demon', 'edit-demon', 'delete-demon',
            'toggle-user-status', 'assign-role', 'remove-role', 'update-roles',
            'fulfill-order', 'cancel-order', 'update-contact-status'
        ];
        
        if (in_array($adminAction, $validActions, true)) {
            require BASE_PATH . '/admin/actions/' . $adminAction . '.php';
            exit;
        }
    }

    // /admin/login (GET form view - NO requiere auth)
    if ($adminPage === 'login') {
        require BASE_PATH . '/admin/views/login.php';
        exit;
    }

    // resto del admin requiere estar logueado
    requireAdmin();

    // /admin sin page → redirect a dashboard con parámetro visible
    if (!$adminPage) {
        header('Location: /?sec=admin&page=dashboard');
        exit;
    }

    // Cargar vista admin
    $validAdmin = AdminSections::validSections();
    $adminView  = in_array($adminPage, $validAdmin, true) ? $adminPage : '404';

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
// ACCIONES PÚBLICAS
// =======================
if ($section === 'actions') {
    $action = $_GET['action'] ?? null;
    
    $validActions = [
        'login', 'logout', 'register',
        'add-to-cart', 'remove-from-cart', 'checkout', 'clear-cart',
        'update-profile', 'change-password',
        'cancel-order', 'send-contact'
    ];
    
    if ($action && in_array($action, $validActions, true)) {
        require BASE_PATH . '/actions/' . $action . '.php';
        exit;
    }
    
    // Acción no válida
    header('Location: /?sec=404');
    exit;
}

// =======================
// RUTAS PÚBLICAS
// =======================
$validSections = Sections::validSections();
$menuSections  = Sections::menuSections();

// si no vino nada → redirect a abyssum con parámetro visible
if (!$section) {
    header('Location: /?sec=abyssum');
    exit;
}

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
<?php require BASE_PATH . '/views/partials/header.php'; ?>
<main class="flex-grow">
    <?php require BASE_PATH . '/views/' . $view . '.php'; ?>
</main>
<?php require BASE_PATH . '/views/partials/footer.php'; ?>