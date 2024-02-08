<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\Utilisateur;
use onzeur\Type\BD;
session_start();
var_dump($_SESSION['bdd']);
if ($_POST) {
    
$pseudo = $_POST['pseudo'];
$password = $_POST['password'];
if ($_POST['signup'] == 'false'){
if (BD::verifie_utilisateur($pseudo, $password)) {
$_SESSION['username'] = $pseudo; 
exit();
} else {
echo "Nom d'utilisateur ou mot de passe incorrect.";
}
}
else{
$artiste = new Utilisateur($pseudo, $password);
$_SESSION['artiste'] = $artiste;
$_SESSION['username'] = $pseudo;
header('Location: index.php');
}
}
?>