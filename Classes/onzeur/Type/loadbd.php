<?php

declare(strict_types=1);
namespace onzeur\Type;

function loadbd()
{
    $bdd = new \PDO('sqlite:fappster.db');
    $bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $bdd->exec('PRAGMA foreign_keys = ON;');
    return $bdd;
}
function peupleBD()
{
    $reader = new Reader("extrait.yml");
    $reader->getData();
    $artiste = new Artiste('naps', true);
    $artiste2 = new Artiste('gazo', true);
    $artiste3 = new Artiste('Rohff', false);
    $utilisateur = new Utilisateur('admin', 'adminnom', 'adminprenom', 'admin');

    $album2 = new Album($artiste3, 'albumderohffavecgazo', [], '2024', 'aaa.png', ['Rap']);
    $album2->addArtiste($artiste2);
    $musique = new Titre('la mala est gangx', $artiste, 120, '13-02-2005', '506c748dca4d22f81168b433b76ad515b6980483.mp3');
    $musique2 = new Titre('la mala est gangxxxxxxxx', $artiste, 120, '13-02-2005', '506c748dca4d22f81168b433b76ad515b6980483.mp3');
    $ep = new EP($artiste, 'test', [$musique, $musique2], '2024', 'aaa.png', ['Rap']);
    $album = new Album($artiste, 'test', [$musique, $musique2], '2024', 'aaa.png', ['Rap']);
    $album->addArtiste($artiste);
    $musique2->addArtiste($artiste2);

}
function deletebd()
{
    echo 'creation';
    unlink('fappster.db');
}