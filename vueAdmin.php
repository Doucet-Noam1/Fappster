<html>

<head>
    <title>Panel Admin</title>
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
        <div id="artistes">
            <h1>Touts les artistes</h1>
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
                        foreach (BD::getAllArtistes() as $art) {
                            echo "<tr>";
                            $art->renderAdmin();
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            
        </div>
</body>

</html>