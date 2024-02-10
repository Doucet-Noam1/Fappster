<?php
declare(strict_types=1);
namespace onzeur\Type;

include_once 'BD.php';

class Album extends SortieCommerciale
{
    public function __construct(Artiste $artiste, string $nom, array $listeTitres, string $date, string|null $cover, array $listeGenres, int $id = null, )
    {
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, 1, $listeGenres, $id);
    }
    public function render()
    {
        echo '<a class="album" href="sortie.php?id=' . parent::getID() . '">';
        $image = parent::PATH . $this->cover;
        if ($image != parent::PATH && file_exists($image))
            echo '<img src="' . parent::PATH . str_replace("%", "%25", $this->cover) . '"/>';
        else
            echo '<img src="' . parent::PATH . 'null.png"/>';
        echo "<p>" . $this->nom . "</p>";
        echo "<p>" . $this->date . " • Album</p>";
        echo "<genre class='dont-show'>";
        echo implode("-",$this->listeGenres);
        echo "</genre>";
        echo '</a>';
    }

    public function renderDetail()
    {
        echo '<a class="album" href="sortie.php?id=' . $this->getID() . '">';
        $image = parent::PATH . $this->cover;
        if ($image != parent::PATH && file_exists($image))
            echo '<img src="' . parent::PATH . str_replace("%", "%25", $this->cover) . '"/>';
        else
            echo '<img src="' . parent::PATH . 'null.png"/>';
        echo "<h1>" . $this->nom . "</h1>";
        echo '<div id="musiques">';
        for ($i = 0; $i < count($this->listeTitres); $i++) {
            $this->listeTitres[$i]->render();
        }
        foreach ($this->artiste as $artiste) {
            echo '<a href="artiste.php?id=' . $artiste->getPseudo() . '">' . $artiste->getPseudo() . '</a>';
        }
        echo '</div>';
        echo "<p>" . $this->date . "</p>";
        echo '</a>';
    }
}