<?php
declare(strict_types=1);

namespace onzeur\Type;

include 'loadbd.php';

class BD
{
    private static $bdd;
    private function __construct()
    {
        try {
            if (file_exists('fappster.db')) {
                unlink('fappster.db');
            }

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
                FOREIGN KEY(nom_artiste) REFERENCES Utilisateur(pseudo)
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
                FOREIGN KEY(id_type) REFERENCES TYPE_SORTIE(id_type)
            )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS AVIS (
                id_sortie INTEGER,
                pseudo INTEGER,
                notes INTEGER,
                likes BOOLEAN default false,
                FOREIGN KEY(id_sortie) REFERENCES ARTISTE(id_sortie),
                FOREIGN KEY(pseudo) REFERENCES SORTIE(id_groupe),
                PRIMARY KEY(id_sortie,pseudo)
            )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS CREE (
            id_sortie INTEGER,
            nom_artiste VARCHAR(30),
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie),
            FOREIGN KEY(nom_artiste) REFERENCES ARTISTE(nom_artiste),
            PRIMARY KEY(id_sortie,nom_artiste)
        )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS PRODUIT (
            id_sortie INTEGER,
            nom_artiste VARCHAR(30),
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie),
            FOREIGN KEY(nom_artiste) REFERENCES ARTISTE(nom_artiste),
            PRIMARY KEY(id_sortie,nom_artiste)
        )');


            self::$bdd->exec('CREATE TABLE IF NOT EXISTS GENRE(
            nom_genre TEXT PRIMARY KEY
        )');


            self::$bdd->exec('CREATE TABLE IF NOT EXISTS A_POUR_STYLE(
            nom_genre TEXT,
            id_sortie INTEGER,
            FOREIGN KEY(nom_genre) REFERENCES GENRE(nom_genre),
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie),
            PRIMARY KEY(nom_genre,id_sortie)
        )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS TITRE(
            id_titre INTEGER PRIMARY KEY AUTOINCREMENT,
            titre TEXT,
            duree INTEGER
        )');
            self::$bdd->exec('CREATE TABLE IF NOT EXISTS CONTIENT (
            id_sortie INTEGER,
            id_titre INTEGER,
            position INTEGER,
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie),
            FOREIGN KEY(id_titre) REFERENCES TITRE(id_titre),
            PRIMARY KEY(id_sortie,id_titre)
        )');
            self::$bdd->exec('CREATE TABLE IF NOT EXISTS CHANTER_PAR(
            nom_artiste VARCHAR(30),
            id_titre INTEGER ,
            FOREIGN KEY(nom_artiste) REFERENCES ARTISTE(nom_artiste),
            FOREIGN KEY(id_titre) REFERENCES TITRE(id_titre),
            PRIMARY KEY(nom_artiste,id_titre)
        )');

            self::$bdd->exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Album")');
            self::$bdd->exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Single")');
            self::$bdd->exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("EP")');
            self::$bdd->exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Playlist")');
            var_dump(self::$bdd);



        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    static function getInstance()
    {
        if (!(file_exists('fappster.db'))) {
            echo 'creation';
            new BD;
        }
        return loadbd();
    }

    static function addArtiste(Artiste $artiste)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        $queryArtiste = $bdd->prepare("SELECT nom_artiste FROM ARTISTE WHERE nom_artiste = ?");
        $queryArtiste->execute([$artiste->getPseudo()]);
        $resArtiste = $queryArtiste->fetch();
        if (!$resArtiste) {
            $queryAddArtiste = $bdd->prepare("INSERT INTO ARTISTE(nom_artiste,verifie) VALUES (?,?)");
            $queryAddArtiste->execute([$artiste->getPseudo(), $artiste->getVerifie()]);
        }
        $bdd->commit();
    }

    static function addSortie(Sortie $sortie)
    {
        $bdd = BD::getInstance();
        $bdd->beginTransaction();
        if (BD::getIdSortie($sortie) == null) {
            $queryAddAlbum = $bdd->prepare("INSERT INTO SORTIE(nom_sortie,date_sortie,cover,id_type) VALUES (?,?,?,?)");
            $queryAddAlbum->execute([$sortie->getNom(), $sortie->getDate(), $sortie->getCover(), $sortie->getType()]);
            $bdd->commit();
        }
        foreach ($sortie->getArtiste() as $artiste) {
            BD::addArtisteToSortie($sortie, $artiste);
        }
        foreach ($sortie->getListeTitres() as $titre) {
            BD::addTitreToSortie($sortie, $titre);
        }

    }

    static function addTitreToSortie(Sortie $sortie, Titre $titre)
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
        $queryAddTitre = $bdd->prepare("INSERT INTO CONTIENT(id_sortie,id_titre,position) VALUES (?,?,?)");
        $queryAddTitre->execute([$sortie->getID(), $titre->getID(), $titre->getPosition()]);
        $bdd->commit();
    }

    static function getArtiste($nom)
    {
        $queryArtiste = BD::getInstance()->prepare("SELECT * FROM ARTISTE WHERE nom_artiste = ?");
        $queryArtiste->execute([$nom]);
        $artiste = $queryArtiste->fetch();
        return new Artiste($artiste['nom_artiste'], $artiste['verifie']);
    }

    static function getGenresSortie($idSortie)
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

    static function getArtisteSortie($idSortie)
    {
        $queryArtiste = BD::getInstance()->prepare("SELECT nom_artiste FROM CREE WHERE id_sortie = ?");
        $queryArtiste->execute([$idSortie]);
        $artiste = $queryArtiste->fetch();
        return self::getArtiste($artiste['nom_artiste']);
    }

    static function getSortie($id): Sortie|null
    {
        $querySortie = BD::getInstance()->prepare("SELECT * FROM SORTIE WHERE id_sortie = ?");
        $querySortie->execute([$id]);
        $sortie = $querySortie->fetch();
        if ($sortie == null) {
            return null;
        }
        $artiste = self::getArtisteSortie($id);
        $genres = self::getGenresSortie($id);
        return Sortie::factory($artiste, $sortie["nom_sortie"], [], strval($sortie["date_sortie"]), $sortie["cover"], $sortie["id_type"], $genres, intval($id));
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

    static function addArtisteToSortie(Sortie $album, Artiste $artiste)
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

    static function getIdSortie(Sortie $sortie): int|null
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

    static function getIdTitre(Titre $titre){
        $bdd = BD::getInstance();
        $queryIDTitre = $bdd->prepare("SELECT id_titre FROM TITRE WHERE titre = ? AND duree = ?");
        $queryIDTitre->execute([$titre->getTitre(),$titre->getDuree()]);
        $idTitre = $queryIDTitre->fetch();
        if ($idTitre == null){
            return null;
        }
        return $idTitre['id_titre'];
    }

    static function getAllAlbums()
    {
        $queryAlbums = BD::getInstance()->prepare("SELECT id_sortie FROM SORTIE WHERE id_type = 1");
        $queryAlbums->execute();
        $albums = $queryAlbums->fetchAll();
        $res = [];
        foreach ($albums as $album) {
            $res[] = self::getSortie($album['id_sortie']);
        }
        return $res;
    }
}
?>