<?php
session_start();
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;

if (isset($_SESSION['pseudo'])){
    $pseudo = $_SESSION['pseudo'];
}
?>
<html>

<head>
    <title>Onzeur</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="data/images/logo.png">
</head>

<body>
    <?php
    require 'base.php';
    ?>
    <div id="contenu">
        <select>
            <?php
           
            echo '<option value="all">Tous</option>';
            foreach (BD::getAllGenres() as $value) {
                $genre = $value;
                echo '<option value="' . $genre . '">' . $genre . '</option>';
            }
            ?>
        </select>
        <div id="albums">
            <h1>Albums</h1>
            <?php
            foreach (BD::getAllAlbums() as $album) {
                $album->render();
            }
            ?>
        </div>
        <div id="eps">
            <h1>EPs</h1>
            <?php
            foreach (BD::getAllEPs() as $ep) {
                $ep->render();
            }
            ?>
        </div>
</body>

</html>