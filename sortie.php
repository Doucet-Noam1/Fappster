<?php
use onzeur\Type\BD;

?>
<html>

<head>
    <title>Onzeur</title>
    <link rel="stylesheet" href="css/sortie.css">
</head>

<body>
    <?php
    require 'base.php';
    ?>
    <div id="contenu">
        <?php
        $sortie = BD::getSortie($_GET['id']);
        if (is_null($sortie)) {
            echo "<h1 id='error'>Cette sortie n'existe pas...</h1>";
            die();
        }
        if (isset($_POST)) {
            if (isset($_POST['like'])) {
                BD::noteSortie($_SESSION['pseudo'], $sortie, null, boolval($_POST['like']));
            }
            if (isset($_POST['note'])) {
                BD::noteSortie($_SESSION['pseudo'], $sortie, $_POST['note']);
            }
        }
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
    </div>
</body>

</html>