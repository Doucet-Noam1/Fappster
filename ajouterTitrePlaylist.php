<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;
session_start();
if (!isset($_SESSION['pseudo'])){
    header('Location: login.php');
    exit();
}

if (isset($_POST)){
    $id_playlist = $_POST['id_playlist'];
    $id_sortie = $_POST['id_sortie'];
    $playlist = BD::getSortie($id_playlist);
    $sortie = BD::getSortie($id_sortie);
    $id_titre = $_POST['id_titre'];
    $titre = BD::getTitre($id_titre, $sortie->getID());
    BD::addTitreToSortie($playlist, $titre,$sortie);
    header('Location: sortie.php?id='.$_POST['id_redirection']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="index.php"> aa </a>
</body>
</html>