<html>

<head>
    <title>Profil</title>
    <link rel="stylesheet" href="css/profil.css">
</head>

<body>
    <main>
        <?php
        require 'base.php';
        use fappster\Type\BD;

        ?>
        <div id="contenu">
            <?php
            $artiste = BD::estArtiste($_GET['id'] ?? $_SESSION['pseudo'] ?? "");
            if (!$artiste) {
                $user = BD::getUtilisateur($_GET['id'] ?? $_SESSION['pseudo'] ?? "");
                if (is_null($user)) {
                    echo "<h1 id='error'>Cet utilisateur n'existe pas...</h1>";
                    die();
                } else {
                    $user->render();
                }
            } else {
                $artiste = BD::getArtiste($_GET['id'] ?? $_SESSION['pseudo'] ?? "");
                $artiste->render();
            }
            ?>
        </div>
        <script src="js/profil.js" type="text/javascript"></script>
    </main>
</body>

</html>