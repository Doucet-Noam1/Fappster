<?php
require 'Classes/autoloader.php';

Autoloader::register();
use onzeur\Type\Sortie;
use onzeur\Type\BD;
use onzeur\Type\Album;
use onzeur\Type\Musique;
use onzeur\Type\Reader;
use onzeur\Type\Artiste;
use onzeur\Type\EP;
use onzeur\Input\input;
use onzeur\Input\TextField;
use onzeur\Input\FileChoserField;
use onzeur\Input\NumberField;
use onzeur\Input\SubmitButton;

session_start();
$artiste = $_SESSION['artiste'] ;

$numberField = new NumberField("nbField","Durée du titre (en secondes) ");
$fileChoserField= new FileChoserField("file","Audio de votre musique  ");
$textField = new TextField("nomTitre","Nom du titre ");
$feats = new TextField("feats","Artistes en feat (séparés par des virgules)");
$submitButton = new SubmitButton("submitButton","Valider");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitButton'])) {
    $nomTitre = $_POST['nomTitre'];
    $nbField = $_POST['nbField'];
    $file = $_POST['file'];
    $featsList = $_POST['feats'];

    $date = date('d-m-Y');

    $musique = new Musique($nomTitre, $artiste, $nbField, $date, $file);

    $feats = explode(",", $featsList);
    foreach ($feats as $feat) {
        $musique->addArtiste(new Artiste($feat));
    }
}

?>
<html>

<head>
    <title>Création d'une musique</title>
    <!-- <link rel="stylesheet" href="Css/formMusic.css"> -->
</head>

<body>
    <div id="panel">
        <h1>Créer une musique</h1>
        <form action="POST">
            <?php
            $textField->render();
            $feats->render();
            $numberField->render();
            $fileChoserField->render();    
            $submitButton->render();
            ?>
        </form>
    </div>
    
    
</body>

</html>