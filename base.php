<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu de navigation</title>
    <link rel="stylesheet" href="css/base.css">

</head>
<body>
<link rel="stylesheet" href="css/base.css">
<aside>
    <nav>
        <ul>
            <?php if(isset($_SESSION['pseudo'])) : ?>
                <li>
                    <a href="profil.php">
                        <object type="image/svg+xml" data="<?php echo BD::getUtilisateur($_SESSION['pseudo'])->getPseudo(); ?>.jpg" style="width: 50px; height: 50px; border-radius: 50%;"></object>
                        <span><?php echo $_SESSION['pseudo']; ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="/">
                    <object type="image/svg+xml" data="data/images/accueil.svg"></object>
                    <span>Accueil</span>
                </a>
            </li>
            <li>
                <a href="recherche.php">
                    <object type="image/svg+xml" data="data/images/loupe.svg"></object>
                    <span>Rechercher</span>
                </a>
            </li>
            <?php if(!isset($_SESSION['pseudo'])) : ?>
                <li>
                    <a href="login.php">
                        <object type="image/svg+xml" data="data/images/connexion.svg"></object>
                        <span>Connexion</span>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="logout.php">
                        <object type="image/svg+xml" data="data/images/connexion.svg"></object>
                        <span>Deconnexion</span>
                    </a>
                </li>
            <?php endif; ?>
                <?php if(isset($_SESSION['pseudo'])){
                    echo '<li> <p> <span>'.$_SESSION['pseudo'].' </span> </p></li>';
                }?>
        </ul>
    </nav>
</aside>
</body>
</html>