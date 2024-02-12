<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;

?>
<html>

<head>
    <title>Onzeur</title>
    <link rel="stylesheet" href="css/sortie.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <?php
    require 'base.php';
    ?>
    <div id="contenu">
        <?php
        $sortie = BD::getSortie($_GET['id']);
        $sortie->renderdetail();
        ?>
        <script src="js/sortie.js"></script>
        <div id="recommandations">
            <h1>Recommandations</h1>
            <?php
            foreach (BD::getRecommandations($sortie) as $recommandation) {
                $recommandation->render();
            }
            ?>
    </div>
</body>

</html>