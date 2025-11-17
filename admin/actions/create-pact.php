<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../../classes/Pact.php';
require_once __DIR__ . '/../classes/File.php';
require_once __DIR__ . '/../classes/Toast.php';
require_once __DIR__ . '/../includes/functions.php';

// Get return_to parameter
$returnTo = isset($_GET['return_to']) ? htmlspecialchars($_GET['return_to']) : 'dashboard';

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

// Handle limitations as array
$limitations = [];
if (!empty($_POST['limitation_1'])) $limitations[] = trim($_POST['limitation_1']);
if (!empty($_POST['limitation_2'])) $limitations[] = trim($_POST['limitation_2']);
if (!empty($_POST['limitation_3'])) $limitations[] = trim($_POST['limitation_3']);

if ($demon_id === 0 || $name === '') {
    Toast::error('Demonio y nombre son requeridos');
    header('Location: /?sec=admin&page=new-pact');
    exit;
}

// Auto-generate slug if empty
if ($slug === '') {
    $slug = generateSlug($name);
}

// Handle image upload
$imageFileId = null;
if (!empty($_FILES['image']['tmp_name'])) {
    try {
        $imageFileId = File::upload($_FILES['image'], 'pact');
    } catch (Exception $e) {
        // Check if it's a duplicate file
        if (str_starts_with($e->getMessage(), 'DUPLICATE_FILE:')) {
            $imageFileId = (int)substr($e->getMessage(), strlen('DUPLICATE_FILE:'));
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

    // Add image file ID if uploaded
    if ($imageFileId !== null) {
        $data['image_file_id'] = $imageFileId;
    }

    Pact::create($data);
    Toast::success('Pacto creado exitosamente');
} catch (Throwable $e) {
    Toast::error('Error al crear el pacto: ' . $e->getMessage());
}

header('Location: /?sec=admin&page=' . $returnTo);
exit;
