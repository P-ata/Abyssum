<?php
declare(strict_types=1);

require_once __DIR__ . '/Demon.php';
require_once __DIR__ . '/Category.php';
require_once __DIR__ . '/Toast.php';

class DemonFilter
{
    /**
     * Filtra y ordena los demonios según los parámetros GET
     * 
     * @return array{demons: Demon[], hasActiveFilters: bool}
     */
    public static function applyFilters(): array
    {
        $demons = Demon::all();
        $hasActiveFilters = false;
        
        // Aplicar filtro por categoría
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $categorySlug = $_GET['category'];
            $demons = self::filterByCategory($demons, $categorySlug);
            $hasActiveFilters = true;
        }
        
        // Aplicar ordenamiento
        $sort = $_GET['sort'] ?? 'newest';
        $demons = self::sortDemons($demons, $sort);
        if ($sort !== 'newest') {
            $hasActiveFilters = true;
        }
        
        return [
            'demons' => $demons,
            'hasActiveFilters' => $hasActiveFilters
        ];
    }
    
    /**
     * Filtra demonios por categoría
     * 
     * @param Demon[] $demons
     * @param string $categorySlug
     * @return Demon[]
     */
    private static function filterByCategory(array $demons, string $categorySlug): array
    {
        return array_filter($demons, function($demon) use ($categorySlug) {
            $categories = $demon->categories();
            foreach ($categories as $cat) {
                if ($cat->slug === $categorySlug) {
                    return true;
                }
            }
            return false;
        });
    }
    
    /**
     * Ordena los demonios según el criterio especificado
     * 
     * @param Demon[] $demons
     * @param string $sort
     * @return Demon[]
     */
    private static function sortDemons(array $demons, string $sort): array
    {
        switch ($sort) {
            case 'oldest':
                return array_reverse($demons);
                
            case 'name_asc':
                usort($demons, fn($a, $b) => strcmp($a->name, $b->name));
                return $demons;
                
            case 'name_desc':
                usort($demons, fn($a, $b) => strcmp($b->name, $a->name));
                return $demons;
                
            case 'newest':
            default:
                // Ya viene ordenado por defecto
                return $demons;
        }
    }

    /**
     * Muestra toast de filtros aplicados o limpiados si corresponde
     */
    public static function showToastIfNeeded(): void
    {
        $sort = $_GET['sort'] ?? 'newest';
        $hasActiveFilters = (isset($_GET['category']) && $_GET['category'] !== '') || ($sort !== 'newest');

        // Verificar que el referer pertenezca a la misma sección
        $isSameSection = isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'sec=demons') !== false;
        if (!$isSameSection) {
            unset($_SESSION['filter_toast_demons_applied'], $_SESSION['filter_toast_demons_cleared']);
            return;
        }

        // Analizar el referrer para detectar limpieza
        $refQuery = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) ?? '';
        parse_str($refQuery, $refParams);
        $refHadFilters = (isset($refParams['category']) && $refParams['category'] !== '')
                      || (isset($refParams['sort']) && $refParams['sort'] !== 'newest');

        // Caso: aplicados
        if ($hasActiveFilters && !isset($_SESSION['filter_toast_demons_applied'])) {
            $_SESSION['filter_toast_demons_applied'] = true;
            unset($_SESSION['filter_toast_demons_cleared']);
            Toast::info('Filtros aplicados');
            return;
        }

        // Caso: limpiados
        if (!$hasActiveFilters && $refHadFilters && !isset($_SESSION['filter_toast_demons_cleared'])) {
            $_SESSION['filter_toast_demons_cleared'] = true;
            unset($_SESSION['filter_toast_demons_applied']);
            Toast::success('Filtros eliminados correctamente');
            return;
        }

        if (!$hasActiveFilters) {
            unset($_SESSION['filter_toast_demons_applied']);
        }
    }
}
