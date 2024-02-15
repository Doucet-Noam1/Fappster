<?php
declare(strict_types=1);

namespace onzeur\Type;



class EP extends SortieCommerciale
{
    public function __construct(Artiste|array $artiste, string $nom, array $listeTitres, string $date, ?string $cover, array $genres,bool $visibilite = true, int $id = null)
    {
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, 3, $genres);
    }
}
