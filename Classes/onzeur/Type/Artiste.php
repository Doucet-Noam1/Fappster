<?php 
declare(strict_types=1);
namespace onzeur\Type;
include_once 'BD.php';
class Artiste extends Utilisateur{
    private $verifie = false;
    public function __construct($nom,$mdp = null){
        parent::__construct($nom,$mdp);
        BD::addArtiste($this);
    }
    public function getVerifie(){
        return $this->verifie;
    }
}
?>