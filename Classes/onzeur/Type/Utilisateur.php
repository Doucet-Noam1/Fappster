<?php
declare(strict_types=1);
namespace onzeur\Type;
include_once 'BD.php';


class Utilisateur {
    protected $nom;
    protected $mdp;
    protected $PlaylistLikes;
    protected $litesNotes;

    protected $bdd;

    public function __construct($nom,$mdp=null){
        $this->bdd = BD::getInstance();

        $this->nom = $nom;
        $this->mdp = $mdp;
        $this->PlaylistLikes = [];
        $this->litesNotes = [];
        if($this->getPseudo() == null){
            $queryAddArtiste= $this->bdd->prepare("INSERT INTO UTILISATEUR(pseudo,mdp) VALUES (?,?)");
            $queryAddArtiste->execute([$nom,$mdp]);
        }



    }
    public function render(){
        echo '<div class="artiste">';
        echo "<h1>". $this->nom ."</h1>";
        for ($i= 0;$i<count($this->litesNotes);$i++){
            $this->litesNotes[$i]->render();
        }
        foreach(BD::getSortiesBy($this) as $sortie){
            $sortie->render();
        }
        echo '</div>';

    } 

    public function addNote($song){
        $this->litesNotes->append($song);
    }
    public function getMdp(){
        return $this->mdp;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPlaylistLikes(){
        return $this->PlaylistLikes;
    }
    public function getLitesNotes(){
        return $this->litesNotes;
    }
    public function getPseudo(){
        $this->bdd = BD::getInstance();
        $queryIDArtiste = $this->bdd->prepare("SELECT pseudo FROM UTILISATEUR WHERE pseudo = ?");
        $queryIDArtiste->execute([$this->nom]);
        $idArtiste = $queryIDArtiste->fetch();
        if ($idArtiste == null){
            return null;
        }
        return $idArtiste['pseudo'];
    }

    

}