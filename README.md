# SAE_PHP

**Noam DOUCET** *amassu*  
**Cyprien FOURNIER** *irpyc*  
**Titouan COULON** *livreur*  

## Project et fonctionalitées : 

### 1 - Présentation
A partir des données que vous trouverez dans le fichier fixtures.zip dans Celene, il vous est demandé de  
réaliser une application présentant le contenu de cette base d'albums de musique. Le fichier fixtures.zip  
contient quelques albums et artistes avec des pochettes d'albums.
### Installation
composer require symfony/yaml ^6.4
composer require james-heinrich/getid3

### 2 - Fonctionnalités attendues
- [x] 2.1 Affichage des albums
- [x] 2.2 Détail des albums
- [x] 2.3 Détail d’un artiste avec ses albums
- [ ] 2.4 Recherche avancée dans les albums (par artiste, par genre, par année, etc.)

### 3 - Fonctionnalités souhaitées
- [x] 3.1 CRUD<sup>1</sup> pour un album
- [x] 3.2 CRUD pour un artiste

<sup>1</sup> *CRUD* : Create, Read, Update, Delete

### 4 - Fonctionnalités possibles
- [x] 4.1 Inscription/Login Utilisateur
- [x] 4.2 Playlist par utilisateur
- [x] 4.3 Système de notation des albums

### 5 - Contraintes
- [x] 5.1 Organisation du code dans une arborescence cohérente
- [x] 5.2 Utilisation des namespaces
- [x] 5.3 Utilisation d’un provider pour charger le fichier YAML
- [x] 5.4 Utilisation d'un autoloader pour charger les classes d’objets nécessaires
- [x] 5.5 Utilisation de PDO avec base de données sqlite
- [x] 5.6 Utilisation de sessions
- [x] 5.7 Mise en place CSS

### 6 - Documentations
- [x] 6.1 Modèle Conceptuel de Données pour la BDD
- [ ] 6.2 Diagramme des classes présentes dans votre code
- [ ] 6.3 Diagramme d’activité
- [ ] 6.4 Diagramme de séquence
- [ ] 6.5 README et requirements



## Utilisation de Fappster :

### 1 - Connexion :
  Dans un premier temps, il y a la possibilité de se connecter en ramplissant les champs textuels sur la partie gauche de l'écran si l'utilisateur possède déja un compte. Dans le cas contraire, il peut s'en créer un en ramplissant le formulaire sur la partie droite, il devra renseigner : son nom, son prénom, une photo de profil (facultatif), un pseudonyme ainsi que son mot de passe de connexion.

### 2 - Acceuil : 
  Sur la page d'acceuil nous pouvons retrouver, toute les sorties musical de tous les artistes (Albums, EPs, Single).

### 3 - Détail d'un sortie musical :
  En cliquant sur une sortie musical, nous accèdons au détail de la sortie, en cliquant sur le coeur en haut à droite de la page, la sortie s'ajoute à notre liste de sorties liké, il y a aussi possibilité de noter la proposition musical en cliquant sur les étoiles.
  Enfin plusieurs recommandations peuvent être faite en fonction des types de musique contenue dans la sortie musical.

### 4 - Ajouter une musique :
  Dans ce formulaire, nous avons la possibilité d'ajouter une musique à notre bibliothèque, pour cela il faudra renseigner  : le titre, la piste audio, les artistes présents sur la musiique (si il y en a) et valider le formulaire.

### 5 - Créer une sortie musical : 
  Dans ce formulaire, nous avons la possibilité créer une sortie musical dans notre bibliothèque, pour cela il faudra renseigner  : le type de sortie, le nom de la sortie, un cover (optionnel), des co-artistes (si il y en a), la date de sortie du projet, tout les titres qui devrons être dans la sortie et enfin choisir un ou plusieurs genres puis valider le formulaire.

### 6 - Déconnexion : 
  Pour finir, afin de se déconnecter, il suffit simplement cliquer sur déconnexion.
