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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/new-demon');
    exit;
}

// Required fields
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');

if ($name === '') {
    Toast::error('El nombre es requerido');
    header('Location: /admin/new-demon');
    exit;
}

// Auto-generate slug if empty
if ($slug === '') {
    $slug = generateSlug($name);
}

// Optional fields
$species = trim($_POST['species'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$age_real = trim($_POST['age_real'] ?? '');
$summary = trim($_POST['summary'] ?? '');
$lore = trim($_POST['lore'] ?? '');
$abilities_summary = trim($_POST['abilities_summary'] ?? '');

// JSON fields - Aliases
$aliases = [];
for ($i = 1; $i <= 3; $i++) {
    $alias = trim($_POST["alias_$i"] ?? '');
    if ($alias !== '') {
        $aliases[] = $alias;
    }
}

// JSON fields - Personality
$personality = [];
for ($i = 1; $i <= 3; $i++) {
    $trait = trim($_POST["personality_$i"] ?? '');
    if ($trait !== '') {
        $personality[] = $trait;
    }
}

// JSON fields - Weaknesses
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

// Handle image upload
$imageFileId = null;
if (!empty($_FILES['image']['tmp_name'])) {
    try {
        $imageFileId = File::upload($_FILES['image']);
    } catch (Exception $e) {
        Toast::error('Error al subir la imagen: ' . $e->getMessage());
        header('Location: /admin/new-demon');
        exit;
    }
}

try {
    $data = [
        'slug' => $slug,
        'name' => $name,
    ];

    // Add optional fields only if not empty
    if ($species !== '') $data['species'] = $species;
    if ($gender !== '') $data['gender'] = $gender;
    if ($age_real !== '') $data['age_real'] = $age_real;
    if ($summary !== '') $data['summary'] = $summary;
    if ($lore !== '') $data['lore'] = $lore;
    if ($abilities_summary !== '') $data['abilities_summary'] = $abilities_summary;
    
    // Add JSON fields if not empty
    if (!empty($aliases)) $data['aliases'] = $aliases;
    if (!empty($personality)) $data['personality'] = $personality;
    if (!empty($weaknesses)) $data['weaknesses_limits'] = $weaknesses;

    // Add stats
    foreach ($stats as $key => $value) {
        if ($value !== null) {
            $data[$key] = max(0, min(100, $value)); // Clamp to 0-100
        }
    }

    // Add image file ID if uploaded
    if ($imageFileId !== null) {
        $data['image_file_id'] = $imageFileId;
    }

    Demon::create($data);
    Toast::success('Demonio creado exitosamente');
} catch (Throwable $e) {
    Toast::error('Error al crear el demonio: ' . $e->getMessage());
}

header('Location: /admin/dashboard');
exit;
