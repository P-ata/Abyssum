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
            $sec = new self();
            $sec->url = $value->url;
            $sec->text = $value->text;
            $sec->title = $value->title;
            $sec->isInMenu = $value->isInMenu;
            $sections[] = $sec;
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
            if($value["isInMenu"]){
                $menuSections[] = $value["url"];
            }
        }
        return $menuSections;
    }
}
?>