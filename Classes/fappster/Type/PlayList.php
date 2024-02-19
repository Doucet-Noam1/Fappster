<?php
declare(strict_types=1);

namespace fappster\Type;


class PlayList extends Sortie
{
    public function __construct(Utilisateur|Artiste|array $artiste, string $nom, ?string $cover, array $listeTitres = [], bool $visibilite = true, int $id = null, )
    {
        $date = date('d-m-Y');
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, 4, $visibilite, $id);
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
        echo "<a href='modifierSortie.php?id=" . $this->getID() . "'>Modifier</a>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $splitNameSpace . "</p>";
        echo "<h1>" . $this->nom . "</h1>";
        echo "<p>" . ($this->visibilite ? "Publique" : "Privée") . "</p>";
        echo "<span class='artistes'>";
        echo implode(" • ", array_map(function (Utilisateur $utilisateur) {
            $pseudo = $utilisateur->getPseudo();
            return '<a href="profil.php?id=' . $pseudo . '">' . $pseudo . '</a>';
        }, $this->artiste));
        echo "</span>";
        echo "<p>" . $this->date . "</p>";
        echo "<p>" . count($this->listeTitres) . " titres</p>";
        echo "<a href= modifierSortie.php?id=" . $this->getID() . ">modifier</a>";
        echo '</div>';
        echo '</div>
        <table><thead>
            <tr>
                <th>Position</th>
                <th>Titre</th>
                <th>Artistes</th>
                <th></th>
                <th>Durée</th>
                <th>Sortie</th>
            </tr>
        </thead>'; // On ferme les divs et on commence le tableau |Postion|Titre|Artistes|Durée|
        echo "<tbody>";
        for ($i = 0; $i < count($this->listeTitres); $i++) {
            $this->listeTitres[$i]->renderDetail();
        }
        echo "</tbody>";
        echo "</table>";
    }
    public function renderModif()
    {
        echo "<div id='banner'>";
        echo '<img src="' . $this->renderCover() . '"/>';
        echo "<div id='informations'>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $splitNameSpace . "</p>";
        echo "<h1>" . $this->nom . "</h1>";
        echo "<span class='artistes'>";
        echo implode(" • ", array_map(function (Artiste $artiste) {
            $pseudo = $artiste->getPseudo();
            return '<a href="profil.php?id=' . $pseudo . '">' . $pseudo . '</a>';
        }, $this->artiste));
        echo "</span>";
        echo "<p>" . $this->date . "</p>";
        echo "<p>" . count($this->listeTitres) . " titres</p>";
        echo '</div>';
        echo '</div>';
    }
}