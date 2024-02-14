<?php
declare(strict_types=1);
namespace onzeur\Type;

include_once 'BD.php';
class Artiste extends Utilisateur
{
    private $verifie = false;
    public function __construct(string $pseudo, bool $verifie = false)
    {
        parent::__construct($pseudo);
        BD::addArtiste($this);
    }
    public function getVerifie(): bool
    {
        return $this->verifie;
    }
    public function setVerifie(bool $verifie)
    {
        $this->verifie = $verifie;
    }
    public function render(){
        echo "<div id='profil' class='artiste'>";
        $this->renderProfil();
        $likes = BD::getTitresBy($this);
        echo "<h2>Titres</h2>";
        echo "<div id='likes'>";
        foreach ($likes as $sortie) {
            $sortie->render();
        }
        if(count($likes)==0){
            echo "<p>Aucun titre...</p>";
        }
        echo "</div>";
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