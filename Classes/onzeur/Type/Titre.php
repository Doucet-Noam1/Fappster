<?php
declare(strict_types=1);
namespace onzeur\Type;

class Titre implements Irender
{
    private string $titre;
    private array $lstartiste;
    private float $duree;
    private string|int $dateAjout;
    private SortieCommerciale|null $sortie;
    private string $fichier;

    public function __construct(string $titre, Artiste $artiste, float $duree, string|int $dateAjout, string $fichier, SortieCommerciale $sortie = null)
    {
        $this->titre = $titre;
        $this->lstartiste = [$artiste];
        $this->duree = $duree;
        $this->dateAjout = $dateAjout;
        $this->sortie = $sortie;
        $this->fichier = $fichier;
        BD::addTitre($this);
    }
    public function render()
    {
        echo '<div class="sortie">';
        if ($this->sortie != null){
            echo '<img src=">' . $this->sortie->getCover() . '" </img>';
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
    public function getAlbum(): SortieCommerciale
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
    public function getFichier():string
    {
        return $this->fichier;
    }
    public function addArtiste(Artiste $artiste)
    {
        BD::addArtisteToTitre($this, $artiste);
        $this->lstartiste[] = $artiste;
    }

}