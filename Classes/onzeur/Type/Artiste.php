<?php
declare(strict_types=1);
namespace onzeur\Type;

include_once 'BD.php';
class Artiste extends Utilisateur
{
    private $verifie = false;
    public function __construct(string $pseudo, $mdp = null)
    {
        parent::__construct($pseudo, mdp:$mdp);
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