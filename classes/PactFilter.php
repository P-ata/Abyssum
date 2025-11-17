<?php
require_once BASE_PATH . '/classes/Pact.php';
require_once BASE_PATH . '/classes/Toast.php';

class PactFilter
{
    private array $filters = [];
    private bool $hasActiveFilters = false;

    public function __construct()
    {
        $this->parseFilters();
    }

    /**
     * Parsea los filtros desde $_GET
     */
    private function parseFilters(): void
    {
        // Alinear filtros con demons: solo categoría y orden
        $sort = $_GET['sort'] ?? 'newest';
        $category = $_GET['category'] ?? null;

        $this->filters = [
            'category' => $category,
            'sort' => $sort,
        ];

        // Filtrar valores null
        $this->filters = array_filter($this->filters, fn($v) => $v !== null);

        // Filtros activos: categoría presente o sort distinto de 'newest'
        $this->hasActiveFilters = ($category !== null && $category !== '') || ($sort !== 'newest');
    }

    /**
     * Obtiene los pactos aplicando los filtros
     * 
     * @return array Array de objetos Pact
     */
    public function getPacts(): array
    {
        // Si no hay filtros o solo hay sort por defecto, traer todos
        if (empty($this->filters) || (count($this->filters) === 1 && isset($this->filters['sort']) && $this->filters['sort'] === 'newest')) {
            return Pact::all();
        }

        // Aplicar filtros
        return Pact::filter($this->filters);
    }

    /**
     * Muestra toast de filtros aplicados si corresponde
     */
    public function showToastIfNeeded(): void
    {
        // Determinar si el referer es de la misma sección
        $isSameSection = isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'sec=pacts') !== false;

        if (!$isSameSection) {
            // Limpiar flags si cambio de sección
            unset($_SESSION['filter_toast_pacts_applied'], $_SESSION['filter_toast_pacts_cleared']);
            return;
        }

        // Extraer parámetros del referer para detectar "limpieza" de filtros
        $refQuery = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) ?? '';
        parse_str($refQuery, $refParams);

        $refHadFilters = (isset($refParams['category']) && $refParams['category'] !== '')
                      || (isset($refParams['sort']) && $refParams['sort'] !== 'newest');

        // Caso 1: Filtros aplicados
        if ($this->hasActiveFilters && !isset($_SESSION['filter_toast_pacts_applied'])) {
            $_SESSION['filter_toast_pacts_applied'] = true;
            unset($_SESSION['filter_toast_pacts_cleared']);
            Toast::info('Filtros aplicados');
            return;
        }

        // Caso 2: Filtros limpiados (antes había, ahora no)
        if (!$this->hasActiveFilters && $refHadFilters && !isset($_SESSION['filter_toast_pacts_cleared'])) {
            $_SESSION['filter_toast_pacts_cleared'] = true;
            unset($_SESSION['filter_toast_pacts_applied']);
            Toast::success('Filtros eliminados correctamente');
            return;
        }

        // Si no hay filtros, limpiar flag de "applied" para futuros clics
        if (!$this->hasActiveFilters) {
            unset($_SESSION['filter_toast_pacts_applied']);
        }
    }

    /**
     * Verifica si hay filtros activos
     * 
     * @return bool
     */
    public function hasActiveFilters(): bool
    {
        return $this->hasActiveFilters;
    }

    /**
     * Obtiene los filtros actuales
     * 
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Obtiene el valor de un filtro específico
     * 
     * @param string $key Nombre del filtro
     * @return mixed|null
     */
    public function getFilter(string $key): mixed
    {
        return $this->filters[$key] ?? null;
    }
}
