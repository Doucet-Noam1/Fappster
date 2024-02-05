<?php
declare(strict_types=1);

namespace onzeur\Type;

include 'create_bd.php';

class BD
{
    private static $instance = null;
    private static $bdd;
    private function __construct()
    {
        try {
            if (file_exists('onzeur.db')) {
                unlink('onzeur.db');
            }

            self::$bdd = loadbd();

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS ARTISTE ( 
                id_artiste INTEGER PRIMARY KEY AUTOINCREMENT,
                nom TEXT,
                mdp TEXT default NULL
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

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS PREFERENCES (
                id_sortie INTEGER,
                id_artiste INTEGER,
                notes INTEGER,
                likes BOOLEAN default false,
                FOREIGN KEY(id_sortie) REFERENCES ARTISTE(id_sortie),
                FOREIGN KEY(id_artiste) REFERENCES SORTIE(id_groupe),
                PRIMARY KEY(id_sortie,id_artiste)
            )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS CREE (
            id_sortie INTEGER,
            id_artiste INTEGER,
            FOREIGN KEY(id_sortie) REFERENCES ARTISTE(id_sortie),
            FOREIGN KEY(id_artiste) REFERENCES SORTIE(id_groupe),
            PRIMARY KEY(id_sortie,id_artiste)
        )');

            self::$bdd->exec('CREATE TABLE IF NOT EXISTS PRODUIT (
            id_sortie INTEGER,
            id_artiste INTEGER,
            FOREIGN KEY(id_sortie) REFERENCES ARTISTE(id_sortie),
            FOREIGN KEY(id_artiste) REFERENCES SORTIE(id_groupe),
            PRIMARY KEY(id_sortie,id_artiste)
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
            id_artiste INTEGER ,
            id_titre INTEGER  ,
            FOREIGN KEY(id_artiste) REFERENCES ARTISTE(id_artiste),
            FOREIGN KEY(id_titre) REFERENCES TITRE(id_titre),
            PRIMARY KEY(id_artiste,id_titre)
        )');

        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new BD();

        }
        return self::$bdd;
    }


}








?>