<?php 
declare(strict_types=1);

namespace onzeur\Type;
use Sortie;


class PlayList extends Sortie{
    public function __construct($nom,ArrayObject $liste,$date,$cover){
        parent::__construct($nom,$liste,$date,$cover);
    }
    public function render(){
        echo '<div class="playlist">';
        echo '<img src=">'.$this->cover.'" </img>';
        echo "<h2>EP</h2>";
        echo "<h1>". $this->nom ."</h1>";
        for ($i= 0;$i<count($this->liste);$i++){
            $this->liste[$i]->render();
        }
        echo "<p>".$this->date."</p>";
        echo '</div>';
    }
    public function getNom() : string{
        return $this->nom;
    }
    public function getCover() : string{
        return $this->cover;
    }
    public function getDate() : string{
        return $this->date;
    }
    public function getListe() : string{
        return $this->liste;
    }
    public function addMusique($song){
        $this->liste[] = $song;
    }
}
