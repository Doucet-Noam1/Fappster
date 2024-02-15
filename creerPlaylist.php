<?php
require 'base.php';
use onzeur\Type\BD;
use onzeur\Input\TextField;
use onzeur\Input\FileChoserField;
use onzeur\Input\SubmitButton;
use onzeur\Type\PlayList;

$textField = new TextField("nomTitre","Nom de la playlist ");
$submitButton = new SubmitButton("submitButton","Valider");
if (!isset($_SESSION['pseudo'])){
    header('Location: login.php');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomPlaylist = $_POST['nomTitre'];
    $visibilite = $_POST['Visibilité'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $nom = str_replace(' ', '_', $nomPlaylist);
        $uploadDirectory = './data/images/covers/';
        $nom =  $_SESSION['pseudo'] . '_' . $nom.'.jpg';
        $destPath = $uploadDirectory .''.$nom;
        
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            
            $playlist = new PlayList(BD::getUtilisateur($_SESSION['pseudo']), $nomPlaylist, $nom,boolval($visibilite));
            header('Location: sortie.php?id='.$playlist->getID());
        } else {
            echo "<script>alert(\"Une erreur s'est produite lors du téléchargement du fichier.\")</script>";
        }
    } else {
        echo "<script>alert(\"Veuillez sélectionner une image pour la photo de profil.\")</script>";
    }
} 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/unifiedForm.css">

    <title>Document</title>
</head>
<body>
    <div id="contenu">
        <form method="post" action="creerPlaylist.php" enctype="multipart/form-data">
            <label for="nomTitre">Nom de la playlist:</label>
            <input type="text" name="nomTitre" required><br>

            <label for="photo">Cover :</label>
            <input type="file" name="photo" accept="image/*"/><br>

            <label for="Visibilité">Visibilité :</label>
            <select id="Visibilité">
                <option value ='true'> Public</option>
                <option value ='false'> Privé</option>

            </select> <br>

            <button type="submit">Valider</button>
        </form>
    </div>
</body>
</html>
