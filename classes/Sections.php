<?php
class Sections
{
    private $url;
    private $text;
    private $title;
    private $isInMenu;

    public function getUrl():string
    {
        return $this->url;
    }
    public function getText():string
    {
        return $this->text;
    }
    public function getTitle():string
    {
        return $this->title;
    }
    public function getInMenu():bool
    {
        return $this->isInMenu;
    }
    public static function sectionsOfSite():array
    {
        $sections = [];
        
        $JSON = file_get_contents(BASE_PATH . '/data/sections.json');
        $JSONData = json_decode($JSON);

        foreach ($JSONData as $value){
            $section = new self();
            $section->url = $value->url;
            $section->text = $value->text;
            $section->title = $value->title;
            $section->isInMenu = (bool)$value->isInMenu;
            $sections[] = $section;
        }
        return $sections;
    }
    public static function validSections():array
    {
        $validSections = [];
        $JSON = file_get_contents(BASE_PATH . '/data/sections.json');
        $JSONData = json_decode($JSON, true);
        
        foreach ($JSONData as $value){
            $validSections[] = $value["url"];
        }
        return $validSections;
    }

    public static function menuSections():array
    {
        $menuSections = [];
        $JSON = file_get_contents(BASE_PATH . '/data/sections.json');
        $JSONData = json_decode($JSON, true);
        
        foreach ($JSONData as $value){
            if(!empty($value["isInMenu"])){
                $menuSections[] = $value["url"];
            }
        }
        return $menuSections;
    }
}
?>