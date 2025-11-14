<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../../classes/Pact.php';
require_once __DIR__ . '/../../classes/Demon.php';
require_once __DIR__ . '/../classes/File.php';
require_once __DIR__ . '/../classes/Toast.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/dashboard');
    exit;
}

// Get pact ID
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    Toast::error('ID de pacto inválido');
    header('Location: /admin/dashboard');
    exit;
}

// Load existing pact
$pact = Pact::find($id);
if (!$pact) {
    Toast::error('Pacto no encontrado');
    header('Location: /admin/pacts');
    exit;
}

// Required fields
$demon_id = isset($_POST['demon_id']) ? (int)$_POST['demon_id'] : 0;
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');

if ($demon_id === 0 || $name === '') {
    Toast::error('Demonio y nombre son requeridos');
    header('Location: /admin/edit-pact?id=' . $id);
    exit;
}

// Auto-generate slug if empty
if ($slug === '') {
    $slug = generateSlug($name);
}

// Handle image upload
$currentImageFileId = !empty($_POST['current_image_file_id']) ? (int)$_POST['current_image_file_id'] : null;
$imageFileId = $currentImageFileId;

if (!empty($_FILES['image']['tmp_name'])) {
    try {
        $imageFileId = File::upload($_FILES['image'], 'pact');
        
        // Delete old image from DB if exists and it's different
        if ($currentImageFileId && $currentImageFileId !== $imageFileId) {
            File::delete($currentImageFileId);
        }
    } catch (Exception $e) {
        // Check if it's a duplicate file
        if (str_starts_with($e->getMessage(), 'DUPLICATE_FILE:')) {
            $imageFileId = (int)substr($e->getMessage(), strlen('DUPLICATE_FILE:'));
            Toast::info('Imagen ya existente en la base de datos, reutilizando archivo');
            
            // Delete old image if it's different
            if ($currentImageFileId && $currentImageFileId !== $imageFileId) {
                File::delete($currentImageFileId);
            }
        } else {
            Toast::error('Error al subir imagen: ' . $e->getMessage());
            header('Location: /admin/edit-pact?id=' . urlencode((string)$id));
            exit;
        }
    }
}

// Optional fields
$summary = trim($_POST['summary'] ?? '');
$duration = trim($_POST['duration'] ?? '');
$cooldown = trim($_POST['cooldown'] ?? '');
$price_credits = !empty($_POST['price_credits']) ? (int)$_POST['price_credits'] : 0;

// Limitations (JSON array)
$limitations = [];
for ($i = 1; $i <= 3; $i++) {
    $limitation = trim($_POST["limitation_$i"] ?? '');
    if ($limitation !== '') {
        $limitations[] = $limitation;
    }
}

try {
    $data = [
        'demon_id' => $demon_id,
        'name' => $name,
        'slug' => $slug,
        'price_credits' => $price_credits,
    ];

    // Add optional fields
    if ($summary !== '') $data['summary'] = $summary;
    if ($duration !== '') $data['duration'] = $duration;
    if ($cooldown !== '') $data['cooldown'] = $cooldown;
    if ($imageFileId !== null) $data['image_file_id'] = $imageFileId;
    if (!empty($limitations)) $data['limitations'] = $limitations;

    Pact::update($id, $data);
    Toast::success('Pacto actualizado exitosamente');
} catch (Throwable $e) {
    Toast::error('Error al actualizar el pacto: ' . $e->getMessage());
}

header('Location: /admin/dashboard');
exit;
