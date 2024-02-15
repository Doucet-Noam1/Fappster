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
    $utilisateur = BD::getUtilisateur($_SESSION['pseudo']);
    $id_sortie = $_POST['id_sortie'];
    $sortie = BD::getSortie($id_sortie);
    $id_titre = $_POST['id_titre'];
    $titre = BD::getTitre($id_titre, $sortie->getID());
    $utilisateur->like($titre,$sortie);
    header('Location: sortie.php?id='.$_POST['id_redirection']);
    exit();
}