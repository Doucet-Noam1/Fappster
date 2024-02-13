<?php
declare(strict_types=1);

namespace onzeur\Type;


class PlayList extends Sortie
{
    public function __construct(Artiste $artiste, string $nom, array $listeTitres, string $date, ?string $cover, int $id_type, int $id = null)
    {
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, 3, $id);
    }
    public function render()
    {
        echo '<div class="playlist">';
        echo '<img src=">' . $this->cover . '" </img>';
        echo "<h2>EP</h2>";
        echo "<h1>" . $this->nom . "</h1>";
        for ($i = 0; $i < count($this->listeTitres); $i++) {
            $this->listeTitres[$i]->render();
        }
        echo "<p>" . $this->date . "</p>";
        echo '</div>';
    }
    public function renderDetail()
    {
        $this->render();
    }
}
