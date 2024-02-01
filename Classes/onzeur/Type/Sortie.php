<?php
declare(strict_types=1);

namespace onzeur\Type;


abstract class Sortie implements Irender{
    protected string $nom;
    protected string $date;
    protected string|null $cover;
    protected $liste;

    public function __construct( string $nom,$liste,string $date,string|null $cover){
        $this->nom = $nom;
        $this->date = $date;
        $this->cover = $cover;
        $this->liste = $liste;
    }
    public abstract function render();
    public function getNom(): string{
        return $this->nom;
    }
    public function getDate():string{
        return $this->date;
    }
    public function getCover(): string{
        return $this->cover;
    }
    public function getListe(){
        return $this->liste;
    }

}
