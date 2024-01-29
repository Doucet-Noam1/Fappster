<?php

abstract class Sortie implements Irender{
    protected string $nom;
    protected DateTime $date;
    protected string $cover;
    protected ArrayObject $liste;

    public function __construct( string $nom,ArrayObject $liste,DateTime $date,string $cover){
        $this->label = $nom;
        $this->id = $date;
        $this->cover = $cover;
        $this->liste = $liste;
    }
    public abstract function render();
    public function getNom(): string{
        return $this->nom;
    }
    public function getDate(): DateTime{
        return $this->date;
    }
    public function getCover(): string{
        return $this->cover;
    }
    public function getListe(): ArrayObject{
        return $this->liste;
    }

}
