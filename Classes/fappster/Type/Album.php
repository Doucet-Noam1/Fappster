<?php
declare(strict_types=1);
namespace fappster\Type;

include_once 'BD.php';

class Album extends SortieCommerciale
{
    public function __construct(Artiste|array $artiste, string $nom, array $listeTitres, string $date, ?string $cover, array $listeGenres,bool $visibilite = true, int $id = null, )
    {
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, 1, $listeGenres,$visibilite, $id);
    }
}