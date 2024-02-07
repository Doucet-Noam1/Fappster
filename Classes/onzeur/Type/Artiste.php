<?php 
declare(strict_types=1);
namespace onzeur\Type;
include_once 'BD.php';
class Artiste extends Utilisateur{
    private $verifie = false;
    public function __construct($nom,$mdp = null){
        parent::__construct($nom,$mdp);
        
        $queryAddArtiste= $this->bdd->prepare("INSERT INTO Artiste(id_artiste,verifie) VALUES (?,?)");
        $queryAddArtiste->execute([parent::getId(),$verifie]);
    }
}

?>