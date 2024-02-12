<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\Utilisateur;
use onzeur\Type\BD;
session_start();
if ($_POST) {
    
$pseudo = $_POST['pseudo'];
$password = $_POST['password'];
if ($_POST['signup'] == 'false'){
if (BD::verifie_utilisateur($pseudo, $password)) {
$_SESSION['pseudo'] = $pseudo;
header('Location: index.php'); 
exit();
} else {
echo "<script>alert(\"nom d'utilisateur ou mdp incorrect \")</script>";
}
}
else{
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
if (BD::getUtilisateur($pseudo,$nom,$prenom, $password) == null){
    $artiste = new Utilisateur($pseudo,$nom,$prenom, $password);
    $_SESSION['artiste'] = $artiste;
    $_SESSION['pseudo'] = $pseudo;
    header('Location: index.php');
    exit();
}else{
    echo "<script>alert(\"ce pseudo est deja pris \")</script>";
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion</title>
<link rel="stylesheet" href="./css/unifiedForm.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Protest+Riot&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <img id='logo' src="./data/images/logo.png" alt="Logo">
    </nav>
    <div id="panel">
        <div>
        <h2>Connexion</h2>
<form method="post" action="login.php">
<label for="pseudo">Nom d'utilisateur:</label>
<input type="text" name="pseudo" required><br>
<input type = "Hidden" name= "signup" value="false">

<label for="password">Mot de passe:</label>
<input type="password" name="password" required><br>

<button type="submit">Se connecter</button>
</form>
        </div>
        <div class='separator'></div>
        <div>
        <h2>Inscription</h2>
<form method="post" action="login.php">
<label for="pseudo">Nom d'utilisateur:</label>
<input type="text" name="pseudo" required><br>

<label for="pseudo">Prenom:</label>
<input type="text" name="prenom" required><br>


<label for="pseudo">Nom :</label>
<input type="text" name="nom" required><br>

<label for="password">Mot de passe:</label>
<input type="password" name="password" required><br>


<input type = "Hidden" name= "signup" value="true">
<button type="submit">S'inscrire</button>
</form>
        </div>

</div>
</body>
</html>
