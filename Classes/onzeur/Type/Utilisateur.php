<?php
declare(strict_types=1);
namespace onzeur\Type;
include_once 'BD.php';


class Utilisateur {
    protected $pseudo;
    protected $mdp;
    protected $PlaylistLikes;
    protected $litesNotes;

    protected $bdd;

    public function __construct($pseudo,$mdp=null){
        $this->bdd = BD::getInstance();

        $this->pseudo = $pseudo;
        $this->mdp = $mdp;
        $this->PlaylistLikes = [];
        $this->litesNotes = [];
        if($this->getPseudo() == null){
            $queryAddArtiste= $this->bdd->prepare("INSERT INTO UTILISATEUR(pseudo,mdp) VALUES (?,?)");
            $queryAddArtiste->execute([$pseudo,$mdp]);
        }
    }
    public function render(){
        echo '<div class="artiste">';
        echo "<h1>". $this->pseudo ."</h1>";
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
    public function getPseudo(){
        return $this->pseudo;
    }
    public function getPlaylistLikes(){
        return $this->PlaylistLikes;
    }
    public function getLitesNotes(){
        return $this->litesNotes;
    }
}