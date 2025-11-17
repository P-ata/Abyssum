<?php
declare(strict_types=1);

session_start();

// base del proyecto (un nivel arriba de /public)
define('BASE_PATH', dirname(__DIR__));

// includes con ruta absoluta
require_once BASE_PATH . '/classes/Sections.php';
require_once BASE_PATH . '/admin/classes/AdminSections.php';
require_once BASE_PATH . '/includes/auth.php';

// =======================
// ruta especial para archivos
// =======================
if (isset($_GET['file_id'])) {
    require_once BASE_PATH . '/admin/classes/File.php';
    $fileId = (int)$_GET['file_id'];
    File::serveById($fileId);
    exit;
}

$section = $_GET['sec'] ?? null;

// =======================
// rutas para el admin
// =======================
if ($section === 'admin') {

    $adminPage = $_GET['page'] ?? null;
    $adminAction = $_GET['action'] ?? null;

    // acciones admin (no requieren auth para login/logout)
    if ($adminAction === 'login') {
        require BASE_PATH . '/admin/actions/login.php';
        exit;
    }

    if ($adminAction === 'logout') {
        require BASE_PATH . '/admin/actions/logout.php';
        exit;
    }

    // resto de acciones admin requieren autenticación
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

    // /admin/login (GET - no requiere auth)
    if ($adminPage === 'login') {
        // verificar si la DB está disponible antes de mostrar login
        require_once BASE_PATH . '/classes/DbConnection.php';
        try {
            DbConnection::get(); // Intentar conectar
        } catch (Exception $e) {
            // si falla, ya debería haber redirigido desde DbConnection::get()
            // pero por las redirigir manual
            header('Location: /?sec=admin&page=health&error=db');
            exit;
        }
        require BASE_PATH . '/admin/views/login.php';
        exit;
    }

    // permitir health sin auth SOLO si viene con parámetro error 
    if ($adminPage === 'health' && isset($_GET['error'])) {
        require BASE_PATH . '/admin/views/partials/admin-head.php';
        echo '<main class="flex-grow">';
        require BASE_PATH . '/admin/views/health.php';
        echo '</main>';
        require BASE_PATH . '/admin/views/partials/admin-footer.php';
        exit;
    }

    // resto del admin requiere estar logueado
    requireAdmin();

    // /admin sin page → redirect a dashboard con parámetro visible
    if (!$adminPage) {
        header('Location: /?sec=admin&page=dashboard');
        exit;
    }

    // cargar vista admin
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
// acciones publicas
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
    
    // acción no válida
    header('Location: /?sec=404');
    exit;
}

// =======================
// rutas publicas
// =======================

// permitir página de error de DB sin validación
if ($section === 'db-error') {
    require BASE_PATH . '/views/db-error.php';
    exit;
}

try {
    $validSections = Sections::validSections();
    $menuSections  = Sections::menuSections();
} catch (Exception $e) {
    // si falla la carga de secciones (DB error) redirigir a página de error
    header('Location: /?sec=db-error');
    exit;
}

// si no vino nada  redirect a abyssum con parámetro visible
if (!$section) {
    header('Location: /?sec=abyssum');
    exit;
}

// si no es válida → 404
$view = in_array($section, $validSections, true) ? $section : '404';

try {
    $sections = Sections::sectionsOfSite();
} catch (Exception $e) {
    $sections = [];
}

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