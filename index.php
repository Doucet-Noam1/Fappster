<html>

<head>
    <title>Fappster</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="data/images/logo.png">
</head>

<body>
    <?php
    require 'base.php';
    use onzeur\Type\BD;
    BD::getInstance();
    if (isset($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
    }
    ?>
    <div id="contenu">
        <div id="albums">
            <h1>Albums</h1>
            <?php
            foreach (BD::getAllAlbums() as $album) {
                $album->render();
            }
            ?>
        </div>
        <div id="eps">
            <h1>EPs</h1>
            <?php
            foreach (BD::getAllEPs() as $ep) {
                $ep->render();
            }
            ?>
        </div>
        <?php 
        
        ?>
</body>

</html>