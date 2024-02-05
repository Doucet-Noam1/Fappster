<?php
declare(strict_types=1);
namespace onzeur\Type;

class Musique implements Irender{
    private $titre;
    private $artiste;
    private $duree;
    private $dateAjout;
    private $sortie;
    private $bdd;
    private $song;

    public function __construct($titre,$artiste,$duree,$dateAjout,$song,$sortie = null){
        $this->titre = $titre;
        $this->artiste = $artiste;
        $this->duree = $duree;
        $this->dateAjout = $dateAjout;
        $this->sortie = $sortie;
        $this->song =$song;
        $bdd = BD::getInstance();
        $queryAddAlbum= $bdd->prepare("INSERT INTO TITRE(duree,titre) VALUES (?,?)");
        $queryAddAlbum->execute([$duree,$titre]);
    }
    public function render(){
        echo '<div class="musique">';
        echo '<img src=">'.$this->sortie->getCover().'" </img>';
        echo "<h3>".$this->titre."</h3>";
        echo '<audio controls src="'.$this->song.'"></audio>';
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
        return $this->sortie;
    }
    public function setAlbum($sortie){
        $this->sortie = $sortie;
    }
    
}