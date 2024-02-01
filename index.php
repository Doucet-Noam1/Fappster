<?php
require 'Classes/autoloader.php'; 

Autoloader::register();
use onzeur\Type\Sortie;
use onzeur\Type\BD;
use onzeur\Type\Album;
use onzeur\Type\Musique;
use onzeur\Type\Reader;

$reader = new Reader("extrait.yml");
foreach ($reader->getAlbums() as $key => $value) {
    $value->render();
}

$bdd = BD::getInstance();
$musique = new Musique('la mala est gangx','caca',120,'13-02-2005');
$musique2 = new Musique('la mala est gangxxxxxxxx','caca',120,'13-02-2005');
$album = new Album('test',[$musique,$musique2],'2024','aaa.png');
$musique->setAlbum($album);
$musique2->setAlbum($album);

$album->render();

?>
