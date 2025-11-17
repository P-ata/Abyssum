<?php

class AdminSections
{
    private $url;
    private $text;
    private $title;
    private $isInMenu;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getIsInMenu(): bool
    {
        return $this->isInMenu;
    }

    public static function sectionsOfSite(): array
    {
        require_once BASE_PATH . '/classes/DbConnection.php';
        
        $sections = [];
        $db = DbConnection::get();

        $query = "SELECT slug, title, sort_order 
                  FROM admin_sections 
                  ORDER BY sort_order ASC";
        
        $stmt = $db->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $section = new self();
            $section->url      = $row['slug'];
            $section->text     = $row['title'];
            $section->title    = $row['title'];
            $section->isInMenu = true;

            $sections[] = $section;
        }

        return $sections;
    }

    public static function validSections(): array
    {
        require_once BASE_PATH . '/classes/DbConnection.php';
        
        $db = DbConnection::get();
        
        $query = "SELECT slug FROM admin_sections";
        $stmt = $db->query($query);
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function menuSections(): array
    {
        require_once BASE_PATH . '/classes/DbConnection.php';
        
        $db = DbConnection::get();
        
        $query = "SELECT slug FROM admin_sections ORDER BY sort_order ASC";
        $stmt = $db->query($query);
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}