<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;
?>
<html>
<head>
    <title>Onzeur</title>
    <link rel="stylesheet" href="Css/index.css">
</head>

<body>
    <h1>Onzeur</h1>
    <div id="albums">
        <?php
        $album = BD::getAlbum($_GET['id']);
        $album->renderDetail();
        ?>
    </div>
</body>

</html>