<html>

<head>
    <title>Onzeur</title>
    <link rel="stylesheet" href="css/profil.css">
</head>

<body>
    <?php
    require 'base.php';
    use onzeur\Type\BD;
    ?>
    <div id="contenu">
        <?php
        $user = BD::getUtilisateur($_GET['id']??$_SESSION['pseudo']??"");
        if (is_null($user)) {
            echo "<h1 id='error'>Cet utilisateur n'existe pas...</h1>";
            die();
        }
        $user->render();
        ?>
    </div>
    <script src="js/profil.js" type="text/javascript"></script>
</body>

</html>