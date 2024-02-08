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
    protected $id_type;

    public function __construct($artiste,string $nom, $liste, string $date, string|null $cover,int $id_type)
    {
        $this->nom = $nom;
        $this->date = $date;
        $this->cover = $cover;
        $this->liste = $liste;
        $this->bdd = BD::getInstance();
        $this->artiste = [$artiste];
        $this->id_type = $id_type;
        if($this->getID() == null){
            $queryAddAlbum= $this->bdd->prepare("INSERT INTO SORTIE(nom,date_sortie,cover,id_type) VALUES (?,?,?,?)");
        $queryAddAlbum->execute([$nom,$date,$cover,$id_type]);

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
    public function getID()
    {
        $queryIDSortie = $this->bdd->prepare("SELECT id_sortie FROM SORTIE WHERE nom = ? AND date_sortie = ? AND id_type = ?");
        $queryIDSortie->execute([$this->nom,$this->date,$this->id_type]);
        $idSortie = $queryIDSortie->fetch();
        return $idSortie['id_sortie'];
    }

}
