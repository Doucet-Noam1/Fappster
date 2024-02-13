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
    const PATH = "data/images/users/";
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
        echo "<h1>" . $this->pseudo . "</h1>";
        for ($i = 0; $i < count($this->listeNotes); $i++) {
            $this->listeNotes[$i]->render();
        }
        foreach (BD::getSortiesBy($this) as $sortie) {
            $sortie->render();
        }
    }

    public function renderProfil()
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
        if(!file_exists(self::PATH.$this->pseudo.".jpg")){
            return self::PATH."defaultuser.png";
        }
        return self::PATH.$this->pseudo.".jpg";
    }
    public function getPlaylistLikes(){

    
        return $this->PlaylistLikes;
    }
    public function getListeNotes()
    {
        return $this->listeNotes;
    }
    
}