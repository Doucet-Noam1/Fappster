# SAE_PHP

**Noam DOUCET** *amassu*  
**Cyprien FOURNIER** *irpyc*  
**Titouan COULON** *livreur*  

## Project et fonctionalitées : 

### 1 - Présentation du projet
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


## Présentation de Fappster
  Fappster est un site dédiée à la découverte et à la gestion musicale en ligne. Conçue pour les amateurs de musique, cette application offre une expérience exceptionnel et intuitive pour explorer de nouveaux albums, singles et EPs, ainsi que pour ajouter et organiser votre propre collection musicale.
Fappster vise à offrir une expérience musicale personnalisée et engageante, en permettant aux utilisateurs d'explorer de nouveaux titres, de créer leur propre collection musicale, et de partager leurs passions avec d'autres passionnés de musique.

Explorez et profitez de Fappster pour une expérience musicale enrichissante et personnalisée !


## Utilisation de Fappster :

### 1 - Connexion :
Dans un premier temps, l'utilisateur a la possibilité de se connecter en remplissant les champs textuels sur la partie gauche de l'écran s'il possède déjà un compte. Dans le cas contraire, il peut en créer un en remplissant le formulaire sur la partie droite. Il devra renseigner : son nom, son prénom, une photo de profil (facultatif), un pseudonyme ainsi que son mot de passe de connexion.

### 2 - Accueil :
Sur la page d'accueil, nous pouvons retrouver toutes les sorties musicales de tous les artistes (Albums, EPs, Singles).

### 3 - Détail d'une sortie musicale :
En cliquant sur une sortie musicale, nous accédons aux détails de la sortie. En cliquant sur le cœur en haut à droite de la page, la sortie est ajoutée à notre liste de sorties likées. Il est également possible de noter la proposition musicale en cliquant sur les étoiles. Enfin, plusieurs recommandations peuvent être faites en fonction des types de musique contenus dans la sortie musicale.

### 4 - Ajouter une musique :
Dans ce formulaire, nous avons la possibilité d'ajouter une musique à notre bibliothèque. Pour cela, il faudra renseigner : le titre, la piste audio, les artistes présents sur la musique (s'il y en a) et valider le formulaire.

### 5 - Créer une sortie musicale :
Dans ce formulaire, nous avons la possibilité de créer une sortie musicale dans notre bibliothèque. Pour cela, il faudra renseigner : le type de sortie, le nom de la sortie, une couverture (optionnelle), des co-artistes (s'il y en a), la date de sortie du projet, tous les titres qui devront être dans la sortie, et enfin choisir un ou plusieurs genres, puis valider le formulaire.

### 6 - Déconnexion :
Pour finir, afin de se déconnecter, il suffit simplement de cliquer sur "déconnexion".

