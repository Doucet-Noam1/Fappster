<html>

<head>
    <title>Fappster</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="data/images/logo.png">
</head>

<body>
    <main>
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
                $albums = BD::getAllAlbums();
                if (count($albums) == 0) {
                    echo "<h2>Aucun album n'a été publié pour le moment</h2>";
                } else {
                    foreach ($albums as $album) {
                        $album->render();
                    }
                }
                ?>
            </div>
            <div id="singles">
                <h1>Singles</h1>
                <?php
                $singles = BD::getAllSingles();
                if (count($singles) == 0) {
                    echo "<h2>Aucun single n'a été publié pour le moment</h2>";
                } else {
                    foreach ($singles as $single) {
                        $single->render();
                    }
                }
                ?>
            </div>
            <div id="eps">
                <h1>EPs</h1>
                <?php
                $eps = BD::getAllEPs();
                if (count($eps) == 0) {
                    echo "<h2>Aucun EP n'a été publié pour le moment</h2>";
                } else {
                    foreach ($eps as $ep) {
                        $ep->render();
                    }
                }
                ?>
            </div>
    </main>
</body>

</html>