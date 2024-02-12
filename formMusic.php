<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\Titre;
use onzeur\Type\Artiste;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitButton'])) {
    $nomTitre = $_POST['nomTitre'] ?? '';
    $nbField = $_POST['nbField'] ?? '';
    $featsList = $_POST['feats'] ?? '';

    // Vérifie si le fichier MP3 a été correctement téléchargé
    echo $_FILES['file']['error']['tmp_name'];
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        
        $date = date('d-m-Y');

        // Définir le chemin de destination du fichier audio
        $destination = './data/audios/' . $fileName;

        // Déplacer le fichier audio téléchargé vers le dossier de destination
        if (move_uploaded_file($file, $destination)) {
            // Créer l'objet Titre
            $musique = new Titre($nomTitre, $_SESSION['pseudo'], $nbField, $date, $destination);

            // Ajouter les artistes en feat
            $feats = explode(",", $featsList);
            foreach ($feats as $feat) {
                $musique->addArtiste(new Artiste($feat));
            }

            echo "Le fichier MP3 a été téléchargé avec succès.";
        } else {
            echo "Erreur lors du déplacement du fichier MP3.";
        }
    } else {
        echo "Une erreur s'est produite lors du téléchargement du fichier MP3.";
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
            <input type="hidden" name="MAX_FILE_SIZE" value="59000000" />
        </form>
    </div>
</body>

</html>
