<?php
declare(strict_types=1);
namespace onzeur\Type;

include_once 'BD.php';


class Utilisateur
{
    protected string $pseudo;
    protected string $nom;
    protected string $prenom;
    protected ?string $mdp;
    protected array $listeNotes;
    protected array $PlaylistLikes;
    public function __construct($pseudo,$nom="John",$prenom="Doe",$mdp=null){

        $this->pseudo = $pseudo;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdp = $mdp;
        $this->PlaylistLikes = [];
        $this->listeNotes = [];
        BD::addUtilisateur($this);
    }
    public function render()
    {
        echo "<div id='profil' class='utilisateur'>";
        $this->renderProfil();
        echo "</div>";
    }

    protected function renderProfil(){
        echo "<h1>" . $this->pseudo . "</h1>";
        echo '<img src="'.$this->getPhoto().'" id="imageDeProfil">';
        echo "</div>";
        if(BD::estArtiste($this->pseudo)){
            echo "<h2>Sorties de l'artiste</h2>";
            echo "<div id='sorties'>";
            $sorties = BD::getSortiesCommercialBy(BD::getArtiste($this->pseudo));
            foreach ($sorties as $sortie) {
                $sortie->render();
            }
            if(count($sorties)==0){
                echo "<p>Cet artiste n'a aucune sortie...</p>";
            }
            echo "</div>";
        }
        echo "<h2>Playlists</h2>";
        echo "<div id='playlists'>";
        $playlists = BD::getPlaylistsBy($this);
        foreach ($playlists as $playlist) {
            $playlist->render();
        }
        if(count($playlists)==0){
            echo "<p>Aucune playlist...</p>";
        }
        echo "</div>";
        echo "<h2>Sorties aimées</h2>";
        $likes = BD::getLikesBy($this);
        echo "<div id='likes'>";
        foreach ($likes as $sortie) {
            $sortie->render();
        }
        if(count($likes)==0){
            echo "<p>Aucune sortie aimée...</p>";
        }
        echo "</div>";
    }

    public function renderAdmin(){
        echo "<td>" . $this->pseudo . "</td>";
        echo "<td><img src='".$this->getPhoto()."' id='imageDeProfil'></td>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<td>" . $splitNameSpace . "</td>";
        echo "<td><a href='modifierArtiste.php?pseudo=".$this->pseudo."'>modifier</a></td>";
        echo "<td><a href='supprimerArtiste.php?pseudo=".$this->pseudo."'>supprimer</a></td>";
    }

    public function renderMini()
    {
        echo '<a href="profil.php">';
        echo '<img src="'.$this->getPhoto().'" id="pfp">';
        echo '<span>'.$this->pseudo.'</span>';
        echo '</a>';
    }

    public function addNote(Titre $song)
    {
        $this->listeNotes[] = $song;
    }
    public function getMdp()
    {
        return $this->mdp;
    }
    public function getPseudo()
    {
        return $this->pseudo;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getPrenom()
    {
        return $this->prenom;
    }
    public function getPhoto(){
        if(!file_exists(BD::DOSSIERUSERS.$this->pseudo.".jpg")){
            return BD::DOSSIERUSERS."defaultuser.png";
        }
        return BD::DOSSIERUSERS.$this->pseudo.".jpg";
    }
    public function getPlaylistLikes(){

    
        return $this->PlaylistLikes;
    }
    public function getListeNotes()
    {
        return $this->listeNotes;
    }
    
}