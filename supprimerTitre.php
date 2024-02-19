<?php
require 'Classes/autoloader.php';
Autoloader::register();
use fappster\Type\BD;
session_start();
if (!isset($_SESSION['pseudo'])){
    header('Location: login.php');
    exit();
}

if (isset($_POST)){
    $id_sortie = $_POST['id_sortie'];
    $sortie = BD::getSortie($id_sortie);
    $id_titre = $_POST['id_titre'];
    $titre = BD::getTitre($id_titre, $sortie->getID());
    BD::supprimerTitreSortie($titre,$sortie);
    header('Location: sortie.php?id='.$id_sortie);
    exit();
}