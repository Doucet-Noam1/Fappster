<?php 
class EP extends Sortie{
    public function __construct($nom,$liste,$date,$cover){
        parent::__construct($nom,$liste,$date,$cover);
        $queryAddAlbum= $bdd->prepare("INSERT INTO SORTIE(nom,annee,cover,id_type) VALUES (?,?,?,3)");
        $queryAddAlbum->execute([$nom,$date,$cover]);
    }
    public function render(){
        echo '<div class="ep">';
        echo '<img src=">'.$this->cover.'" </img>';
        echo "<h2>EP</h2>";
        echo "<h1>". $this->nom ."</h1>";
        for ($i= 0;$i<count($this->liste);$i++){
            $this->liste[$i]->render();
        }
        echo "<p>".$this->date."</p>";
        echo '</div>';
    }
    public function getNom(){
        return $this->nom;
    }
    public function getCover(){
        return $this->cover;
    }
    public function getDate(){
        return $this->date;
    }
    public function getListe(){
        return $this->liste;
    }
    public function addMusique($song){
        $this->liste[] = $song;
    }

}
