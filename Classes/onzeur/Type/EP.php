<?php 
declare(strict_types=1);

namespace onzeur\Type;



class EP extends SortieCommerciale{
    public function __construct(Artiste $artiste,string $nom,array $listeTitres,string $date,string|null $cover,array $genres, int $id = null){
        parent::__construct($artiste,$nom,$listeTitres,$date,$cover,3,$genres);
    }
    public function render(){
        echo '<div class="album">';
        echo '<a class="albumDetail" href="sortie.php?id='.$this->getID().'">';
        if ($this->cover != null && file_exists($this->cover))
            echo '<img src="'.str_replace("%","%25",$this->cover).'"/>';
        else 
            echo '<img src="data/images/covers/null.png"/>';
        echo "<h1>".$this->nom."</h1>";
        echo "<p>".$this->date." • EP</p>";
        echo '</a>';
        echo '</div>';
    }

    public function renderDetail(){
        echo '<a class="albumDetail" href="sortie.php?id='.$this->getID().'">';
        if ($this->cover != null && file_exists($this->cover))
            echo '<img src="'.str_replace("%","%25",$this->cover).'"/>';
        else 
            echo '<img src="data/images/covers/null.png"/>';
        echo "<h1>". $this->nom ."</h1>";
        echo '<div id="musiques">';
        for ($i= 0;$i<count($this->listeTitres);$i++){
            $this->listeTitres[$i]->render();
        }
        echo '</div>';
        echo "<p>".$this->date."</p>";
        echo '</a>';
    }
}
