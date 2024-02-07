<?php 
declare(strict_types=1);
namespace onzeur\Type;
include_once 'BD.php';
class Artiste extends Utilisateur{
    private $verifie = false;
    public function __construct($nom,$mdp = null){
        parent::__construct($nom,$mdp);
        if ($this->getID() == null){
            $queryAddArtiste= $this->bdd->prepare("INSERT INTO Artiste(id_artiste,verifie) VALUES (?,?)");
            $queryAddArtiste->execute([parent::getID(),$verifie]);
        }
    
    }
    public function getID(){
        $this->bdd = BD::getInstance();
        $queryIDArtiste = $this->bdd->prepare("SELECT id_artiste FROM ARTISTE WHERE id_artiste = ?");
        $queryIDArtiste->execute([parent::getID()]);
        $idArtiste = $queryIDArtiste->fetch();
        $idArtiste = $idArtiste['id_artiste'];
        return $idArtiste;
    }
}

?>