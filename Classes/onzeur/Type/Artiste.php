<?php 
declare(strict_types=1);
namespace onzeur\Type;
include_once 'BD.php';
class Artiste extends Utilisateur{
    private $verifie = false;
    public function __construct($nom,$mdp = null){
        parent::__construct($nom,$mdp);
        if ($this->getPseudo() == null){
            $queryAddArtiste= $this->bdd->prepare("INSERT INTO Artiste(nom_artiste,verifie) VALUES (?,?)");
            $queryAddArtiste->execute([parent::getPseudo(),$this->verifie]);
        }
    
    }
    public function getPseudo(){
        $this->bdd = BD::getInstance();
        $queryNomArtiste = $this->bdd->prepare("SELECT nom_artiste FROM ARTISTE WHERE nom_artiste = ?");
        $queryNomArtiste->execute([parent::getPseudo()]);
        $nom_artiste = $queryNomArtiste->fetch();
        if ($nom_artiste == null){
            return null;
        }
        return $nom_artiste['nom_artiste'];
    }
}

?>