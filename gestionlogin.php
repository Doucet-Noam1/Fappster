<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\Utilisateur;
use onzeur\Type\BD;
session_start();
var_dump($_SESSION['bdd']);
if ($_POST) {
    
$nom_utilisateur = $_POST['nom_utilisateur'];
$password = $_POST['password'];
if ($_POST['signup'] == 'false'){
if (BD::verifie_utilisateur($nom_utilisateur, $password)) {
$_SESSION['username'] = $nom_utilisateur; 
exit();
} else {
echo "Nom d'utilisateur ou mot de passe incorrect.";
}
}
else{
$artiste = new Utilisateur($nom_utilisateur, $password);
$_SESSION['artiste'] = $artiste;
$_SESSION['username'] = $nom_utilisateur;
header('Location: index.php');
}
}
?>