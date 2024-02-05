<?php
require 'Classes/autoloader.php';

Autoloader::register();
use onzeur\Type\Sortie;
use onzeur\Type\BD;
use onzeur\Type\Album;
use onzeur\Type\Musique;
use onzeur\Type\Reader;

$reader = new Reader("extrait.yml");

$bdd = BD::getInstance();
$musique = new Musique('la mala est gangx', 'caca', 120, '13-02-2005', '/data/audios/MICHOU - M2LT (Clip Officiel).mp3');
$musique2 = new Musique('la mala est gangxxxxxxxx', 'caca', 120, '13-02-2005','/data/audios/MICHOU - M2LT (Clip Officiel).mp3');
$album = new Album('test', [$musique, $musique2], '2024', 'aaa.png');
$musique->setAlbum($album);
$musique2->setAlbum($album);


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
        ?>
    </div>
</body>

</html>