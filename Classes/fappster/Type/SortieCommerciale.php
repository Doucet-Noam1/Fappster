<?php
declare(strict_types=1);

namespace fappster\Type;

include_once 'BD.php';

abstract class SortieCommerciale extends Sortie
{
    protected array $listeGenres;

    public function __construct(Artiste|array $artiste, string $nom, array $listeTitres, string $date, ?string $cover, int $id_type, ?array $listeGenres, bool $visibilite, $id = null)
    {
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, $id_type, $visibilite, $id);
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
        echo '<img src="' . $this->renderCover() . '"/>';
        echo "<p>" . $this->nom . "</p>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $this->date . " • " . $splitNameSpace . "</p>";
        echo '</a>';
    }

    public function renderDetail()
    {
        echo "<div id='banner'>";
        echo '<img src="' . $this->renderCover() . '"/>';
        echo "<div id='informations'>";
        if(isset($_SESSION['pseudo'])){
            if($_SESSION['pseudo'] == "admin" || in_array($_SESSION['pseudo'], array_map(fn($artiste) => $artiste->getPseudo(), $this->artiste))){
                echo "<a href='modifierSortie.php?id=" . $this->getID() . "'>Modifier</a>";
            }
        }
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $splitNameSpace . "</p>";
        echo "<h1>" . $this->nom . "</h1>";
        echo "<p>" . ($this->visibilite ? "Publique" : "Privée") . "</p>";
        echo "<span class='artistes'>";
        echo implode(" • ", array_map(function (Artiste $artiste) {
            $artisteValue = $artiste;
            $pseudo = $artisteValue->getPseudo();
            return '<a href="profil.php?id=' . $pseudo . '"' . ($artisteValue->getVerifie() ? "class='verified'" : "") . ' >' . $pseudo . '</a>';
        }, $this->artiste));
        echo "</span>";
        echo "<p>" . $this->date . "</p>";
        echo "<p>" . count($this->listeTitres) . " titres</p>";
        $moy = BD::getMoyenneNote($this);
        $resultat = $moy == null ? "?" : substr(number_format($moy, 3, '.', ''), 0, 3);
        echo '<p class="moyenne">' . ($resultat) . '</p>';
        echo '</div>';
        echo '<div id="avis">';
        if (isset($_SESSION['pseudo'])) {
            echo '<form method="post" id="like">';
            $like = BD::getLike($_SESSION['pseudo'], $this);
            echo '<input type="hidden" name="like" value="' . !boolval($like) . '">';
            echo '<button action="submit">' . Avis::getCoeur($like) . '</button>';
            echo '</form>';
            echo '<form method="post" id="note">';
            foreach (Avis::getEtoiles(BD::getNote($_SESSION['pseudo'], $this)) as $index => $etoile) {
                echo '<button value="' . strval($index + 1) . '" name="note" action="submit">' . $etoile . '</button>';
            }
            echo '</form>';
        }
        echo '</div>';
        echo '</div>
            <table><thead>
                <tr>
                    <th>Position</th>
                    <th>Titre</th>
                    <th>Artistes</th>
                    <th></th>
                    <th>Durée</th>
                </tr>
            </thead>'; // On ferme les divs et on commence le tableau |Postion|Titre|Artistes|Durée|
        echo "<tbody>";
        if (count($this->listeTitres) == 0) {
            echo "<tr><td colspan='5'>Aucun titre</td></tr>";
        } else {
            foreach ($this->listeTitres as $titre) {
                $titre->renderDetail();
            }
        }
        echo "</tbody>";
        echo "</table>";

    }
}
