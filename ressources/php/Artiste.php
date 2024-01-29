<?php



class Artiste {
    private $nom;
    private $mdp;
    private $PlaylistLikes;
    private $litesNotes;


    public function __construct($nom,$mdp,$PlaylistLikes,$litesNotes){
        $this->nom = $nom;
        $this->mdp = $mdp;
        $this->PlaylistLikes = $PlaylistLikes;
        $this->litesNotes = $litesNotes;

        $queryAddArtiste = $bdd->prepare("INSERT INTO ARTISTE (nom,mdp) VALUES (?,?)");
        $queryAddArtiste->execute([$nom,$mdp]);

    }
    public function render(){
        echo '<div class="artiste">';
        echo "<h1>". $this->nom ."</h1>";
        for ($i= 0;$i<count($this->litesNotes);$i++){
            $this->litesNotes[$i]->render();
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

}