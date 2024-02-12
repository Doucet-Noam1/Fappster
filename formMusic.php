<?php
require 'Classes/autoloader.php';

Autoloader::register();
use onzeur\Type\Sortie;
use onzeur\Type\BD;
use onzeur\Type\Album;
use onzeur\Type\Titre;
use onzeur\Type\Reader;
use onzeur\Type\Artiste;
use onzeur\Type\EP;
use onzeur\Input\input;
use onzeur\Input\TextField;
use onzeur\Input\FileChoserField;
use onzeur\Input\NumberField;
use onzeur\Input\SubmitButton;

session_start();
$artiste = $_SESSION['pseudo'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitButton'])) {
    $nomTitre = $_POST['nomTitre'] ?? '';
    $nbField = $_POST['nbField'] ?? '';
    $file = $_FILES['file']['tmp_name'] ?? ''; // Utilisez $_FILES pour récupérer le fichier audio temporaire.
    $featsList = $_POST['feats'] ?? '';

    $date = date('d-m-Y');

    // Définir le chemin de destination du fichier audio
    $destination = './data/audio/' . $_FILES['file']['name'];

    // Déplacer le fichier audio téléchargé vers le dossier de destination
    if (move_uploaded_file($file, $destination)) {
        // Créer l'objet Titre
        $musique = new Titre($nomTitre, $artiste, $nbField, $date, $destination);

        // Ajouter les artistes en feat
        $feats = explode(",", $featsList);
        foreach ($feats as $feat) {
            $musique->addArtiste(new Artiste($feat));
        }
    } else {
        echo "Erreur lors du téléchargement du fichier.";
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

            <label for="feats">Artistes en feat (séparés par des virgules) :</label>
            <input type="text" id="feats" name="feats"><br>

            <label for="nbField">Durée du titre (en secondes) :</label>
            <input type="number" id="nbField" name="nbField" required><br>

            <label for="file">Audio de votre musique :</label>
            <input type="file" id="file" name="file" accept="audio/*" required><br>

            <input type="submit" name="submitButton" value="Valider">
        </form>
    </div>
</body>

</html>
