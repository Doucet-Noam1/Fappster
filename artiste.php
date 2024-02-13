<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;

?>
<html>

<head>
    <title>Onzeur</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php
    require 'base.php';
    ?>
    <div id="contenu">
        <div id="albums">
            <h1>Artiste</h1>
        <?php
        $artiste = BD::getArtiste($_GET['id']);
        $artiste->render();
        ?>
        </div>
    </div>
</body>

</html>