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
    header('Location: /?sec=admin&page=' . $returnTo);
    exit;
}

// obtener ID de pacto
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    Toast::error('ID de pacto inválido');
    header('Location: /?sec=admin&page=' . $returnTo);
    exit;
}

// cargar pacto existente
$pact = Pact::find($id);
if (!$pact) {
    Toast::error('Pacto no encontrado');
    header('Location: /?sec=admin&page=pacts');
    exit;
}

// campos requeridos
$demon_id = isset($_POST['demon_id']) ? (int)$_POST['demon_id'] : 0;
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');

if ($demon_id === 0 || $name === '') {
    Toast::error('Demonio y nombre son requeridos');
    header('Location: /?sec=admin&page=edit-pact&id=' . $id);
    exit;
}

// auto-generar slug si está vacío
if ($slug === '') {
    $slug = generateSlug($name);
}

// manejar subida de imagen
$currentImageFileId = !empty($_POST['current_image_file_id']) ? (int)$_POST['current_image_file_id'] : null;
$deleteCurrentImage = !empty($_POST['delete_current_image']) && $_POST['delete_current_image'] === '1';
$imageFileId = $currentImageFileId;

// si se marcó para eliminar la imagen actual
if ($deleteCurrentImage && $currentImageFileId) {
    File::deleteById($currentImageFileId);
    $imageFileId = null;
}

if (!empty($_FILES['image']['tmp_name'])) {
    try {
        $imageFileId = File::upload($_FILES['image'], 'pact');
        
        // borrar imagen vieja de la BD si existe y es diferente
        if ($currentImageFileId && $currentImageFileId !== $imageFileId) {
            File::deleteById($currentImageFileId);
        }
    } catch (Exception $e) {
        // verificar si es un archivo duplicado
        if (str_starts_with($e->getMessage(), 'ARCHIVO_DUPLICADO:')) {
            $imageFileId = (int)substr($e->getMessage(), strlen('ARCHIVO_DUPLICADO:'));
            Toast::info('Imagen ya existente en la base de datos, reutilizando archivo');
            
            // borrar imagen vieja si es diferente
            if ($currentImageFileId && $currentImageFileId !== $imageFileId) {
                File::deleteById($currentImageFileId);
            }
        } else {
            Toast::error('Error al subir imagen: ' . $e->getMessage());
            header('Location: /?sec=admin&page=edit-pact&id=' . urlencode((string)$id));
            exit;
        }
    }
}

// campos opcionales
$summary = trim($_POST['summary'] ?? '');
$duration = trim($_POST['duration'] ?? '');
$cooldown = trim($_POST['cooldown'] ?? '');
$price_credits = !empty($_POST['price_credits']) ? (int)$_POST['price_credits'] : 0;

// Limitaciones (JSON)
$limitations = [];
for ($i = 1; $i <= 3; $i++) {
    $limitation = trim($_POST["limitation_$i"] ?? '');
    if ($limitation !== '') {
        $limitations[] = $limitation;
    }
}

// categorías seleccionadas
$selectedCategories = $_POST['categories'] ?? [];

try {
    $data = [
        'demon_id' => $demon_id,
        'name' => $name,
        'slug' => $slug,
        'price_credits' => $price_credits,
    ];

    // agregar campos opcionales
    if ($summary !== '') $data['summary'] = $summary;
    if ($duration !== '') $data['duration'] = $duration;
    if ($cooldown !== '') $data['cooldown'] = $cooldown;
    if ($imageFileId !== null) $data['image_file_id'] = $imageFileId;
    if (!empty($limitations)) $data['limitations'] = $limitations;

    Pact::update($id, $data);
    
    // actualizar categorías
    $pdo = DbConnection::get();
    
    // eliminar categorías actuales
    $deleteStmt = $pdo->prepare('DELETE FROM pact_categories WHERE pact_id = ?');
    $deleteStmt->execute([$id]);
    
    // insertar nuevas categorías
    if (!empty($selectedCategories)) {
        $insertStmt = $pdo->prepare('INSERT INTO pact_categories (pact_id, category_slug) VALUES (?, ?)');
        foreach ($selectedCategories as $categorySlug) {
            $insertStmt->execute([$id, $categorySlug]);
        }
    }
    
    Toast::success('Pacto actualizado exitosamente');
} catch (Throwable $e) {
    Toast::error('Error al actualizar el pacto: ' . $e->getMessage());
}

// construir URL de retorno
if ($returnTo === 'pact-detail') {
    header('Location: /?sec=admin&page=pact-detail&id=' . $id);
} else {
    header('Location: /?sec=admin&page=' . $returnTo);
}
exit;
