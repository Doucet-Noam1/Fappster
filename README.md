# SAE_PHP

**Noam DOUCET**  
**Cyprien FOURNIER**    
**Titouan COULON**  

## 1 - Présentation 

A partir des données que vous trouverez dans le fichier fixtures.zip dans Celene, il vous est demandé de  
réaliser une application présentant le contenu de cette base d'albums de musique. Le fichier fixtures.zip  
contient quelques albums et artistes avec des pochettes d'albums.

### Installation
Après avoir cloné le git, rendez vous dans le dossier et réalisez ces 2 commandes:
<code>composer install</code>
<code>php -S localhost:8080</code>
Le serveur php sera lancé sur l'adresse localhost:8080.
Le premier chargement de l'application est un peu plus long que les autres pour créer la BD.

## 2 - Fonctionnalités attendues

- [x] 2.1 Affichage des albums
- [x] 2.2 Détail des albums
- [x] 2.3 Détail d’un artiste avec ses albums
- [x] 2.4 Recherche avancée dans les albums (par artiste, par genre, par année, etc.)

## 3 - Fonctionnalités souhaitées
- [x] 3.1 CRUD<sup>1</sup> pour un album
- [x] 3.2 CRUD pour un artiste

<sup>1</sup> *CRUD* : Create, Read, Update, Delete

## 4 - Fonctionnalités possibles

- [x] 4.1 Inscription/Login Utilisateur
- [x] 4.2 Playlist par utilisateur
- [x] 4.3 Système de notation des albums

## 5 - Contraintes

- [x] 5.1 Organisation du code dans une arborescence cohérente
- [x] 5.2 Utilisation des namespaces
- [x] 5.3 Utilisation d’un provider pour charger le fichier YAML
- [x] 5.4 Utilisation d'un autoloader pour charger les classes d’objets nécessaires
- [x] 5.5 Utilisation de PDO avec base de données sqlite
- [x] 5.6 Utilisation de sessions
- [x] 5.7 Mise en place CSS

## 6 - Documentations

- [x] 6.1 Modèle Conceptuel de Données pour la BDD
- [x] 6.2 Diagramme des classes présentes dans votre code
- [x] 6.3 Diagramme d’activité
- [x] 6.4 Diagramme de séquence
- [x] 6.5 README et requirements

# Présentation de l'application
L'application permet de transférer les informations contenues dans le fichier yaml en php, les images des albums doivent être rangées dans "./data/images/covers".  
On peut ensuite retrouver ces albums sur la page d'accueil de l'application. Pour chaque album, un artiste défini par son nom (Ex: Ryan Adams), avec sa page associée "profil.php?id=Ryan Adams" où 
sont répertoriés ses sorties, ses titres et ses playlists. Un artiste peut se connecter grâce à la barre de navigation sur le coté, par défaut, seul l'administrateur du site à un compte (id=admin,mdp=admin).
Un utilisateur connecté peut uploader des titres qui pourront constituer une sortie (Album, EP, Single), il pourra également créer des playlists, contenant des sons de différentes sorties.
L'administrateur peut quand à lui accéder au module administrateur à l'adresse vueAdmin.php et pourra modifier ou supprimer des artistes et tout ce qui leur est associé.
