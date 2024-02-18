<html>

<head>
    <title>Panel Admin</title>
    <link rel="stylesheet" href="css/moduleAdmin.css">
    <link rel="icon" href="data/images/logo.png">
</head>

<body>
    <main>
        <?php
        require 'base.php';
        use onzeur\Type\BD;

        if (isset($_SESSION['pseudo'])) {
            if (($_SESSION['pseudo'] != "admin")) {
                header('Location: index.php');
                exit();
            }
            $pseudo = $_SESSION['pseudo'];
        } else {
            header('Location: index.php');
            exit();
        }
        ?>
        <div id="contenu">
            <div id="artistes">
                <h1>Tous les artistes</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Pseudo</th>
                            <th>Photo de profil</th>
                            <th>Type de compte</th>
                            <th>Modifer</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (BD::getAllArtistes() as $artiste) {
                            $artiste->renderAdmin();
                        }
                        ?>
                    </tbody>
                </table>

            </div>
    </main>
</body>

</html>