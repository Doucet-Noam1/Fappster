<?php
declare(strict_types=1);

namespace fappster\Type;

class Single extends SortieCommerciale
{
    public function __construct(Artiste|array $artiste, string $nom, array $listeTitres, string $date, ?string $cover, array $genres,bool $visibilite = true, int $id = null)
    {
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, 2, $genres,$visibilite, $id);
    }
    public function render()
    {
        echo '<h1>Single</h1>';
    }

    public function renderDetail()
    {
        echo '<h1>Single</h1>';
    }
}
