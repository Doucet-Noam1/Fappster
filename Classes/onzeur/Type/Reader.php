<?php
declare(strict_types=1);

namespace onzeur\Type;

use Symfony\Component\Yaml\Yaml;

class Reader
{
    private $donnees;
    public function __construct(string $source)
    {
        $this->donnees = Yaml::parseFile($source);
    }
    public function getData(): array
    {
        $data = array();
        if ($this->donnees != null) {
            foreach ($this->donnees as $key => $value) {
                $img = null;
                if ($value["img"] != null)
                    $img = "data/images/covers/" . $value["img"];
                $album = new Album($value["by"],$value["title"], array(), strval($value["releaseYear"]), $img);
                $data[] = $album;
            }
        }
        return $data;
    }
}
?>