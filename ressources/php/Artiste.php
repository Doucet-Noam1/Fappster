<?php
class Artiste {
    private $nom;
    private $password;
    private $PlaylistLikes;
    private $litesNotes;


    public function __construct($nom,$password,$PlaylistLikes,$litesNotes){
        $this->nom = $nom;
        $this->password = $password;
        $this->PlaylistLikes = $PlaylistLikes;
        $this->litesNotes = $litesNotes;
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
    public function getPassword(){
        return $this->password;
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