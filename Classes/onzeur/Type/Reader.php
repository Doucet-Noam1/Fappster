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
                $artiste = new Artiste($value["by"], null);
                $album = new Album($artiste,$value["title"], array(), strval($value["releaseYear"]), $img, $value["entryId"]);
                $data[] = $album;
            }
        }
        return $data;
    }
}
?>