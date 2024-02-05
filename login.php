
<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\Artiste;
session_start();

if ($_POST) {
$nom_utilisateur = $_POST['nom_utilisateur'];
$password = $_POST['password'];
var_dump($nom_utilisateur. "m<br>");
var_dump($password. "mdp<br>");
if ($_POST['signup'] == 'false'){
if (BD::verifie_utilisateur($nom_utilisateur, $password)) {
$_SESSION['nom_utilisateur'] = $nom_utilisateur; 
exit();
} else {
echo "Nom d'utilisateur ou mot de passe incorrect.";
}
}
else{
$artiste = new Artiste($nom_utilisateur, $password);
$_SESSION['artiste'] = $artiste;
$_SESSION['nom_utilisateur'] = $nom_utilisateur;
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
