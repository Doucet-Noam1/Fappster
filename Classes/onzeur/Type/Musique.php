<?php
declare(strict_types=1);
namespace onzeur\Type;

class Musique implements Irender{
    private $titre;
    private $lstartiste;
    private $duree;
    private $dateAjout;
    private $sortie;
    private $bdd;

    public function __construct($titre,$artiste,$duree,$dateAjout,$sortie = null){
        $this->titre = $titre;
        $this-> lstartiste =[];
        $this->lstartiste[] = $artiste;
        $this->duree = $duree;
        $this->dateAjout = $dateAjout;
        $this->sortie = $sortie;
        $this->bdd = BD::getInstance();
        $queryAddAlbum= $this->bdd ->prepare("INSERT INTO TITRE(duree,titre) VALUES (?,?)");
        $queryAddAlbum->execute([$duree,$titre]);
        for($i=0;$i<count($this->lstartiste);$i++){
            $queryAddArtiste= $this->bdd ->prepare("INSERT INTO CHANTER_PAR(id_titre,id_artiste) VALUES (?,?)");
            $queryAddArtiste->execute([$this->getID(),$this->lstartiste[$i]->getID()]);
        }


    }
    public function render(){
        echo '<div class="musique">';
        echo '<img src=">'.$this->sortie->getCover().'" </img>';
        echo "<h3>".$this->titre."</h3>";
        echo "div id='artistes'>";
        for ($i= 0;$i<count($this->lstartiste);$i++){
            echo "<p>".$this->lstartiste[$i]->getNom()."</p>";
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
    public function getID(){
        $queryIDMusique = $this->bdd->prepare("SELECT id_titre FROM TITRE WHERE titre = ? AND duree = ?");
        $queryIDMusique->execute([$this->titre,$this->duree]);
        $idMusique = $queryIDMusique->fetch();
        $idMusique = $idMusique['id_titre'];
        return $idMusique;
    }
    public function addArtiste($artiste){
        $queryAddMusique= $this->bdd->prepare("INSERT INTO CHANTER_PAR(id_artiste,id_titre) VALUES (?,?)");
        $queryAddMusique->execute([$artiste->getID(),$this->getID()]);
        $this->lstartiste[] =$artiste;
    }
    
}