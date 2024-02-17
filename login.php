<?php
require 'base.php';
use onzeur\Type\Utilisateur;
use onzeur\Type\BD;

if (isset($_SESSION['pseudo'])){
    header('Location: index.php');
    exit();
}
if ($_POST) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    if ($_POST['signup'] == 'false') {
        if (BD::verifie_utilisateur($pseudo, $password)) {
            $_SESSION['pseudo'] = $pseudo;
            header('Location: index.php');
            exit();
        } else {
            echo "<script>alert(\"Nom d'utilisateur ou mot de passe incorrect.\")</script>";
        }
    } else {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        function valider($prenom, $nom, $pseudo, $password)
        {
            $artiste = new Utilisateur($pseudo, $nom, $prenom, $password);
            $_SESSION['artiste'] = $artiste;
            $_SESSION['pseudo'] = $pseudo;
            header('Location: index.php');
            exit();
        }
        if (BD::getUtilisateur($pseudo) == null) {
            if (isset($_FILES['photo'])) {
                if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['photo']['tmp_name'];
                    $fileName = $_FILES['photo']['name'];

                    $destPath = BD::DOSSIERUSERS . $pseudo . '.jpg';

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        valider($prenom, $nom, $pseudo, $password);
                    } else {
                        echo "<script>alert(\"Une erreur s'est produite lors du téléchargement du fichier.\")</script>";
                    }
                } else {
                    valider($prenom, $nom, $pseudo, $password);
                }
            }
        } else {
            echo "<script>alert(\"Ce pseudo est déjà pris.\")</script>";
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
    <div id="contenu">
        <div>
            <h2>Connexion</h2>
            <form method="post" action="login.php">
                <label for="pseudo">Nom d'utilisateur:</label>
                <input type="text" name="pseudo" required><br>
                <input type="hidden" name="signup" value="false">

                <label for="password">Mot de passe:</label>
                <input type="password" name="password" required><br>

                <button type="submit">Se connecter</button>
            </form>
        </div>
        <div class="separator"></div>
        <div>
            <h2>Inscription</h2>
            <form method="post" action="login.php" enctype="multipart/form-data">
                <label for="pseudo">Nom d'utilisateur:</label>
                <input type="text" name="pseudo" required><br>

                <label for="photo">Photo de profil:</label>
                <input type="file" name="photo" accept="image/*" /><br>

                <label for="prenom">Prénom:</label>
                <input type="text" name="prenom" required><br>

                <label for="nom">Nom:</label>
                <input type="text" name="nom" required><br>

                <label for="password">Mot de passe:</label>
                <input type="password" name="password" required><br>

                <input type="hidden" name="signup" value="true">
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
</body>

</html>