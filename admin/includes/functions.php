<?php

/**
 * Genera un slug URL-friendly desde un string
 * Convierte a minúsculas, remueve acentos, reemplaza espacios por guiones
 */
function generateSlug(string $text): string
{
    // Convertir a minúsculas
    $slug = mb_strtolower($text, 'UTF-8');
    
    // Reemplazar caracteres con acentos
    $unwanted = [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
        'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
        'ñ' => 'n', 'Ñ' => 'n',
        'ü' => 'u', 'Ü' => 'u',
        'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
        'â' => 'a', 'ê' => 'e', 'î' => 'i', 'ô' => 'o', 'û' => 'u',
        'ã' => 'a', 'õ' => 'o',
        'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o',
    ];
    $slug = strtr($slug, $unwanted);
    
    // Remover caracteres especiales, solo permitir letras, números y guiones
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    
    // Reemplazar espacios y múltiples guiones por un solo guión
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    
    // Remover guiones al inicio y final
    $slug = trim($slug, '-');
    
    return $slug;
}
