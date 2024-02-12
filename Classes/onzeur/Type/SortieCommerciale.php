<?php
declare(strict_types=1);

namespace onzeur\Type;

include_once 'BD.php';

abstract class SortieCommerciale extends Sortie
{
    protected array $listeGenres;
    const PATH = "data/images/covers/";

    public function __construct(Artiste|array $artiste, string $nom, array $listeTitres, string $date, string|null $cover, int $id_type, array|null $listeGenres, $id = null)
    {
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, $id_type, $id);
        $this->listeGenres = [];
        if ($listeGenres != null)
            foreach ($listeGenres as $genre)
                $this->addGenre($genre);
        foreach ($listeTitres as $titre) {
            $titre->setAlbum($this);
        }
    }
    public function addGenre(string $genre)
    {
        $this->listeGenres[] = BD::addGenre($this, $genre);
    }

    public function render()
    {
        echo '<a class="sortie" href="sortie.php?id=' . parent::getID() . '">';
        $image = self::PATH . $this->cover;
        echo '<img src="' . (($image != self::PATH && file_exists($image)) ? self::PATH . str_replace("%", "%25", $this->cover) : self::PATH . 'null.png') . '"/>';
        echo "<p>" . $this->nom . "</p>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $this->date . " • " . $splitNameSpace . "</p>";
        echo "<genre class='dont-show'>";
        echo implode("-", $this->listeGenres);
        echo "</genre>";
        echo '</a>';
    }

    public function renderDetail()
    {
        echo "<div id='banner'>";
        $image = self::PATH . $this->cover;
        echo '<img src="' . (($image != self::PATH && file_exists($image)) ? self::PATH . str_replace("%", "%25", $this->cover) : self::PATH . 'null.png') . '"/>';
        echo "<div id='informations'>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $splitNameSpace . "</p>";
        echo "<h1>" . $this->nom . "</h1>";
        echo "<span class='artistes'>";
        echo implode(" • ", array_map(function (Artiste $artiste) {
            $pseudo = $artiste->getPseudo();
            return '<a href="artiste.php?id=' . $pseudo . '">' . $pseudo . '</a>';
        }, $this->artiste));
        echo "</span>";
        echo "<p>" . $this->date . "</p>";
        echo "<p>" . count($this->listeTitres) . " titres</p>";
        echo '</div></div><table><thead><tr><th>Position</th><th>Titre</th><th>Artistes</th><th>Durée</th></tr></thead>'; // On ferme les divs et on commence le tableau |Postion|Titre|Artistes|Durée|
        echo "<tbody>";
        foreach ($this->listeTitres as $titre) {
            $titre->renderDetail();
        }
        echo "</tbody>";
        echo "</table>";
    }
}
