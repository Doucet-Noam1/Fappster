<?php
declare(strict_types=1);

namespace onzeur\Type;

include 'loadbd.php';

class BD
{
    private static $bdd;
    public const DOSSIERAUDIOS = 'data/audios/';
    public const DOSSIERCOVERS = 'data/images/covers/';
    public const DOSSIERUSERS = 'data/images/users/';
    private function __construct()
    {
        try {

            self::$bdd = loadbd();

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS UTILISATEUR ( 
                pseudo VARCHAR(30) PRIMARY KEY,
                nom TEXT default NULL,
                prenom TEXT default NULL,
                mdp TEXT default NULL
            )');
            self::$bdd->exec('CREATE TABLE IF NOT EXISTS ARTISTE(
                nom_artiste VARCHAR(30) PRIMARY KEY,
                verifie BOOLEAN DEFAULT FALSE,
                FOREIGN KEY(nom_artiste) REFERENCES UTILISATEUR(pseudo) ON DELETE CASCADE
            )');
            self::$bdd->exec('CREATE TABLE IF NOT EXISTS TYPE_SORTIE (
                id_type INTEGER PRIMARY KEY AUTOINCREMENT,
                libelle TEXT
            )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS SORTIE (
                id_sortie INTEGER PRIMARY KEY AUTOINCREMENT,
                nom_sortie TEXT,
                date_sortie DATE,
                cover TEXT,
                id_type INTEGER NOT NULL,
                visibilite BOOLEAN DEFAULT TRUE,
                FOREIGN KEY(id_type) REFERENCES TYPE_SORTIE(id_type)
            )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS AVIS (
                id_sortie INTEGER,
                pseudo VARCHAR(30),
                note INTEGER,
                favori BOOLEAN default false,
                FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie),
                FOREIGN KEY(pseudo) REFERENCES UTILISATEUR(pseudo) ON DELETE CASCADE,
                PRIMARY KEY(id_sortie,pseudo)
            )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS CREE (
            id_sortie INTEGER,
            nom_artiste VARCHAR(30),
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie) ON DELETE CASCADE,
            FOREIGN KEY(nom_artiste) REFERENCES UTILISATEUR(pseudo) ON DELETE CASCADE,
            PRIMARY KEY(id_sortie,nom_artiste)
        )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS PRODUIT (
            id_sortie INTEGER,
            nom_artiste VARCHAR(30),
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie),
            FOREIGN KEY(nom_artiste) REFERENCES ARTISTE(nom_artiste) ON DELETE CASCADE,
            PRIMARY KEY(id_sortie,nom_artiste)
        )');


            self::$bdd->exec('CREATE TABLE IF NOT EXISTS GENRE(
            nom_genre TEXT PRIMARY KEY
        )');


            self::$bdd->exec('CREATE TABLE IF NOT EXISTS A_POUR_STYLE(
            nom_genre TEXT,
            id_sortie INTEGER,
            FOREIGN KEY(nom_genre) REFERENCES GENRE(nom_genre),
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie) ON DELETE CASCADE,
            PRIMARY KEY(nom_genre,id_sortie)
        )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS TITRE(
            id_titre INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_titre TEXT,
            duree INTEGER,
            nom_fichier VARCHAR(50)
        )');
            self::$bdd->exec('CREATE TABLE IF NOT EXISTS CONTIENT (
            id_sortie INTEGER,
            id_titre INTEGER,
            position INTEGER,
            id_sortie_initiale INTEGER default null,
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie) ON DELETE CASCADE,
            FOREIGN KEY(id_sortie_initiale) REFERENCES SORTIE(id_sortie),
            FOREIGN KEY(id_titre) REFERENCES TITRE(id_titre) ON DELETE CASCADE,
            PRIMARY KEY(id_sortie,id_titre)
        )');
            self::$bdd->exec('CREATE TABLE IF NOT EXISTS CHANTER_PAR(
            nom_artiste VARCHAR(30),
            id_titre INTEGER ,
            FOREIGN KEY(nom_artiste) REFERENCES ARTISTE(nom_artiste) ON DELETE CASCADE,
            FOREIGN KEY(id_titre) REFERENCES TITRE(id_titre),
            PRIMARY KEY(nom_artiste,id_titre)
        )');

            self::$bdd->exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Album")');
            self::$bdd->exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Single")');
            self::$bdd->exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("EP")');
            self::$bdd->exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Playlist")');
            // var_dump(self::$bdd);



        } catch (\PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    static function getInstance()
    {
        if (!(file_exists('fappster.db'))) {
            new BD;
            peupleBD();
        }
        return loadbd();
    }
    static function addArtiste(Artiste $artiste)
    {
        $bdd = BD::getInstance();
        if (BD::estArtiste($artiste->getPseudo()) == false) {
            $bdd->beginTransaction();
            $queryAddArtiste = $bdd->prepare("INSERT INTO ARTISTE(nom_artiste,verifie) VALUES (?,?)");
            $queryAddArtiste->execute([$artiste->getPseudo(), $artiste->getVerifie()]);
            $bdd->commit();
        }
    }

    static function getAllTypes()
    {
        $queryTypes = BD::getInstance()->prepare("SELECT * FROM TYPE_SORTIE");
        $queryTypes->execute();
        $types = $queryTypes->fetchAll();
        $res = [];
        foreach ($types as $type) {
            $res[$type['id_type']] = $type['libelle'];
        }
        return $res;
    }

    static function addSortie(Sortie $sortie)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        if (BD::getIdSortie($sortie) == null) {
            $queryAddAlbum = $bdd->prepare("INSERT INTO SORTIE(nom_sortie,date_sortie,cover,id_type,visibilite) VALUES (?,?,?,?,?)");
            $queryAddAlbum->execute([$sortie->getNom(), $sortie->getDate(), $sortie->getCover(), $sortie->getType(), $sortie -> getVisibilite()]);
            $bdd->commit();
        }
        foreach ($sortie->getArtiste() as $artiste) {
            BD::addArtisteToSortie($sortie, $artiste);
        }
        foreach ($sortie->getListeTitres() as $titre) {
            BD::addTitreToSortie($sortie, $titre);
        }
    }

    static function toggleVisibilite(Sortie $sortie){
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $querryInsert = $bdd->prepare('INSERT OR REPLACE INTO SORTIE(nom_sortie,date_sortie,cover,id_type,visibilite) VALUES (?,?,?,?,?)');
        $querryInsert->execute([$sortie->getNom(), $sortie->getDate(), $sortie->getCover(), $sortie->getType(), $sortie -> getVisibilite()]);
        $bdd -> commit();
    }

    static function addUtilisateur(Utilisateur $utilisateur)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $queryUtilisateur = $bdd->prepare("SELECT pseudo FROM UTILISATEUR WHERE pseudo = ?");
        $queryUtilisateur->execute([$utilisateur->getPseudo()]);
        $resUtilisateur = $queryUtilisateur->fetch();
        if (!$resUtilisateur) {
            $queryAddUtilisateur = $bdd->prepare("INSERT INTO UTILISATEUR(pseudo,nom,prenom,mdp) VALUES (?,?,?,?)");
            $mdp = $utilisateur->getMdp() == null ? $utilisateur->getMdp() : hash('sha256', $utilisateur->getMdp());
            $queryAddUtilisateur->execute([$utilisateur->getPseudo(), $utilisateur->getNom(), $utilisateur->getPrenom(), $mdp]);
        }
        $bdd->commit();
    }

    static function addTitre(Titre $titre)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $queryTitre = $bdd->prepare("SELECT id_titre FROM TITRE WHERE nom_titre = ? AND duree = ? AND nom_fichier = ?");
        $queryTitre->execute([$titre->getTitre(), $titre->getDuree(), $titre->getFichier()]);
        $resTitre = $queryTitre->fetch();
        if (!$resTitre) {
            $queryAddTitre = $bdd->prepare("INSERT INTO TITRE(nom_titre,duree,nom_fichier) VALUES (?,?,?)");
            $queryAddTitre->execute([$titre->getTitre(), $titre->getDuree(), $titre->getFichier()]);
        }
        $bdd->commit();
        foreach ($titre->getArtiste() as $artiste) {
            BD::addArtisteToTitre($titre, $artiste);
        }
    }

    static function addTitreToSortie(Sortie $sortie, Titre $titre, SortieCommerciale|null $sortie_initial = null)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();

        foreach ($titre->getArtiste() as $artiste) {
            $queryArtiste = $bdd->prepare("SELECT nom_artiste FROM CHANTER_PAR WHERE nom_artiste = ? AND id_titre = ?");
            $queryArtiste->execute([$artiste->getPseudo(), $titre->getID()]);
            $resArtiste = $queryArtiste->fetch();
            if (!$resArtiste) {
                $queryAddArtiste = $bdd->prepare("INSERT INTO CHANTER_PAR(nom_artiste,id_titre) VALUES (?,?)");
                $queryAddArtiste->execute([$artiste->getPseudo(), $titre->getID()]);
            }
        }
        $queryTitre = $bdd->prepare("SELECT id_titre FROM CONTIENT WHERE id_sortie = ? AND id_titre = ?");
        $queryTitre->execute([$sortie->getID(), $titre->getID()]);
        $resTitre = $queryTitre->fetch();
        if ($resTitre) {
            $bdd->commit();
            return;
        }
        $position = BD::getNombreDeTitres($sortie) + 1;
        if ($sortie->getType() == 4) {
            $queryAddTitre = $bdd->prepare("INSERT INTO CONTIENT(id_sortie,id_titre,position,id_sortie_initiale) VALUES (?,?,?,?)");
            $queryAddTitre->execute([$sortie->getID(), $titre->getID(), $position, $sortie_initial->getID()]);
        } else {
            $queryAddTitre = $bdd->prepare("INSERT INTO CONTIENT(id_sortie,id_titre,position) VALUES (?,?,?)");
            $queryAddTitre->execute([$sortie->getID(), $titre->getID(), $position]);
        }
        $bdd->commit();
    }
    static function getSortieInitiale(Titre $titre): ?SortieCommerciale
    {
        $bdd = BD::getInstance();
        $queryTitre = $bdd->prepare("SELECT id_sortie_initiale FROM CONTIENT WHERE id_sortie = ? AND id_titre = ?");
        $queryTitre->execute([$titre->getAlbum()->getID(), $titre->getID()]);
        $resTitre = $queryTitre->fetch();
        return BD::getSortie($resTitre['id_sortie_initiale']);
    }
    static function getNombreDeTitres(Sortie $sortie): int
    {
        $bdd = BD::getInstance();
        $queryNombreDeTitres = $bdd->prepare("SELECT COUNT(id_titre) FROM CONTIENT WHERE id_sortie = ?");
        $queryNombreDeTitres->execute([$sortie->getID()]);
        $nombreDeTitres = $queryNombreDeTitres->fetch();
        return $nombreDeTitres[0];
    }
    static function estArtiste(string|Utilisateur $pseudo): bool
    {
        if ($pseudo instanceof Utilisateur) {
            $pseudo = $pseudo->getPseudo();
        }
        $queryArtiste = BD::getInstance()->prepare("SELECT * FROM ARTISTE WHERE nom_artiste = ?");
        $queryArtiste->execute([$pseudo]);
        $artiste = $queryArtiste->fetch();
        return $artiste != null;
    }

    static function getArtiste($nom): ?Artiste
    {
        $queryArtiste = BD::getInstance()->prepare("SELECT * FROM ARTISTE WHERE nom_artiste = ?");
        $queryArtiste->execute([$nom]);
        $artiste = $queryArtiste->fetch();
        return new Artiste($artiste['nom_artiste'] ?? $nom, boolval($artiste['verifie'] ?? false));
    }

    static function getGenresSortie($idSortie): array
    {
        $queryGenres = BD::getInstance()->prepare("SELECT nom_genre FROM A_POUR_STYLE WHERE id_sortie = ?");
        $queryGenres->execute([$idSortie]);
        $genres = $queryGenres->fetchAll();
        if ($genres == null) {
            return [];
        }
        $res = [];
        foreach ($genres as $genre) {
            $res[] = $genre['nom_genre'];
        }
        return $res;
    }

    static function getTitresSortie($idSortie): array
    {

        $queryTitres = BD::getInstance()->prepare("SELECT id_titre FROM CONTIENT WHERE id_sortie = ? ORDER BY (position)");
        $queryTitres->execute([$idSortie]);
        $titres = $queryTitres->fetchAll();
        $res = [];
        foreach ($titres as $titre) {
            $res[] = self::getTitre($titre['id_titre'], $idSortie);
        }
        return $res;
    }

    static function getArtistesSortie($idSortie): array
    {
        $queryArtiste = BD::getInstance()->prepare("SELECT nom_artiste FROM CREE WHERE id_sortie = ?");
        $queryArtiste->execute([$idSortie]);
        $artistes = $queryArtiste->fetchAll();
        $res = [];
        foreach ($artistes as $artiste) {
            $res[] = self::estArtiste($artiste['nom_artiste']) ? self::getArtiste($artiste['nom_artiste']) : self::getUtilisateur($artiste['nom_artiste']);
        }
        return $res;
    }

    static function getSortie($id): SortieCommerciale|Playlist|null
    {
        $querySortie = BD::getInstance()->prepare("SELECT * FROM SORTIE WHERE id_sortie = ?");
        $querySortie->execute([$id]);
        $sortie = $querySortie->fetch();
        if ($sortie == null) {
            return null;
        }
        $artiste = self::getArtistesSortie($id);
        $genres = self::getGenresSortie($id);
        $titres = self::getTitresSortie($id);
        return Sortie::factory($artiste, $sortie["nom_sortie"], $titres, strval($sortie["date_sortie"]), $sortie["cover"], $sortie["id_type"], $genres,boolval($sortie['visibilite']), intval($id));
    }

    static function getTitre(int $id, int|string|null $idsortie = null): ?Titre
    {
        $idsortie = intval($idsortie);
        $queryTitre = BD::getInstance()->prepare("SELECT * FROM TITRE WHERE id_titre = ?");
        $queryTitre->execute([$id]);
        $titre = $queryTitre->fetch();
        if ($titre == null) {
            return null;
        }
        $artistes = self::getArtistesTitre($id);
        if (count($artistes) > 0) {
            $res = new Titre($titre['nom_titre'], array_shift($artistes), $titre['duree'], $titre['id_titre'], $titre['nom_fichier'], $idsortie);
            foreach ($artistes as $artiste) {
                $res->addArtiste($artiste);
            }
            return $res;
        }
        return null;
    }


    static function getUtilisateur(string $pseudo): ?Utilisateur
    {
        $queryUtilisateur = BD::getInstance()->prepare("SELECT * FROM UTILISATEUR WHERE pseudo = ?");
        $queryUtilisateur->execute([$pseudo]);
        $utilisateur = $queryUtilisateur->fetch();
        if ($utilisateur == null) {
            return null;
        }
        $utilisateur['nom'] = $utilisateur['nom'] != null ? $utilisateur['nom'] : "Doe";
        $utilisateur['prenom'] = $utilisateur['prenom'] != null ? $utilisateur['prenom'] : "John";
        $utilisateur['mdp'] = $utilisateur['mdp'] != null ? $utilisateur['mdp'] : null;
        return new Utilisateur($pseudo, $utilisateur['nom'], $utilisateur['prenom'], $utilisateur['mdp']);
    }

    static function getArtistesTitre($idTitre): array
    {
        $queryArtiste = BD::getInstance()->prepare("SELECT nom_artiste FROM CHANTER_PAR WHERE id_titre = ?");
        $queryArtiste->execute([$idTitre]);
        $artistes = $queryArtiste->fetchAll();
        $res = [];
        foreach ($artistes as $artiste) {
            $res[] = self::getArtiste($artiste['nom_artiste']);
        }
        return $res;
    }

    static function getSortiesBy(Artiste $artiste)
    {
        $querySorties = BD::getInstance()->prepare("SELECT id_sortie FROM SORTIE NATURAL JOIN CREE WHERE nom_artiste = ?");
        $querySorties->execute([$artiste->getPseudo()]);
        $sorties = $querySorties->fetchAll();
        $res = [];
        foreach ($sorties as $sortie) {
            $res[] = self::getSortie($sortie['id_sortie']);
        }
        return $res;
    }
    static function getSortiesCommercialBy(Artiste $artiste)
    {
        $querySorties = BD::getInstance()->prepare("SELECT id_sortie FROM SORTIE NATURAL JOIN CREE WHERE nom_artiste = ? and id_type != 4");
        $querySorties->execute([$artiste->getPseudo()]);
        $sorties = $querySorties->fetchAll();
        $res = [];
        foreach ($sorties as $sortie) {
            $res[] = self::getSortie($sortie['id_sortie']);
        }
        return $res;
    }

    static function getPlaylistsBy(Utilisateur $utilisateur): array
    {
        $queryPlaylists = BD::getInstance()->prepare("SELECT id_sortie FROM SORTIE NATURAL JOIN CREE WHERE nom_artiste = ? AND id_type = 4");
        $queryPlaylists->execute([$utilisateur->getPseudo()]);
        $playlists = $queryPlaylists->fetchAll();
        $res = [];
        foreach ($playlists as $playlist) {
            $res[] = self::getSortie($playlist['id_sortie']);
        }
        return $res;
    }

    static function getLikesBy(Utilisateur $utilisateur): array
    {
        $queryLikes = BD::getInstance()->prepare("SELECT id_sortie FROM AVIS WHERE pseudo = ? AND favori = 1");
        $queryLikes->execute([$utilisateur->getPseudo()]);
        $likes = $queryLikes->fetchAll();
        $res = [];
        foreach ($likes as $like) {
            $res[] = self::getSortie($like['id_sortie']);
        }
        return $res;
    }

    static function getTitresBy(Artiste $artiste): array
    {
        $queryTitres = BD::getInstance()->prepare("SELECT id_titre FROM TITRE NATURAL JOIN CHANTER_PAR WHERE nom_artiste = ?");
        $queryTitres->execute([$artiste->getPseudo()]);
        $titres = $queryTitres->fetchAll();
        $res = [];
        foreach ($titres as $titre) {
            $res[] = self::getTitre($titre['id_titre']);
        }
        return $res;
    }

    static function getAllGenres()
    {
        $queryGenres = BD::getInstance()->prepare("SELECT * FROM GENRE");
        $queryGenres->execute();
        $genres = $queryGenres->fetchAll();
        $res = [];
        foreach ($genres as $genre) {
            $res[] = $genre['nom_genre'];
        }
        return $res;
    }

    /**
     * @param SortieCommerciale $sortieCommerciale
     * @param string $genreBrut
     * @return string le genre ajouté, formaté pour la base de données
     */
    static function addGenre(SortieCommerciale $sortieCommerciale, string $genreBrut)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $genre = mb_convert_case(str_replace(["-", "_"], " ", $genreBrut), MB_CASE_TITLE, "UTF-8");
        $queryGenre = $bdd->prepare("SELECT nom_genre FROM GENRE WHERE nom_genre = ?");
        $queryGenre->execute([$genre]);
        $resGenre = $queryGenre->fetch();
        if (!$resGenre) {
            $queryAddGenre = $bdd->prepare("INSERT INTO GENRE(nom_genre) VALUES (?)");
            $queryAddGenre->execute([$genre]);
        }
        $queryCheckGenre = $bdd->prepare("SELECT * FROM A_POUR_STYLE WHERE nom_genre = ? AND id_sortie = ?");
        $queryCheckGenre->execute([$genre, $sortieCommerciale->getID()]);
        $resCheckGenre = $queryCheckGenre->fetch();
        if (!$resCheckGenre) {
            $queryAddGenre = $bdd->prepare("INSERT INTO A_POUR_STYLE(nom_genre,id_sortie) VALUES (?,?)");
            $queryAddGenre->execute([$genre, $sortieCommerciale->getID()]);
        }
        $bdd->commit();
        return $genre;
    }

    static function addArtisteToSortie(Sortie $album, Artiste|Utilisateur $artiste)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $queryArtiste = $bdd->prepare("SELECT nom_artiste FROM CREE WHERE id_sortie = ? AND nom_artiste = ?");
        $queryArtiste->execute([$album->getID(), $artiste->getPseudo()]);
        $resArtiste = $queryArtiste->fetch();
        if (!$resArtiste) {
            $queryAddArtiste = $bdd->prepare("INSERT INTO CREE(id_sortie,nom_artiste) VALUES (?,?)");
            $queryAddArtiste->execute([$album->getID(), $artiste->getPseudo()]);
        }
        $bdd->commit();
    }

    static function addArtisteToTitre(Titre $titre, Artiste $artiste)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $queryArtiste = $bdd->prepare("SELECT nom_artiste FROM CHANTER_PAR WHERE id_titre = ? AND nom_artiste = ?");
        $queryArtiste->execute([$titre->getID(), $artiste->getPseudo()]);
        $resArtiste = $queryArtiste->fetch();
        if (!$resArtiste) {
            $queryAddArtiste = $bdd->prepare("INSERT INTO CHANTER_PAR(id_titre,nom_artiste) VALUES (?,?)");
            $queryAddArtiste->execute([$titre->getID(), $artiste->getPseudo()]);
        }
        $bdd->commit();
    }

    static function getIdSortie(Sortie $sortie): ?int
    {
        $bdd = BD::getInstance();
        $queryIDAlbum = $bdd->prepare("SELECT id_sortie FROM SORTIE WHERE nom_sortie = ? AND date_sortie = ? AND id_type = ?");
        $queryIDAlbum->execute([$sortie->getNom(), $sortie->getDate(), $sortie->getType()]);
        $idAlbum = $queryIDAlbum->fetch();
        if ($idAlbum == null) {
            return null;
        }
        return $idAlbum['id_sortie'];
    }

    static function getIdTitre(Titre $titre): ?int
    {
        $bdd = BD::getInstance();
        $queryIDTitre = $bdd->prepare("SELECT id_titre FROM TITRE WHERE nom_titre = ? AND duree = ?");
        $queryIDTitre->execute([$titre->getTitre(), $titre->getDuree()]);
        $idTitre = $queryIDTitre->fetch();
        if ($idTitre == null) {
            return null;
        }
        return $idTitre['id_titre'];
    }

    static function getAllAlbums()
    {
        $queryAlbums = BD::getInstance()->prepare("SELECT id_sortie FROM SORTIE WHERE id_type = 1 AND visibilite = 1");
        $queryAlbums->execute();
        $albums = $queryAlbums->fetchAll();
        $res = [];
        foreach ($albums as $album) {
            $res[] = self::getSortie($album['id_sortie']);
        }
        return $res;
    }

    static function getAllSingles()
    {
        $querySingles = BD::getInstance()->prepare("SELECT id_sortie FROM SORTIE WHERE id_type = 2 AND visibilite = 1");
        $querySingles->execute();
        $singles = $querySingles->fetchAll();
        $res = [];
        foreach ($singles as $single) {
            $res[] = self::getSortie($single['id_sortie']);
        }
        return $res;
    }

    static function getAllEPs()
    {
        $queryEPs = BD::getInstance()->prepare("SELECT id_sortie FROM SORTIE WHERE id_type = 3 AND visibilite = 1");
        $queryEPs->execute();
        $eps = $queryEPs->fetchAll();
        $res = [];
        foreach ($eps as $ep) {
            $res[] = self::getSortie($ep['id_sortie']);
        }
        return $res;
    }

    static function getAllArtistes()
    {
        $bdd = BD::getInstance();
        $queryArtistes = $bdd->prepare("SELECT DISTINCT pseudo FROM UTILISATEUR");
        $queryArtistes->execute();
        $artistes = $queryArtistes->fetchAll();
        $res = [];
        foreach ($artistes as $artiste) {
            $res[] = self::estArtiste($artiste['pseudo']) ? self::getArtiste($artiste['pseudo']) : self::getUtilisateur($artiste['pseudo']);
        }
        return $res;
    }

    static function rechercheArtiste(string $id)
    {
        $queryArtiste = BD::getInstance()->prepare("SELECT * FROM ARTISTE WHERE nom_artiste LIKE ?");
        $queryArtiste->execute([$id . "%"]);
        $artistes = $queryArtiste->fetchAll();
        $res = [];
        foreach ($artistes as $artiste) {
            $res[] = new Artiste($artiste['nom_artiste'], boolval($artiste['verifie']));
        }
        return $res;
    }

    static function getRecommandations(Sortie $sortie): array
    {
        $genres = self::getGenresSortie($sortie->getID());
        $queryRecos = BD::getInstance()->prepare("SELECT s.*, COUNT(DISTINCT g.nom_genre) AS communs
        FROM SORTIE s
        JOIN A_POUR_STYLE aps ON s.id_sortie = aps.id_sortie
        JOIN GENRE g ON aps.nom_genre = g.nom_genre
        WHERE g.nom_genre IN (" . implode(',', array_fill(0, count($genres), '?')) . ")
        AND s.id_sortie != ? AND s.visibilite = 1
        GROUP BY s.id_sortie
        ORDER BY communs DESC, RANDOM()
        LIMIT 5;
        ");
        $queryRecos->execute(array_merge($genres, [$sortie->getID()]));
        $recos = $queryRecos->fetchAll();
        $res = [];
        foreach ($recos as $reco) {
            $res[] = self::getSortie($reco['id_sortie']);
        }
        return $res;
    }
    static function verifie_utilisateur(string $pseudo, string $mdp): bool
    {
        $bdd = BD::getInstance();
        $connexion = $bdd->prepare('SELECT * FROM UTILISATEUR WHERE pseudo = ?');
        $connexion->execute([$pseudo]);
        $login = $connexion->fetch();
        if ($login == null || $login['mdp'] != hash('sha256', $mdp)) {
            return false;
        }
        return true;

    }

    static function noteSortie(string $pseudo, Sortie $sortie, ?int $note = null, ?bool $like = null)
    {
        if (is_null($note) && is_null($like)) {
            return;
        }
        if ($sortie instanceof SortieCommerciale) {
            //faire qq chose
        }

        $noteActuelle = self::getNote($pseudo, $sortie);
        $likeActuelle = self::getLike($pseudo, $sortie);
        $newNote = is_null($note) ? $noteActuelle : $note;
        $newLike = is_null($like) ? $likeActuelle : $like;

        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $querryInsert = $bdd->prepare('INSERT OR REPLACE INTO AVIS(id_sortie,pseudo,note,favori) VALUES(?,?,?,?)');
        $querryInsert->execute([$sortie->getID(),$pseudo, $newNote, $newLike]);
        $bdd->commit();
    }
    static function getLike(string $pseudo, Sortie $sortie): bool
    {
        $bdd = BD::getInstance();
        $queryEstLike = $bdd->prepare('SELECT favori FROM AVIS WHERE pseudo = ? AND id_sortie = ?');
        $queryEstLike->execute([$pseudo, $sortie->getID()]);
        $like = $queryEstLike->fetch();
        if ($like) {
            return boolval($like['favori']);
        }
        return false;
    }
    static function getNote(string $pseudo, SortieCommerciale $sortie): ?int
    {
        $bdd = BD::getInstance();
        $queryNote = $bdd->prepare('SELECT note FROM AVIS WHERE pseudo = ? AND id_sortie = ?');
        $queryNote->execute([$pseudo, $sortie->getID()]);
        $note = $queryNote->fetch();
        if ($note) {
            return $note['note'];
        }
        return null;
    }

    static function getMoyenneNote(SortieCommerciale $sortie): ?float
    {
        $bdd = BD::getInstance();
        $queryMoyenne = $bdd->prepare('SELECT AVG(note) FROM AVIS WHERE id_sortie = ?');
        $queryMoyenne->execute([$sortie->getID()]);
        $moyenne = $queryMoyenne->fetch();
        if ($moyenne) {
            return $moyenne[0];
        }
        return null;
    }

    static function getPositionTitre(Titre $titre, Sortie $sortie)
    {
        $bdd = BD::getInstance();
        $queryPosition = $bdd->prepare('SELECT position FROM CONTIENT WHERE id_sortie = ? AND id_titre = ?');
        $queryPosition->execute([$sortie->getID(), $titre->getID()]);
        $position = $queryPosition->fetch();
        if ($position) {
            return $position[0];
        }
        return null;
    }

    static function setVerifie(Artiste $artiste, bool $verifie)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $queryVerifie = $bdd->prepare('UPDATE ARTISTE SET verifie = ? WHERE nom_artiste = ?');
        $queryVerifie->execute([$verifie, $artiste->getPseudo()]);
        $bdd->commit();
    }

    static function modifierUtilisateur(string $pseudo, string $nom, string $prenom, ?string $mdp)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $queryModif = $bdd->prepare('UPDATE UTILISATEUR SET nom = ?, prenom = ? WHERE pseudo = ?');
        $queryModif->execute([$nom, $prenom, $pseudo]);
        if (!is_null($mdp)) {
            $queryModifMdp = $bdd->prepare('UPDATE UTILISATEUR SET mdp = ? WHERE pseudo = ?');
            $queryModifMdp->execute([hash('sha256', $mdp), $pseudo]);
        }
        $bdd->commit();
    }

    static function supprimerArtiste(string $pseudo)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $sorties = BD::getSortiesCommercialBy(BD::getArtiste($pseudo));
        $querySuppr = $bdd->prepare('DELETE FROM UTILISATEUR WHERE pseudo = ?');
        $querySuppr->execute([$pseudo]);
        $bdd->commit();
        foreach ($sorties as $sortie) {
            BD::supprimerSortie($sortie->getID());
        }
    }

    static function supprimerSortie(int $id)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $querySuppr = $bdd->prepare('DELETE FROM SORTIE WHERE id_sortie = ?');
        $querySuppr->execute([$id]);
        $bdd->commit();
    }

    static function supprimerTitreSortie(Titre $titre, Sortie $sortie)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $querySuppr = $bdd->prepare('DELETE FROM CONTIENT WHERE id_sortie = ? AND id_titre = ?');
        $querySuppr->execute([$sortie->getID(), $titre->getID()]);
        $bdd->commit();
    }
}