<?php
require 'Classes/autoloader.php';
require './Classes/getid3/getid3.php';

Autoloader::register();
use onzeur\Type\Titre;
use onzeur\Type\Artiste;
use onzeur\Type\BD;
session_start();

if (!isset($_SESSION['pseudo'])) {
    header('Location: index.php');
    exit();
}
else{
    $artiste = new Artiste($_SESSION['pseudo']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomTitre = $_POST['nomTitre'];
    $date = date('d-m-Y');
    
    $audioFile = $_FILES['file'];
    $audioFileName = $audioFile['name'];
    $audioFileTmp = $audioFile['tmp_name'];
    $audioFilePath = './data/audios/' . $audioFileName;
    
    if (move_uploaded_file($audioFileTmp, $audioFilePath)) {


        $getID3 = new getID3;
        $audioFileInfo = $getID3->analyze($audioFilePath);
        $audioDuration = $audioFileInfo['playtime_seconds'];


        $titre = new Titre($nomTitre, $artiste, $audioDuration, $date, $audioFilePath);
        BD::addTitre($titre);

        header("Location: formMusic.php");
        exit();
    } else {
        echo "Une erreur s'est produite lors du téléchargement du fichier audio.";
    }
}
?>

<html>

<head>
    <title>Création d'une musique</title>
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
        <h2>Créer une musique</h2>
        <div class='separator'></div>
        <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="nomTitre">Nom du titre :</label>
            <input type="text" id="nomTitre" name="nomTitre" required><br>

            <label for="file">Audio de votre musique :</label>
            <input type="file" id="file" name="file" accept="audio/*" required><br>

            <input type="submit" name="submitButton" value="Valider">
            <input type="hidden" name="MAX_FILE_SIZE" value="59000000" />
        </form>
    </div>
</body>

</html>
