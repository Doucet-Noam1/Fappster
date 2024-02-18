<html>

<head>
    <title>Onzeur</title>
    <link rel="stylesheet" href="css/sortie.css">
    <script type="text/javascript" src="js/titre.js"></script>
</head>

<body>
    <main>
        <?php
        require 'base.php';
        use onzeur\Type\BD;
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
            if ($sortie->getType() != 4) {

                echo '<script src="js/sortie.js"></script>';
                echo '<div id="recommandations">';
                echo '<h1>Recommandations</h1>';
                foreach (BD::getRecommandations($sortie) as $recommandation) {
                    $recommandation->render();
                }

                echo '</div>';
            } ?>
        </div>
    </main>

</body>

</html>