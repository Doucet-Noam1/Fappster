<?php
declare(strict_types=1);
namespace onzeur\Type;

class Titre implements Irender
{
    private $titre;
    private $lstartiste;
    private $duree;
    private $dateAjout;
    private $sortie;
    private $song;

    public function __construct(string $titre, Artiste $artiste, int $duree, string|int $dateAjout, string $song, SortieCommerciale $sortie = null)
    {
        $this->titre = $titre;
        $this->lstartiste = [$artiste];
        $this->duree = $duree;
        $this->dateAjout = $dateAjout;
        $this->sortie = $sortie;
        $this->song = $song;
        BD::addTitre($this);
    }
    public function render()
    {
        echo '<div class="musique">';
        echo '<img src=">' . $this->sortie->getCover() . '" </img>';
        echo "<h3>" . $this->titre . "</h3>";
        echo "div id='artistes'>";
        echo "ul";
        foreach ($this->lstartiste as $artiste) {
            echo "<li>" . $artiste->getPseudo() . "</li>";
        }
        echo "/ul";
        echo "</div>";
        echo "<p>" . $this->dateAjout . "</p>";
        echo "<p>" . $this->duree . "</p>";
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
        echo "<td>";
        if (isset($_SESSION['pseudo'])){
            echo ' <button id="openbtn"> : </button>';
            echo '<dialog id="dialog">';
            echo "<form method='post' action='ajouterTitrePlaylist.php'>";
            echo '<label for="id_playlist"> Choisissez la playlist: </label></br>';
            echo '<select name="id_playlist">';
            foreach (BD::getPlaylistsBy(BD::getUtilisateur($_SESSION['pseudo'])) as $playlist) {
                echo '<option value="' . $playlist->getID() . '">' . $playlist->getNom() . '</option>';
            }
            echo '</select>';
            echo '<input type="hidden" name="id_titre" value="' . $this->getID() . '"> </input>';
            echo '<input type="hidden" name="id_sortie" value="' . $this->sortie->getID() . '"> </input>';
            echo ' <button type="submit" class="btn btn-success"> valider </button>';
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
    public function renderDetailPlaylist(int $i)
{
    echo "<tr class='titre'>";
    echo "<td> ".$i."</td>";
    echo "<td>" .$this->titre . "</td>";
    echo "<td>";
    echo implode(" & ", array_map(function (Artiste $artiste) {
        $pseudo = $artiste->getPseudo();
        return '<a href="profil.php?id=' . $pseudo . '">' . $pseudo . '</a>';
    }, $this->lstartiste));
    echo "</td>";
    echo "<td>";
    if (isset($_SESSION['pseudo'])) {
        echo '<button id="openbtn"> : </button>';
        echo '<dialog id="dialog">';
        echo "<form method='post' action='ajouterTitrePlaylist.php'>";
        echo '<label for="id_playlist"> Choisissez la playlist: </label><br>';
        echo '<select name="id_playlist">';
        foreach (BD::getPlaylistsBy(BD::getUtilisateur($_SESSION['pseudo'])) as $playlist) {
            echo '<option value="' . $playlist->getID() . '">' . $playlist->getNom() . '</option>';
        }
        echo '</select>';
        echo '<input type="hidden" name="id_titre" value="' . $this->getID() . '">';
        echo '<button type="submit" class="btn btn-success"> valider </button>';
        echo "</form>";
        echo "</dialog>";
    } else {
        echo ':';
    }
    echo "</td>";
    echo "<td>".$this->duree."</td>";
    echo "<td> caca";
    var_dump($this->sortie->getNom());
    //echo '<a href="sortie.php?id=' . $this->sortie->getID() . '"> ' . $this->sortie->getNom() . '</a>';
    echo ''. $this->sortie->getID();
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
    public function getDateAjout()
    {
        return $this->dateAjout;
    }
    public function getAlbum()
    {
        return $this->sortie;
    }
    public function setAlbum(Sortie $sortie)
    {
        $this->sortie = $sortie;
    }
    public function getPosition()
    {
        return array_search($this, $this->sortie->getListeTitres())+1;
    }
    public function getID(): ?int
    {
        return BD::getIdTitre($this);
    }
    public function addArtiste(Artiste $artiste)
    {
        BD::addArtisteToTitre($this, $artiste);
        $this->lstartiste[] = $artiste;
    }

}