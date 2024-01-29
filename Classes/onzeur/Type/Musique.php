<?php
declare(strict_types=1);

namespace Type\onzeur;


class Musique implements Irender{
    private $titre;
    private $artiste;
    private $duree;
    private $dateAjout;
    private Album $album;

    public function __construct($titre,$artiste,$duree,$dateAjout,Album $album){
        $this->titre = $titre;
        $this->artiste = $artiste;
        $this->duree = $duree;
        $this->dateAjout = $dateAjout;
        $this->album = $album;
    }
    public function render(){
        echo '<div class="musique">';
        echo '<img src=">'.$this->album->getCover().'" </img>';
        echo "<h3>".$this->titre."</h3>";
        echo "<p>". $this->artiste ."</p>";
        echo "<p>".$this->dateAjout."</p>";
        echo "<p>".$this->duree."</p>";
        echo '</div>';
    }
    public function getTitre(){
        return $this->titre;
    }
    public function getArtiste(){
        return $this->artiste;
    }
    public function getDuree(){
        return $this->duree;
    }
    public function getDateAjout(){
        return $this->dateAjout;
    }
    public function getAlbum(){
        return $this->album;
    }
    
}