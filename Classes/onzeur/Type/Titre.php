<?php
declare(strict_types=1);
namespace onzeur\Type;

class Titre implements Irender{
    private $titre;
    private $lstartiste;
    private $duree;
    private $dateAjout;
    private $sortie;
    private $bdd;
    private $song;

    public function __construct($titre,$artiste,$duree,$dateAjout,$song,$sortie = null){
        $this->titre = $titre;
        $this-> lstartiste =[];
        $this->lstartiste[] = $artiste;
        $this->duree = $duree;
        $this->dateAjout = $dateAjout;
        $this->sortie = $sortie;
        $this->song =$song;
        $this->bdd = BD::getInstance();
        if($this->getID() == null)
        {$queryAddAlbum= $this->bdd->prepare("INSERT INTO TITRE(duree,titre) VALUES (?,?)");
            $queryAddAlbum->execute([$duree,$titre]);
            for($i=0;$i<count($this->lstartiste);$i++){
                $queryAddArtiste= $this->bdd ->prepare("INSERT INTO CHANTER_PAR(id_titre,nom_artiste) VALUES (?,?)");
                $queryAddArtiste->execute([$this->getID(),$this->lstartiste[$i]->getPseudo()]);
            }}
        


    }
    public function render(){
        echo '<div class="musique">';
        echo '<img src=">'.$this->sortie->getCover().'" </img>';
        echo "<h3>".$this->titre."</h3>";
        echo "div id='artistes'>";
        for ($i= 0;$i<count($this->lstartiste);$i++){
            echo "<p>".$this->lstartiste[$i]->getPseudo()."</p>";
        }
        echo "</div>";
        echo "<p>".$this->dateAjout."</p>";
        echo "<p>".$this->duree."</p>";
        echo '</div>';
    }
    public function getTitre(){
        return $this->titre;
    }
    public function getArtiste(){
        return $this->lstartiste;
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
    public function getPosition()
    {
        return 1; // pas bien
    }
    public function getID():int{
        return BD::getIdTitre($this);
    }
    public function addArtiste(Artiste $artiste){
        BD::addArtisteToTitre($this,$artiste);
        $this->lstartiste[] = $artiste;
    }
    
}