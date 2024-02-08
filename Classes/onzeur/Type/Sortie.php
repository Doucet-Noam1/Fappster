<?php
declare(strict_types=1);

namespace onzeur\Type;
include_once 'BD.php';

abstract class Sortie implements Irender
{
    protected string $nom;
    protected string $date;
    protected string|null $cover;
    protected $liste;
    protected $artiste;
    protected $bdd;

    public function __construct($artiste,string $nom, $liste, string $date, string|null $cover,int $id_type, $id=null)
    {
        $this->nom = $nom;
        $this->date = $date;
        $this->cover = $cover;
        $this->liste = $liste;
        $this->bdd = BD::getInstance();
        $this->artiste = [$artiste];
        if($this->getID() == null){
            $queryAddAlbum= $this->bdd->prepare("INSERT INTO SORTIE(nom,date_sortie,cover,id_type) VALUES (?,?,?,?)");
        $queryAddAlbum->execute([$nom,$date,$cover,$id_type]);
        $this->addArtiste($artiste);

        for ($i= 0;$i<count($liste);$i++){
            $idMusique = $liste[$i]->getID();
            $querAddContient = $this->bdd->prepare("INSERT INTO CONTIENT(id_sortie,id_titre,position) VALUES (?,?,?)");
            $querAddContient->execute([$this->getID(),$idMusique,$i+1]);
            $querAddContient = $querAddContient->fetch();
        }
        }
        
    
    }
    public abstract function render();
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getDate(): string
    {
        return $this->date;
    }
    public function getCover(): string
    {
        return $this->cover;
    }
    public function getListe()
    {
        return $this->liste;
    }

    public function getArtiste()
    {
        return $this->artiste;
    }
    public function addArtiste($artiste){
        $queryIDAlbum = $this->bdd->prepare("SELECT id_sortie FROM CREE WHERE id_sortie = ? AND nom_artiste = ?");
        $queryIDAlbum->execute([$this->getID(),$artiste->getPseudo()]);
        $idAlbum = $queryIDAlbum->fetch();
        if ($idAlbum == null){
            $queryAddAlbum= $this->bdd->prepare("INSERT INTO CREE(id_sortie,nom_artiste) VALUES (?,?)");
            $queryAddAlbum->execute([$this->getID(),$artiste->getPseudo()]);
        }
        $this->artiste[] = $artiste;
    }
}
