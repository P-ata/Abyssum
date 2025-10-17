<?php
declare(strict_types=1);

// Base del proyecto (un nivel arriba de /public)
define('BASE_PATH', dirname(__DIR__));

// Includes con ruta absoluta
require_once BASE_PATH . '/classes/Sections.php';

$validSections = Sections::validSections();
$menuSections  = Sections::menuSections();

$section = $_GET['section'] ?? 'home';
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
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($sectionTitle) ?></title>
  <link href="/assets/css/tailwind.css" rel="stylesheet">
</head>

<body>
  <?php /* require_once BASE_PATH . '/includes/header.php'; */ ?>
  <main>
  <?php require BASE_PATH . '/views/' . $view . '.php'; ?>
  </main>
  <?php /* require_once BASE_PATH . '/includes/footer.php'; */ ?>
</body>
</html>