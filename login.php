<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\Utilisateur;
use onzeur\Type\BD;
session_start();
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion</title>
</head>
<body>
<h2>Connexion/Inscription</h2>
<form method="post" action="login.php">
<label for="nom_utilisateur">Nom d'utilisateur:</label>
<input type="text" name="nom_utilisateur" required><br>
<input type = "Hidden" name= "signup" value="false">

<label for="password">Mot de passe:</label>
<input type="password" name="password" required><br>

<button type="submit">Se connecter</button>
</form>
<form method="post" action="login.php">
<label for="nom_utilisateur">Nom d'utilisateur:</label>
<input type="text" name="nom_utilisateur" required><br>

<label for="password">Mot de passe:</label>
<input type="password" name="password" required><br>
<input type = "Hidden" name= "signup" value="true">
<button type="submit">S'inscrire</button>
</form>
</body>
</html>
