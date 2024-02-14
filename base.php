<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;

if(!isset($_SESSION)){
    session_start();
}
?>

<link rel="stylesheet" href="css/base.css">
<aside>
    <nav>
        <ul>
            <?php if (isset($_SESSION['pseudo'])): ?>
                <li>
                    <?php
                    $user = BD::getUtilisateur($_SESSION['pseudo']);
                    if (!is_null($user)) {
                        echo $user->renderMini();
                    }
                    ?>
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
            <?php if (!isset($_SESSION['pseudo'])): ?>
                <li>
                    <a href="login.php">
                        <object type="image/svg+xml" data="data/images/connexion.svg"></object>
                        <span>Connexion</span>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="formMusic.php">
                        <object type="image/svg+xml" data="data/images/upload.svg"></object>
                        <span>Ajouter une musique</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <object type="image/svg+xml" data="data/images/connexion.svg"></object>
                        <span>Deconnexion</span>
                    </a>
                </li>
                <li>
                <a href="creerPlaylist.php">
                    <object type="image/svg+xml" data="data/images/loupe.svg"></object>
                    <span>creer Playlist</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
        
    </nav>
</aside>