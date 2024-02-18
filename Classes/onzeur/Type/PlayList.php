<?php
declare(strict_types=1);

namespace onzeur\Type;


class PlayList extends Sortie
{
    const PATH = "data/images/covers/";
    public function __construct(Utilisateur|Artiste|array $artiste, string $nom, ?string $cover,array $listeTitres = [],bool $visibilite =true, int $id = null,)
    {
        $date  = date('d-m-Y');
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, 4,$visibilite, $id);
    }
    public function render()
    {
        echo '<a class="sortie" href="sortie.php?id=' . parent::getID() . '">';
        $image = BD::DOSSIERCOVERS . $this->cover;
        echo '<img src="' . (($image != BD::DOSSIERCOVERS && file_exists($image)) ? BD::DOSSIERCOVERS . str_replace("%", "%25", $this->cover) : BD::DOSSIERCOVERS . 'null.png') . '"/>';
        echo "<p>" . $this->nom . "</p>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $this->date . " • " . $splitNameSpace . "</p>";

        echo '</a>';
    }
    public function renderDetail()
    {
        echo "<div id='banner'>";
        $image = BD::DOSSIERCOVERS . $this->cover;
        echo '<img src="' . (($image != BD::DOSSIERCOVERS && file_exists($image)) ? BD::DOSSIERCOVERS . str_replace("%", "%25", $this->cover) : BD::DOSSIERCOVERS . 'null.png') . '"/>';
        echo "<div id='informations'>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $splitNameSpace . "</p>";
        echo "<h1>" . $this->nom . "</h1>";
        echo "<span class='artistes'>";
        echo implode(" • ", array_map(function (Utilisateur $utilisateur) {
            $pseudo = $utilisateur->getPseudo();
            return '<a href="profil.php?id=' . $pseudo . '">' . $pseudo . '</a>';
        }, $this->artiste));
        echo "</span>";
        echo "<p>" . $this->date . "</p>";
        echo "<p>" . count($this->listeTitres) . " titres</p>";
        echo "<a href= modifierPlaylist.php?id=" . $this->getID() . ">modifier</a>";
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
        for ( $i = 0; $i < count($this->listeTitres); $i++){
            $this->listeTitres[$i]->renderDetail();
        }
        echo "</tbody>";
        echo "</table>";
    }
    public function renderModif(){
        $artistNames = array_map(fn($artiste) => $artiste->getPseudo(), $this->getArtiste());
        if (  isset($_SESSION['pseudo']) &&  in_array($_SESSION['pseudo'], $artistNames)  && !$this->getVisibilite() || $this->getVisibilite())
        { 
        echo "<div id='banner'>";
        $image = BD::DOSSIERCOVERS . $this->cover;
        echo '<img src="' . (($image != BD::DOSSIERCOVERS && file_exists($image)) ? BD::DOSSIERCOVERS . str_replace("%", "%25", $this->cover) : BD::DOSSIERCOVERS . 'null.png') . '"/>';
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
}}