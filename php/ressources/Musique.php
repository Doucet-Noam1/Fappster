<?php
class Musique{
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
        echo '<img src=">'.$this->album.getCover().'" </img>';
        echo "<h3>".$this->titre."</h3>";
        echo "<p>". $this->artiste ."</p>";
        echo "<p>".$this->dateAjout."</p>";
        echo "<p>".$this->duree."</p>";
    }
}