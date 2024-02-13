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
            return '<a href="artiste.php?id=' . $pseudo . '">' . $pseudo . '</a>';
        }, $this->lstartiste));
        echo "</td>";
        echo "<td>".$this->duree."</td>";
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