<?php
declare(strict_types=1);

namespace onzeur\Type;

include_once 'BD.php';
abstract class Sortie implements Irender
{
    protected string $nom;
    protected string $date;
    protected ?string $cover;
    protected array $listeTitres;
    protected array $artiste;
    protected int $id_type;
    protected bool $visibilite;

    public function __construct(Artiste|array|Utilisateur $artiste, string $nom, array $listeTitres, string $date, ?string $cover, int $id_type, bool $visibilite = true, int $id = null)
    {
        $this->nom = $nom;
        $this->date = $date;
        $this->cover = $cover;
        $this->listeTitres = $listeTitres;
        $this->visibilite = $visibilite;
        is_array($artiste) ? $this->artiste = $artiste : $this->artiste = [$artiste];
        $this->id_type = $id_type;
        BD::addSortie($this);
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
    public function getCover(): ?string
    {
        return $this->cover;
    }
    public function getListeTitres(): array
    {
        return $this->listeTitres;
    }
    public function getType(): int
    {
        return $this->id_type;
    }
    public function getID(): ?int
    {
        return BD::getIdSortie($this);
    }

    /**
     * @return Artiste[] liste de tout les artistes ayant participé à la sortie
     */
    public function getArtiste(): array
    {
        return $this->artiste;
    }
    public function addArtiste(Artiste $artiste)
    {
        BD::addArtisteToSortie($this, $artiste);
        $this->artiste[] = $artiste;
    }

    public function getNombreDeTitres(): int
    {
        return count($this->listeTitres);
    }
    public function getVisibilite(): bool{
        return $this->visibilite;
    }
    static function factory(Utilisateur|array $artiste, string $nom, array $listeTitres, string $date, ?string $cover, int $id_type, array $listeGenres,bool $visibilite, int $id = null): SortieCommerciale|Playlist
    {
        $id = null;
        switch ($id_type) {
            case 1:
                return new Album($artiste, $nom, $listeTitres, $date, $cover, $listeGenres,$visibilite, $id);
            case 2:
                return new Single($artiste, $nom, $listeTitres, $date, $cover, $listeGenres,$visibilite, $id);
            case 3:
                return new EP($artiste, $nom, $listeTitres, $date, $cover, $listeGenres,$visibilite, $id);
            case 4:
                return new PlayList($artiste, $nom, $cover,$visibilite, $listeTitres, $id);
            default:
                throw new \Exception("Type de sortie inconnu");
        }
    }
    public function addTitre($song)
    {
        $this->listeTitres[] = $song;
    }
}
