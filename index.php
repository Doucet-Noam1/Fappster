<?php
require 'Classes/autoloader.php';

Autoloader::register();
use onzeur\Type\Sortie;
use onzeur\Type\BD;
use onzeur\Type\Album;
use onzeur\Type\Musique;
use onzeur\Type\Reader;
use onzeur\Type\Artiste;
use onzeur\Type\EP;
$reader = new Reader("extrait.yml");

$bdd = BD::getInstance();
$artiste = new Artiste('naps','test');
$artiste2 = new Artiste('gazo','test');

$musique = new Musique('la mala est gangx', $artiste, 120, '13-02-2005','/data/audios/MICHOU - M2LT (Clip Officiel).mp3');
$musique2 = new Musique('la mala est gangxxxxxxxx', $artiste, 120, '13-02-2005','/data/audios/MICHOU - M2LT (Clip Officiel).mp3');
$ep = new EP($artiste,'test', [$musique, $musique2], '2024', 'aaa.png');
$album = new Album($artiste,'test', [$musique, $musique2], '2024', 'aaa.png');
$album -> addArtiste($artiste);
$musique->setAlbum($album);
$musique2->setAlbum($album);
$musique2 -> addArtiste($artiste2);


?>
<html>

<head>
    <title>Onzeur</title>
    <link rel="stylesheet" href="Css/index.css">
</head>

<body>
    <h1>Onzeur</h1>
    <div id="albums">
        <?php
        foreach ($reader->getData() as $key => $value) {
            $value->render();
        }
        $album->render();
        $ep -> render();
        ?>
    </div>
</body>

</html>