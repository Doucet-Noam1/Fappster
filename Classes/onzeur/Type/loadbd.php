<?php

declare(strict_types=1);
namespace onzeur\Type;
function loadbd(){
    $bdd = new \PDO('sqlite:fappster.db');
    $bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $bdd;
}
function peupleBD(){
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

}
function deletebd(){
    echo 'creation';
    unlink('fappster.db');
}