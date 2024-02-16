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
        if ($sortie != null) {
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
        $estOriginale = is_null(BD::getSortieInitiale($this));
        echo "<tr class='titre'>";
        echo "<td> " . $this->getPosition() . "</td>";
        echo "<td>" . $this->titre . "</td>";
        echo "<td>";
        echo implode(" & ", array_map(function (Artiste $artiste) {
            $pseudo = $artiste->getPseudo();
            return '<a href="profil.php?id=' . $pseudo . '">' . $pseudo . '</a>';
        }, $this->lstartiste));
        echo "</td>";
        echo "<td>";
        if (isset($_SESSION['pseudo'])) {
            echo '<button class="openbtn"></button>';
            echo '<dialog class="dialog">';
            echo "<form class='popUp' method='post' action='ajouterTitrePlaylist.php'>";
            echo '<label class="labelSelect" for="id_playlist"> Choisissez la playlist: </label><br>';
            $playlists = BD::getPlaylistsBy(BD::getUtilisateur($_SESSION['pseudo']));
            if (count($playlists) == 0) {
                echo '<p>Vous n\'avez pas de playlist</p>';
            }else{
            echo '<select class="selectPlaylist" name="id_playlist">';
            foreach ($playlists as $playlist) {
                if ($playlist != BD::getSortie($this->idsortie)) {
                    echo '<option value="' . $playlist->getID() . '">' . $playlist->getNom() . '</option>';
                }
            }
            echo '</select>';
            echo '<button type="submit" class="btnValider"> Valider </button>';
            }
            echo '<input type="hidden" name="id_titre" value="' . $this->getID() . '">';
            echo '<input type="hidden" name="id_sortie" value="' . ($estOriginale ? BD::getSortie($this->idsortie)->getID() : BD::getSortieInitiale($this)->getID()) . '"> </input>';
            echo '<input type="hidden" name="id_redirection" value="' . BD::getSortie($this->idsortie)->getID() . '"> </input>';
            echo "</form>";
            echo "</dialog>";
            if (
                in_array(
                    $_SESSION['pseudo'],
                    array_map(
                        function (Utilisateur $utilisateur) {
                            return $utilisateur->getPseudo();
                        },
                        BD::getSortie($this->idsortie)->getArtiste()
                    )
                )
            ) {
                echo '<form method="post" action="supprimerTitre.php">';
                echo '<button class="deletebtn"></button>';
                echo '<input type="hidden" name="id_titre" value="' . $this->getID() . '">';
                echo '<input type="hidden" name="id_sortie" value="' . $this->idsortie . '">';
                echo '</form>';
            }
        } else {
            echo '<a href="login.php">Ajouter à une playlist</a>';
        }
        echo "</td>";
        if (!$estOriginale) {
            echo "<td>";
            echo '<a href="sortie.php?id=' . BD::getSortieInitiale($this)->getID() . '"> ' . BD::getSortieInitiale($this)->getNom() . '</a>';
            echo "</td>";
        }
        echo "<td>" . $this->duree . "</td>";
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
    public function getDureeFormatted()
    {
        $dureearondie = round($this->duree);
        $minutes = floor($dureearondie / 60);
        $secondes = $dureearondie - $minutes * 60;
        return $minutes . ":" . str_pad(strval($secondes), 2, "0", STR_PAD_LEFT);
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
    public function getFichier(): string
    {
        return $this->fichier;
    }
    public function addArtiste(Artiste $artiste)
    {
        BD::addArtisteToTitre($this, $artiste);
        $this->lstartiste[] = $artiste;
    }
    public function getSortie(): ?Sortie
    {
        return BD::getSortie($this->idsortie);
    }

}