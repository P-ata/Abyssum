<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../../classes/Pact.php';
require_once __DIR__ . '/../../classes/DbConnection.php';
require_once __DIR__ . '/../classes/File.php';
require_once __DIR__ . '/../classes/Toast.php';
require_once __DIR__ . '/../includes/functions.php';

// return a la pagina de donde vino
$returnTo = isset($_GET['return_to']) ? htmlspecialchars($_GET['return_to']) : 'dashboard';

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=admin');
    exit;
}

$demon_id = (int)($_POST['demon_id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$price_credits = (int)($_POST['price_credits'] ?? 0);
$summary = trim($_POST['summary'] ?? '');
$duration = trim($_POST['duration'] ?? '');
$cooldown = trim($_POST['cooldown'] ?? '');

// limitaciones como array
$limitations = [];
if (!empty($_POST['limitation_1'])) $limitations[] = trim($_POST['limitation_1']);
if (!empty($_POST['limitation_2'])) $limitations[] = trim($_POST['limitation_2']);
if (!empty($_POST['limitation_3'])) $limitations[] = trim($_POST['limitation_3']);

// categorías seleccionadas
$selectedCategories = $_POST['categories'] ?? [];

if ($demon_id === 0 || $name === '') {
    Toast::error('Demonio y nombre son requeridos');
    header('Location: /?sec=admin&page=new-pact');
    exit;
}

// se genera el slug si no se escribio
if ($slug === '') {
    $slug = generateSlug($name);
}

// subida de imagen
$imageFileId = null;
if (!empty($_FILES['image']['tmp_name'])) {
    try {
        $imageFileId = File::upload($_FILES['image'], 'pact');
    } catch (Exception $e) {
        // Check if it's a duplicate file
        if (str_starts_with($e->getMessage(), 'ARCHIVO_DUPLICADO:')) {
            $imageFileId = (int)substr($e->getMessage(), strlen('ARCHIVO_DUPLICADO:'));
            Toast::info('Imagen ya existente en la base de datos, reutilizando archivo');
        } else {
            Toast::error('Error al subir imagen: ' . $e->getMessage());
            header('Location: /?sec=admin&page=new-pact');
            exit;
        }
    }
}

try {
    $data = [
        'slug' => $slug,
        'demon_id' => $demon_id,
        'name' => $name,
        'summary' => $summary !== '' ? $summary : null,
        'duration' => $duration !== '' ? $duration : null,
        'cooldown' => $cooldown !== '' ? $cooldown : null,
        'limitations' => !empty($limitations) ? $limitations : null,
        'price_credits' => $price_credits,
    ];

    // se le pone la imagen subida
    if ($imageFileId !== null) {
        $data['image_file_id'] = $imageFileId;
    }

    $newPactId = Pact::create($data);
    
    // insertar categorías
    if (!empty($selectedCategories)) {
        $pdo = DbConnection::get();
        $insertStmt = $pdo->prepare('INSERT INTO pact_categories (pact_id, category_slug) VALUES (?, ?)');
        foreach ($selectedCategories as $categorySlug) {
            $insertStmt->execute([$newPactId, $categorySlug]);
        }
    }
    
    Toast::success('Pacto creado exitosamente');
} catch (Throwable $e) {
    Toast::error('Error al crear el pacto: ' . $e->getMessage());
}

header('Location: /?sec=admin&page=' . $returnTo);
exit;
