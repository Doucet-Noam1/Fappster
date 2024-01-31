<?php
declare(strict_types=1);

namespace onzeur\Type;
include 'create_bd.php';

class BD{
    private static $instance = null;
    private static $bdd;
    private function __construct(){
        try {
            if (file_exists('onzeur.db')) {
                unlink('onzeur.db');
                echo "Base de données existante supprimée.<br>";
            }
        
          self::$bdd = loadbd();
        
          self::$bdd ->exec('CREATE TABLE IF NOT EXISTS ARTISTE ( 
                id_artiste INTEGER PRIMARY KEY AUTOINCREMENT,
                nom TEXT,
                mdp TEXT default NULL)'
            );
            echo "Artiste Créé <br>";
        
          self::$bdd -> exec('CREATE TABLE IF NOT EXISTS TYPE_SORTIE (
                id_type INTEGER PRIMARY KEY AUTOINCREMENT,
                libelle TEXT
            )');
            echo "TYPE_SORTIE Créé <br>";
        
          self::$bdd->exec('CREATE TABLE IF NOT EXISTS SORTIE (
                id_sortie INTEGER PRIMARY KEY AUTOINCREMENT,
                nom TEXT,
                annee DATETIME,
                cover TEXT,
                id_type INTEGER NOT NULL,
                FOREIGN KEY(id_type) REFERENCES TYPE_SORTIE(id_type)
            )');
        
            echo "SORTIE Créé <br>";
            
          self::$bdd -> exec('CREATE TABLE IF NOT EXISTS PREFERENCES (
                id_sortie INTEGER,
                id_artiste INTEGER,
                notes INTEGER,
                likes BOOLEAN default false,
                FOREIGN KEY(id_sortie) REFERENCES ARTISTE(id_sortie),
                FOREIGN KEY(id_artiste) REFERENCES SORTIE(id_groupe),
                PRIMARY KEY(id_sortie,id_artiste)
            )');
        
            echo "PREFERENCES créé <br>";
        
      self::$bdd -> exec('CREATE TABLE IF NOT EXISTS CREE (
            id_sortie INTEGER,
            id_artiste INTEGER,
            FOREIGN KEY(id_sortie) REFERENCES ARTISTE(id_sortie),
            FOREIGN KEY(id_artiste) REFERENCES SORTIE(id_groupe),
            PRIMARY KEY(id_sortie,id_artiste)
        )');
            echo "Cree cree <br>";
        
      self::$bdd -> exec('CREATE TABLE IF NOT EXISTS PRODUIT (
            id_sortie INTEGER,
            id_artiste INTEGER,
            FOREIGN KEY(id_sortie) REFERENCES ARTISTE(id_sortie),
            FOREIGN KEY(id_artiste) REFERENCES SORTIE(id_groupe),
            PRIMARY KEY(id_sortie,id_artiste)
        )');
        
            echo "produit créé <br>";
        
      self::$bdd -> exec('CREATE TABLE IF NOT EXISTS GENRE(
            id_genre INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT
        )');
        
            echo "genre créé <br>";
        
      self::$bdd -> exec('CREATE TABLE IF NOT EXISTS A_POUR_STYLE(
            id_genre INTEGER PRIMARY KEY AUTOINCREMENT,
            libelle_genre TEXT
        )');
        echo "A_POUR_STYLE créé <br>";
        
      self::$bdd ->exec('CREATE TABLE IF NOT EXISTS TITRE(
            id_titre INTEGER PRIMARY KEY AUTOINCREMENT,
            titre TEXT,
            duree INTEGER
        )');
        echo 'créé Titre';
      self::$bdd->exec('CREATE TABLE IF NOT EXISTS CONTIENT (
            id_sortie INTEGER,
            id_titre INTEGER,
            position INTEGER,
            FOREIGN KEY(id_sortie) REFERENCES SORTIE(id_sortie),
            FOREIGN KEY(id_titre) REFERENCES TITRE(id_titre),
            PRIMARY KEY(id_sortie,id_titre)
        )');
        echo 'Content créé <br>';
      self::$bdd -> exec('CREATE TABLE IF NOT EXISTS CHANTER_PAR(
            id_artiste INTEGER ,
            id_titre INTEGER  ,
            FOREIGN KEY(id_artiste) REFERENCES ARTISTE(id_artiste),
            FOREIGN KEY(id_titre) REFERENCES TITRE(id_titre),
            PRIMARY KEY(id_artiste,id_titre)
        )');
        echo 'CHANTER_PAR créé <br>';
        
         echo "Données insérées avec succès.";
        
        } catch (PDOException $e) {
                die('Erreur : ' . $e->getMessage());
        }
    }
    static function getInstance(){
        if (is_null(self::$instance)){
            print_r("test");
            self::$instance = new BD();
            print_r(gettype(self::$instance) . ' instance <br>');
            print_r(gettype(self::$bdd). ' bd <br>');
            print_r(self::$instance);
            print_r(self::$bdd);

        }
        return self::$bdd;
    }

    
}


    
   




?>