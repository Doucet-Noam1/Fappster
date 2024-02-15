<?php
declare(strict_types=1);
namespace onzeur\Type;

class Titre implements Irender
{

    private string $titre;
    private array $lstartiste;
    private float $duree;
    private string|int $dateAjout;
    private int|null $idsortie;
    private string $fichier;

    public function __construct(string $titre, Artiste $artiste, int $duree, string|int $dateAjout, string $fichier, int $idsortie = null)
    {
        $this->titre = $titre;
        $this->lstartiste = [$artiste];
        $this->duree = $duree;
        $this->dateAjout = $dateAjout;
        $this->fichier = $fichier;
        $this->idsortie = $idsortie;
        BD::addTitre($this);
    }
    public function render()
    {
        echo '<div class="musique">';
        $sortie = $this->getSortie();
        if ($sortie != null){
            echo '<img src=">' . $sortie->getCover() . '" </img>';
        }
        echo "<h3>" . $this->titre . "</h3>";
        echo "<div id='artistes'>";
        echo "<ul>";
        foreach ($this->lstartiste as $artiste) {
            echo "<li>" . $artiste->getPseudo() . "</li>";
        }
        echo "</ul>";
        echo "</div>";
        echo "<p>" . $this->dateAjout . "</p>";
        echo "<p>" . $this->getDureeFormatted() . "</p>";
        echo '</div>';
    }
    public function renderDetail()
    {
        echo "<tr class='titre'>";
        echo "<td>".$this->getPosition()."</td>";
        echo "<td>" .$this->titre . "</td>";
        echo "<td>";
        echo implode(" & ", array_map(function (Artiste $artiste) {
            $pseudo = $artiste->getPseudo();
            return '<a href="profil.php?id=' . $pseudo . '">' . $pseudo . '</a>';
        }, $this->lstartiste));
        echo "</td>";
        echo '<td>';
        echo '<form method = "post" action="like.php">';
        echo '<input type="hidden" name="id_titre" value="' . $this->getID() . '"> </input>';
        echo '<input type="hidden" name="id_sortie" value="' . BD::getSortie($this->idsortie)->getID() . '"> </input>';
        echo '<input type="hidden" name="id_redirection" value="' . BD::getSortie($this->idsortie)->getID() . '"> </input>';
        echo '<button>+</button>';
        echo '</form>';
        echo '</td>';
        echo "<td>";
        if (isset($_SESSION['pseudo'])){
            echo ' <button id="openbtn"> : </button>';
            echo '<dialog id="dialog">';
            echo "<form id='popUp' method='post' action='ajouterTitrePlaylist.php'>";
            echo '<label id="labelSelect" for="id_playlist"> Choisissez la playlist: </label><br>';
            echo '<select id="selectPlaylist" name="id_playlist">';
            foreach (BD::getPlaylistsBy(BD::getUtilisateur($_SESSION['pseudo'])) as $playlist) {
                echo '<option value="' . $playlist->getID() . '">' . $playlist->getNom() . '</option>';
            }
            echo '</select>';
            echo '<input type="hidden" name="id_titre" value="' . $this->getID() . '"> </input>';
            echo '<input type="hidden" name="id_sortie" value="' . BD::getSortie($this->idsortie)->getID() . '"> </input>';
            echo '<input type="hidden" name="id_redirection" value="' . BD::getSortie($this->idsortie)->getID() . '"> </input>';
            echo ' <button type="submit" class="btn btn-success" id="btnValider" > Valider </button>';
            echo " </form>";
            echo "</dialog>";
        }
        else{
            echo ':';

        }
        echo "</td>";
        echo "<td>".$this->duree."</td>";
        
        echo "</tr>";
        
    }
    public function renderDetailPlaylist()
{
    echo "<tr class='titre'>";
    echo "<td> ".$this->getPosition()."</td>";
    echo "<td>" .$this->titre . "</td>";
    echo "<td>";
    echo implode(" & ", array_map(function (Artiste $artiste) {
        $pseudo = $artiste->getPseudo();
        return '<a href="profil.php?id=' . $pseudo . '">' . $pseudo . '</a>';
    }, $this->lstartiste));
    echo "</td>";
    echo '<td>';
    echo '<form method = "post" action="like.php">';
    echo '<input type="hidden" name="id_titre" value="' . $this->getID() . '"> </input>';
    echo '<input type="hidden" name="id_sortie" value="' . BD::getSortie($this->idsortie)->getID() . '"> </input>';
    echo '<input type="hidden" name="id_redirection" value="' . BD::getSortie($this->idsortie)->getID() . '"> </input>';
    echo '<button>+</button>';
    echo '</form>';
    echo '</td>';
    echo "<td>";
    if (isset($_SESSION['pseudo'])) {
        echo '<button id="openbtn"><img src="./data/images/icons/add.png"></button>';
        echo '<dialog id="dialog">';
        echo "<form id='popUp' method='post' action='ajouterTitrePlaylist.php'>";
        echo '<label id="labelSelect" for="id_playlist"> Choisissez la playlist: </label><br>';
        echo '<select id="selectPlaylist" name="id_playlist">';
        foreach (BD::getPlaylistsBy(BD::getUtilisateur($_SESSION['pseudo'])) as $playlist) {
            echo '<option value="' . $playlist->getID() . '">' . $playlist->getNom() . '</option>';
        }
        echo '</select>';
        echo '<input type="hidden" name="id_titre" value="' . $this->getID() . '">';
        echo '<input type="hidden" name="id_sortie" value="' . BD::getSortieInitial($this)->getID() . '"> </input>';
        echo '<input type="hidden" name="id_redirection" value="' . BD::getSortie($this->idsortie)->getID() . '"> </input>';
        echo '<button type="submit" class="btn btn-success"  id="btnValider"> Valider </button>';
        echo "</form>";
        echo "</dialog>";
    } else {
        echo ':';
    }
    echo "</td>";
    echo "<td>".$this->duree."</td>";
    echo "<td>";
    echo '<a href="sortie.php?id=' . BD::getSortieInitial($this)->getID(). '"> ' .   BD::getSortieInitial($this)->getNom() . '</a>';
    echo "</td>";
    echo "</tr>";
}

    public function getTitre()
    {
        return $this->titre;
    }
    public function getArtiste()
    {
        return $this->lstartiste;
    }
    public function getDuree()
    {
        return $this->duree;
    }
    public function getDureeFormatted(){
        $dureearondie = round($this->duree);
        $minutes = floor($dureearondie / 60);
        $secondes = $dureearondie - $minutes * 60;
        return $minutes.":".str_pad(strval($secondes), 2, "0", STR_PAD_LEFT);
    }
    public function getDateAjout()
    {
        return $this->dateAjout;
    }
    public function getAlbum(): Sortie
    {
        return BD::getSortie($this->idsortie);
    }
    public function setAlbum(Sortie $sortie)
    {
        $this->idsortie = $sortie->getID();
    }
    public function getPosition()
    {
        return BD::getPositionTitre($this, $this->getAlbum());
    }
    public function getID(): ?int
    {
        return BD::getIdTitre($this);
    }
    public function getFichier():string
    {
        return $this->fichier;
    }
    public function addArtiste(Artiste $artiste)
    {
        BD::addArtisteToTitre($this, $artiste);
        $this->lstartiste[] = $artiste;
    }
    public function getSortie() : ?Sortie{
        return BD::getSortie($this->idsortie);
    }

}