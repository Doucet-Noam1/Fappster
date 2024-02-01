<?php
declare(strict_types=1);
namespace onzeur\Type;
include_once 'BD.php';

class Album extends Sortie{
    private $bdd;
    public function __construct($nom,$liste,$date,$cover){
        parent::__construct($nom,$liste,$date,$cover);
        $this->bdd = BD::getInstance();

        $queryAddAlbum= $this->bdd->prepare("INSERT INTO SORTIE(nom,annee,cover,id_type) VALUES (?,?,?,1)");
        $queryAddAlbum->execute([$nom,$date,$cover]);

        for ($i= 0;$i<count($liste);$i++){
            $queryIDMusique = $this->bdd->prepare("SELECT id_titre FROM TITRE WHERE titre = ? AND duree = ?");
            $queryIDMusique->execute([$liste[$i]->getTitre(),$liste[$i]->getDuree()]);
            $idMusique = $queryIDMusique->fetch();
            $idMusique = $idMusique['id_titre'];
    
            $querAddContient = $this->bdd->prepare("INSERT INTO CONTIENT(id_sortie,id_titre,position) VALUES (?,?,?)");
            $querAddContient->execute([$this->getID(),$idMusique,$i+1]);
            $querAddContient = $querAddContient->fetch();


        }


    }
    public function render(){
        echo '<div class="album">';
        echo '<img src=">'.$this->cover.'" </img>';
        echo "<h2>Album</h2>";
        echo "<h1>". $this->nom ."</h1>";
        echo '<div id="musiques">';
        for ($i= 0;$i<count($this->liste);$i++){
            $this->liste[$i]->render();
        }
        echo '</div>';
        echo "<p>".$this->date."</p>";
        echo '</div>';
    }

    public function getNom(): string{
        return $this->nom;
    }
    public function getCover() : string{
        return $this->cover;
    }
    public function getDate() : string{
        return $this->date;
    }
    public function getListe(){
        return $this->liste;
    }
    public function addMusique($song){
        $this->liste[] = $song;
    }

    public function getID(){
        $queryIDAlbum = $this->bdd->prepare("SELECT id_sortie FROM SORTIE WHERE nom = ? AND annee = ? AND cover = ? AND id_type = 1");
        $queryIDAlbum->execute([$this->nom,$this->date,$this->cover]);
        $idAlbum = $queryIDAlbum->fetch();
        $idAlbum = $idAlbum['id_sortie'];
        return $idAlbum;
    }
    public function setArtiste($artiste){
        $queryAddAlbum= $this->bdd->prepare("INSERT INTO CREE(id_sortie,id_artiste) VALUES (?,?)");
        $queryAddAlbum->execute([$this->getID(),$artiste->getID()]);
    }

}