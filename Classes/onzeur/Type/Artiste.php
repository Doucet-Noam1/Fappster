<?php
declare(strict_types=1);
namespace onzeur\Type;

include_once 'BD.php';
class Artiste extends Utilisateur
{
    private bool $verifie;
    public function __construct(string $pseudo, bool $verifie = false)
    {
        parent::__construct($pseudo);
        $this->verifie = $verifie;
        BD::addArtiste($this);
    }
    public function getVerifie(): bool
    {
        return $this->verifie;
    }
    public function setVerifie(bool $verifie)
    {
        $this->verifie = $verifie;
        BD::setVerifie($this, $verifie);
    }
    public function render(){
        echo "<div id='profil' class='artiste'>";
        echo "<h1 ".($this->verifie?"class='verified'":"").">" . $this->pseudo. "</h1>";
        echo '<img src="'.$this->getPhoto().'" id="imageDeProfil">';
        echo "</div>";
        $this->renderSorties();
        $this->renderPlaylists();
        $this->renderLikes();
        $this->renderTitres();
    }

    protected function renderSorties(){
        echo "<h2>Sorties de l'artiste</h2>";
        echo "<div id='sorties'>";
        $sorties = BD::getSortiesCommercialBy($this);
        foreach ($sorties as $sortie) {
            $sortie->render();
        }
        if(count($sorties)==0){
            echo "<p>Cet artiste n'a aucune sortie...</p>";
        }
        echo "</div>";
    }

    protected function renderTitres(){
        echo "<h2>Titres</h2>";
        echo "<div id='likes'>";
        $titres = BD::getTitresBy($this);
        foreach ($titres as $titre) {
            $titre->render();
        }
        if(count($titres)==0){
            echo "<p>Aucun titre...</p>";
        }
    }

    public function __toJson(): array
    {
        $json = array(
            "pseudo" => $this->pseudo,
            "verifie" => $this->verifie
        );
        return $json;
    }
    
}
?>