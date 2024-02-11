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
    require 'nav.php';
    ?>
    <div id="contenu">
    <div id="albums">
        <?php
        $album = BD::getSortie($_GET['id']);
        $album->renderdetail();
        ?>
    </div>
    </div>
</body>

</html>