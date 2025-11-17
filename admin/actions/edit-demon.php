<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/auth.php';
requireAdmin();

require_once __DIR__ . '/../../classes/Demon.php';
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

// Obtener el slug del demonio a editar
$slug = isset($_POST['id']) ? trim($_POST['id']) : '';

if ($slug === '') {
    Toast::error('ID de demonio inválido');
    header('Location: /?sec=admin&page=' . $returnTo);
    exit;
}

// Cargar demonio existente
$demon = Demon::find($slug);
if (!$demon) {
    Toast::error('Demonio no encontrado');
    header('Location: /?sec=admin&page=' . $returnTo);
    exit;
}

// Campos requeridos
$name = trim($_POST['name'] ?? '');
$newSlug = trim($_POST['slug'] ?? '');

if ($name === '') {
    Toast::error('El nombre es requerido');
    header('Location: /?sec=admin&page=edit-demon&id=' . urlencode($slug));
    exit;
}

// se genera slug si no se escribió
if ($newSlug === '') {
    $newSlug = generateSlug($name);
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
        $imageFileId = File::upload($_FILES['image'], 'demon');
        
        // borrar imagen vieja de la BD si existe y es diferente
        if ($currentImageFileId && $currentImageFileId !== $imageFileId) {
            File::deleteById($currentImageFileId);
        }
    } catch (Exception $e) {
        // Verificar si es un archivo duplicado
        if (str_starts_with($e->getMessage(), 'ARCHIVO_DUPLICADO:')) {
            $imageFileId = (int)substr($e->getMessage(), strlen('ARCHIVO_DUPLICADO:'));
            Toast::info('Imagen ya existente en la base de datos, reutilizando archivo');
            
            // Borrar imagen vieja si es diferente
            if ($currentImageFileId && $currentImageFileId !== $imageFileId) {
                File::deleteById($currentImageFileId);
            }
        } else {
            Toast::error('Error al subir imagen: ' . $e->getMessage());
            header('Location: /?sec=admin&page=edit-demon&id=' . urlencode($slug));
            exit;
        }
    }
}

// campos opcionales
$species = trim($_POST['species'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$age_real = trim($_POST['age_real'] ?? '');
$summary = trim($_POST['summary'] ?? '');
$lore = trim($_POST['lore'] ?? '');
$abilities_summary = trim($_POST['abilities_summary'] ?? '');

// campos JSON - alias
$aliases = [];
for ($i = 1; $i <= 3; $i++) {
    $alias = trim($_POST["alias_$i"] ?? '');
    if ($alias !== '') {
        $aliases[] = $alias;
    }
}

// campos JSON - personalidad
$personality = [];
for ($i = 1; $i <= 3; $i++) {
    $trait = trim($_POST["personality_$i"] ?? '');
    if ($trait !== '') {
        $personality[] = $trait;
    }
}

// campos JSON - debilidades
$weaknesses = [];
for ($i = 1; $i <= 3; $i++) {
    $weakness = trim($_POST["weakness_$i"] ?? '');
    if ($weakness !== '') {
        $weaknesses[] = $weakness;
    }
}

// Stats (tinyint 0-100)
$stats = [
    'stat_strength' => !empty($_POST['stat_strength']) ? (int)$_POST['stat_strength'] : null,
    'stat_dexterity' => !empty($_POST['stat_dexterity']) ? (int)$_POST['stat_dexterity'] : null,
    'stat_intelligence' => !empty($_POST['stat_intelligence']) ? (int)$_POST['stat_intelligence'] : null,
    'stat_health' => !empty($_POST['stat_health']) ? (int)$_POST['stat_health'] : null,
    'stat_reflexes' => !empty($_POST['stat_reflexes']) ? (int)$_POST['stat_reflexes'] : null,
    'stat_stealth' => !empty($_POST['stat_stealth']) ? (int)$_POST['stat_stealth'] : null,
];

try {
    $data = [
        'slug' => $newSlug,
        'name' => $name,
    ];

    // agregar campos opcionales si no están vacíos
    if ($species !== '') $data['species'] = $species;
    if ($gender !== '') $data['gender'] = $gender;
    if ($age_real !== '') $data['age_real'] = $age_real;
    if ($summary !== '') $data['summary'] = $summary;
    if ($lore !== '') $data['lore'] = $lore;
    if ($abilities_summary !== '') $data['abilities_summary'] = $abilities_summary;
    if ($imageFileId !== null) $data['image_file_id'] = $imageFileId;
    
    // campos JSON si no están vacíos
    if (!empty($aliases)) $data['aliases'] = $aliases;
    if (!empty($personality)) $data['personality'] = $personality;
    if (!empty($weaknesses)) $data['weaknesses_limits'] = $weaknesses;

    // agregar stats
    foreach ($stats as $key => $value) {
        if ($value !== null) {
            $data[$key] = max(0, min(10, $value)); // clamp de 0-10
        }
    }

    Demon::update($demon->id, $data);
    Toast::success('Demonio actualizado exitosamente');
} catch (Throwable $e) {
    Toast::error('Error al actualizar el demonio: ' . $e->getMessage());
}

// construir URL de retorno (usar el nuevo slug si se cambió, sino el original)
$finalSlug = isset($data['slug']) ? $data['slug'] : $demon->slug;

if ($returnTo === 'demon-detail') {
    header('Location: /?sec=admin&page=demon-detail&id=' . urlencode($finalSlug));
} else {
    header('Location: /?sec=admin&page=' . $returnTo);
}
exit;
