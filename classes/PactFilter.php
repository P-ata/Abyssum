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
     * parsea los filtros desde $_GET
     */
    private function parseFilters(): void
    {
        // alinear filtros con demons: categoría, orden y demonio
        $sort = $_GET['sort'] ?? 'newest';
        $category = $_GET['category'] ?? null;
        $demon = isset($_GET['demon']) ? (int)$_GET['demon'] : null;

        $this->filters = [
            'category' => $category,
            'sort' => $sort,
            'demon_id' => $demon,
        ];

        // filtrar valores null
        $this->filters = array_filter($this->filters, fn($v) => $v !== null);

        // filtros activos: categoría presente, demonio presente o sort distinto de 'newest'
        $this->hasActiveFilters = ($category !== null && $category !== '') 
                                || ($demon !== null) 
                                || ($sort !== 'newest');
    }

    /**
     * obtiene los pactos aplicando los filtros
     * 
     * @return array array de objetos Pact
     */
    public function getPacts(): array
    {
        // si no hay filtros o solo hay sort por defecto, traer todos
        if (empty($this->filters) || (count($this->filters) === 1 && isset($this->filters['sort']) && $this->filters['sort'] === 'newest')) {
            return Pact::all();
        }

        // aplicar filtros
        return Pact::filter($this->filters);
    }

    /**
     * muestra toast de filtros aplicados si corresponde
     */
    public function showToastIfNeeded(): void
    {
        // determinar si el referer es de la misma sección
        $isSameSection = isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'sec=pacts') !== false;

        if (!$isSameSection) {
            // limpiar flags si cambio de sección
            unset($_SESSION['filter_toast_pacts_applied'], $_SESSION['filter_toast_pacts_cleared']);
            return;
        }

        // extraer parámetros del referer para detectar "limpieza" de filtros
        $refQuery = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) ?? '';
        parse_str($refQuery, $refParams);

        $refHadFilters = (isset($refParams['category']) && $refParams['category'] !== '')
                      || (isset($refParams['demon']) && $refParams['demon'] !== '')
                      || (isset($refParams['sort']) && $refParams['sort'] !== 'newest');

        // caso 1: filtros aplicados
        if ($this->hasActiveFilters && !isset($_SESSION['filter_toast_pacts_applied'])) {
            $_SESSION['filter_toast_pacts_applied'] = true;
            unset($_SESSION['filter_toast_pacts_cleared']);
            Toast::info('Filtros aplicados');
            return;
        }

        // caso 2: filtros limpiados (antes había, ahora no)
        if (!$this->hasActiveFilters && $refHadFilters && !isset($_SESSION['filter_toast_pacts_cleared'])) {
            $_SESSION['filter_toast_pacts_cleared'] = true;
            unset($_SESSION['filter_toast_pacts_applied']);
            Toast::success('Filtros eliminados correctamente');
            return;
        }

        // si no hay filtros, limpiar flag de "applied"
        if (!$this->hasActiveFilters) {
            unset($_SESSION['filter_toast_pacts_applied']);
        }
    }

    /**
     * verifica si hay filtros activos
     * 
     * @return bool
     */
    public function hasActiveFilters(): bool
    {
        return $this->hasActiveFilters;
    }

    /**
     * obtiene los filtros actuales
     * 
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * obtiene el valor de un filtro específico
     * 
     * @param string $key Nombre del filtro
     * @return mixed|null
     */
    public function getFilter(string $key): mixed
    {
        return $this->filters[$key] ?? null;
    }
}
