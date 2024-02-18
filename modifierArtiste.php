<html>

<head>
    <title>Modification d'un utilisateur</title>
    <link rel="stylesheet" href="./css/unifiedForm.css">
</head>

<body>
    <main>
        <?php

        require "base.php";
        use onzeur\Type\BD;

        if (!isset($_SESSION['pseudo']) || $_SESSION['pseudo'] != "admin") {
            header('Location: index.php');
            exit();
        }

        $pseudo = $_GET['pseudo'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['modif']) && $_POST['modif'] === "true") {
                var_dump($_POST);
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $mdp = $_POST['mdp'] === "" ? null : $_POST['mdp'];
                $verifie = isset($_POST['verifie']);
                var_dump($mdp);
                BD::modifierUtilisateur($pseudo, $nom, $prenom, $mdp);
                if (BD::estArtiste($pseudo)) {
                    BD::getArtiste($pseudo)->setVerifie($verifie);
                }
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $uploadDirectory = "./data/images/users/";
                    $fileName = $pseudo . '.jpg';
                    $uploadPath = $uploadDirectory . $fileName;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);

                }
                header('Location: vueAdmin.php');
            }
        }
        ?>

        <div id="contenu">
            <h2>Modifier les informations de
                <?php echo $pseudo; ?>
            </h2>
            <div class='separator'></div>
            <form method="post"
                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?pseudo=' . urlencode($pseudo); ?>"
                enctype="multipart/form-data">
                <?php
                $user = BD::getUtilisateur($pseudo);
                $nom = $user->getNom();
                $prenom = $user->getPrenom();
                ?>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" value="<?php echo $nom; ?>">
                <label for="prenom">Prenom :</label>
                <input type="text" name="prenom" value="<?php echo $prenom; ?>">
                <label for="photo">Photo de profil :</label>
                <input type="file" name="photo" accept="image/*" />
                <label for="mdp">Mot de passe :</label>
                <input type="text" name="mdp">
                <p>Attention, le mot de passe ne sera plus visible après modification.</p>
                <?php
                if (BD::estArtiste($pseudo)) {
                    $artiste = BD::getArtiste($pseudo);
                    $verifie = $artiste->getVerifie();
                    echo "<label for='verifie'>Artiste vérifié :</label>";
                    echo "<input type='checkbox' name='verifie' value='true' ";
                    if ($verifie) {
                        echo "checked";
                    }
                    echo ">";
                }
                ?>
                <input type="hidden" name="modif" value="true">
                <button type="submit">Modifier</button>
            </form>
        </div>
    </main>
</body>

</html>