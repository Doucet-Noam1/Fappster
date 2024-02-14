<?php
require 'base.php';
use onzeur\Type\BD;
$playlist = BD::getSortie($_GET['id']);
        if (is_null($playlist)) {
            echo "<h1 id='error'>Cette playlist n'existe pas...</h1>";
            die();
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sortie.css">
    <title>modifier Playlist</title>
</head>
<body>
<div id="contenu">
<?php
$playlist->renderModif();
?>
</div>
</body>
</html>