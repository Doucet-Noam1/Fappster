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
            self::$bdd -> exec('CREATE TABLE IF NOT EXISTS ARTISTE(
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
                nom TEXT,
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
            id_genre INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT
        )');


            self::$bdd->exec('CREATE TABLE IF NOT EXISTS A_POUR_STYLE(
            id_genre INTEGER PRIMARY KEY AUTOINCREMENT,
            libelle_genre TEXT
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

            self::$bdd-> exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Album")');
            self::$bdd-> exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Single")');
            self::$bdd-> exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("EP")');
            self::$bdd-> exec('INSERT INTO TYPE_SORTIE(libelle) VALUES ("Playlist")');
            var_dump(self::$bdd);



        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    static function getInstance()
    {
        if (!(file_exists('fappster.db'))){
            echo 'creation';
            new BD;
        }
        return loadbd();
    }

    static function getArtiste($id){
        $queryArtiste = BD::getInstance()->prepare("SELECT * FROM ARTISTE WHERE nom_artiste = ?");
        $queryArtiste->execute([$id]);
        $artiste = $queryArtiste->fetch();
        return new Artiste($artiste['nom_artiste'],$artiste['verifie']);
    }

    static function getAlbum($id){
        
        $queryAlbum = BD::getInstance()->prepare("SELECT * FROM SORTIE NATURAL JOIN CREE WHERE id_sortie = ? AND id_type = 1");
        $queryAlbum->execute([$id]);
        $album = $queryAlbum->fetch();
        return new Album(self::getArtiste($album['nom_artiste']),$album['nom'],[],strval($album['date_sortie']),$album['cover'],);
    }

    static function getSortiesBy(Artiste $artiste){
        $querySorties = BD::getInstance()->prepare("SELECT * FROM SORTIE NATURAL JOIN CREE WHERE nom_artiste = ?");
        $querySorties->execute([$artiste->getPseudo()]);
        $sorties = $querySorties->fetchAll();
        $res = [];
        foreach($sorties as $sortie){
            $res[] = new Album($artiste,$sortie['nom'],[],strval($sortie['date_sortie']),$sortie['cover']);
        }
        return $res;
    }
    
    static function getSortie($artiste,string $nom, $liste, string $date, string|null $cover,int $id_type){
        switch($id_type){
            case 1:
                return new Album($artiste, $nom, $liste, $date,  $cover);
            case 2:
                return new Single($artiste, $nom, $liste, $date,  $cover);
            case 3:
                return new EP($artiste, $nom, $liste, $date,  $cover, $id_type);
            case 4:
                return new Playlist($artiste, $nom, $liste, $date,  $cover, $id_type);
        }
    }
}
?>