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
        // Obtener filtros de la URL
        $this->filters = [
            'demon_id' => isset($_GET['demon']) ? (int)$_GET['demon'] : null,
            'category' => $_GET['category'] ?? null,
            'sort' => $_GET['sort'] ?? 'newest',
        ];

        // Filtrar valores null
        $this->filters = array_filter($this->filters, fn($v) => $v !== null);

        // Determinar si se están aplicando filtros (excluyendo sort por defecto)
        $this->hasActiveFilters = (isset($_GET['demon']) && $_GET['demon'] !== '') || 
                                   (isset($_GET['category']) && $_GET['category'] !== '') ||
                                   (isset($_GET['sort']) && $_GET['sort'] !== 'newest');
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
        // Solo mostrar toast si hay filtros activos y viene del formulario
        $showFilterToast = $this->hasActiveFilters && 
                          isset($_SERVER['HTTP_REFERER']) && 
                          strpos($_SERVER['HTTP_REFERER'], 'sec=pacts') !== false &&
                          !isset($_SESSION['filter_toast_shown']);

        if ($showFilterToast) {
            $_SESSION['filter_toast_shown'] = true;
            Toast::info('Filtros aplicados');
        } else {
            // Limpiar flag si no hay filtros activos
            unset($_SESSION['filter_toast_shown']);
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
