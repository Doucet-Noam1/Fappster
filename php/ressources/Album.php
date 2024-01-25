<?php
class Album extends Sortie{
    public function __construct($nom,$liste,$date,$cover){
        parent::__construct($nom,$liste,$date,$cover);
    }
    public function render(){
        echo '<img src=">'.$this->cover.'" </img>';
        echo "<h2>Album</h2>";
        echo "<h1>". $this->nom ."</h1>";
        for ($i= 0;$i<count($this->liste);$i++){
            $this->liste[$i].render();
        }
        echo "<p>".$this->date."</p>";
    }

}