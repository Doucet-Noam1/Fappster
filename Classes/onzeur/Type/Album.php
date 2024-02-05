<?php
declare(strict_types=1);
namespace onzeur\Type;
include_once 'BD.php';

class Album extends Sortie{
    public function __construct($artiste,$nom,$liste,$date,$cover){
        parent::__construct($artiste,$nom,$liste,$date,$cover,1);
    }
    public function render(){
        echo '<div class="album">';
        echo '<a class="album" href="album.php?id=$this->idAlbum">';
        if ($this->cover != null && file_exists($this->cover))
            echo '<img src="'.str_replace("%","%25",$this->cover).'"/>';
        else 
            echo '<img src="data/images/covers/null.png"/>';
        echo "<h1>".$this->nom."</h1>";
        echo "<p>".$this->date." • Album</p>";
        echo '</a>';
        echo '</div>';
    }

    public function renderDetail(){
        echo '<a class="albumDetail" href="album.php?id=$this->idAlbum">';
        if ($this->cover != null && file_exists($this->cover))
            echo '<img src="'.str_replace("%","%25",$this->cover).'"/>';
        else 
            echo '<img src="data/images/covers/null.png"/>';
        echo "<h1>". $this->nom ."</h1>";
        echo '<div id="musiques">';
        for ($i= 0;$i<count($this->liste);$i++){
            $this->liste[$i]->render();
        }
        echo '</div>';
        echo "<p>".$this->date."</p>";
        echo '</a>';
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
        $queryIDAlbum = $this->bdd->prepare("SELECT id_sortie FROM SORTIE WHERE nom = ? AND date_sortie = ? AND cover = ? AND id_type = 1");
        $queryIDAlbum->execute([$this->nom,$this->date,$this->cover]);
        $idAlbum = $queryIDAlbum->fetch();
        $idAlbum = $idAlbum['id_sortie'];
        return $idAlbum;
    }
    public function addArtiste($artiste){
        $queryAddAlbum= $this->bdd->prepare("INSERT INTO CREE(id_sortie,id_artiste) VALUES (?,?)");
        $queryAddAlbum->execute([$this->getID(),$artiste->getID()]);
        $this->artiste[] = $artiste;
    }

}