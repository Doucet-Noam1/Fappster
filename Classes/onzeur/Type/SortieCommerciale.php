<?php
declare(strict_types=1);

namespace onzeur\Type;

include_once 'BD.php';

abstract class SortieCommerciale extends Sortie
{
    protected array $listeGenres;
    const PATH = "data/images/covers/";

    public function __construct(Artiste $artiste, string $nom, array $liste, string $date, string|null $cover, int $id_type, array|null $listeGenres, $id = null)
    {
        parent::__construct($artiste, $nom, $liste, $date, $cover, $id_type, $id);
        $this->listeGenres = [];
        if ($listeGenres != null)
            foreach ($listeGenres as $genre)
                $this->addGenre($genre);
    }
    public function addArtiste(Artiste $artiste)
    {
        BD::addArtisteToSortie($this, $artiste);
    }
    public function addGenre(string $genre)
    {
        $this->listeGenres[] = BD::addGenre($this, $genre);
    }
}
