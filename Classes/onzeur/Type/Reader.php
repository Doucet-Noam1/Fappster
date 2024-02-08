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
                $img = is_null($value["img"]) ? null : "data/images/covers/".$value["img"];
                $artiste = new Artiste($value["by"], null);
                $value["entryId"];
                $album = new Album($artiste,$value["title"], array(), strval($value["releaseYear"]), $img);
                foreach ($value["genre"] as $genre) {
                    $genre = mb_convert_case($genre, MB_CASE_TITLE, "UTF-8");
                    $genre = str_replace(["-"," ","_"],"",$genre);
                    $album->addGenre($genre);
                    $queryLinkGenre= BD::getInstance()->prepare("INSERT INTO A_POUR_STYLE(nom_genre,id_sortie) VALUES (?,?)");
                    $queryLinkGenre->execute([$genre,$album->getID()]);
                }
                $data[] = $album;
            }
        }
        return $data;
    }
}
?>