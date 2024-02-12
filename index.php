<?php
session_start();
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\Sortie;
use onzeur\Type\BD;
use onzeur\Type\Album;
use onzeur\Type\Titre;
use onzeur\Type\Reader;
use onzeur\Type\Artiste;
use onzeur\Type\EP;

// if (!isset($_SESSION['bdd'])) {
//     $_SESSION['bdd'] = BD::getInstance();;
// }
$reader = new Reader("extrait.yml");
$reader->getData();
$artiste = new Artiste('naps', 'test');
$artiste2 = new Artiste('gazo', 'test');
$artiste3 = new Artiste('Rohff');

$album2 = new Album($artiste3, 'albumderohffavecgazo', [], '2024', 'aaa.png', ['Rap']);
$album2->addArtiste($artiste2);
$musique = new Titre('la mala est gangx', $artiste, 120, '13-02-2005', '/data/audios/MICHOU - M2LT (Clip Officiel).mp3');
$musique2 = new Titre('la mala est gangxxxxxxxx', $artiste, 120, '13-02-2005', '/data/audios/MICHOU - M2LT (Clip Officiel).mp3');
$ep = new EP($artiste, 'test', [$musique, $musique2], '2024', 'aaa.png', ['Rap']);
$album = new Album($artiste, 'test', [$musique, $musique2], '2024', 'aaa.png', ['Rap']);
$album->addArtiste($artiste);
$musique2->addArtiste($artiste2);
$pseudo = $_SESSION['pseudo'];

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