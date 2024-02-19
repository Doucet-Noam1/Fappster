<html>

<head>
    <title>Modification d'une sortie</title>
    <link rel="stylesheet" href="./css/unifiedForm.css">
</head>

<body>
    <main>
        <?php

        require "base.php";
        use fappster\Type\BD;

        if (!isset($_SESSION['pseudo']) || $_SESSION['pseudo'] != "admin") {
            header('Location: index.php');
            exit();
        }

        $sortie = BD::getSortie($_GET['id']);
        $id = $sortie->getID();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['modif']) && $_POST['modif'] === "true") {
                $nomSortie = $_POST['nom'];
                $cover = $_FILES['cover'];
                $visibilite = $_POST['visibilite'];
                if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                    $ancienneCover = $sortie->getCover();
                    $cover = $_FILES['cover'];
                    $coverTmp = $cover['tmp_name'];
                    $coverName = sprintf('%s.%s', sha1_file($coverTmp), pathinfo($cover['name'], PATHINFO_EXTENSION));
                    $destPath = BD::DOSSIERCOVERS . $coverName;
                    if (!move_uploaded_file($coverTmp, $destPath)) {
                        echo "<script>alert(\"Une erreur s'est produite lors du téléchargement de la cover.\")</script>";
                    }
                    if ($ancienneCover != BD::DOSSIERCOVERS . 'default.jpg') {
                        unlink($ancienneCover);
                    }
                } else {
                    $cover = $sortie->getCover();
                }
                BD::modifierSortie($sortie, $nomSortie, $coverName, $visibilite);
                header('Location: sortie.php?id=' . $id);
            }
        }
        ?>

        <div id="contenu">
            <script src="js/modifierSortie.js"></script>
            <h2>Modifier "
                <?php echo $sortie->getNom(); ?>"
            </h2>
            <div class='separator'></div>
            <form method="post"
                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $sortie->getID(); ?>"
                enctype="multipart/form-data">
                <?php
                $nom = $sortie->getNom();

                ?>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" value="<?php echo $nom; ?>">
                <label for="cover">Cover :</label>
                <p>Actuelle :</p>
                <img width="50px" height="50px" src="<?php echo $sortie->getCover(); ?>"
                    alt="Ancienne Cover de la sortie">
                <p>Nouvelle :</p>
                <img width="50px" height="50px" src="<?php echo $sortie->getCover(); ?>"
                    alt="Nouvelle Cover de la sortie">
                <input type="file" name="cover" accept="image/*" onchange="display(this)" />
                <label for="visibilite">Visibilité :</label>
                <select name="visibilite" required>
                    <option value="1" <?php if ($sortie->getVisibilite() == 1)
                        echo "selected"; ?>>Publique</option>
                    <option value="0" <?php if ($sortie->getVisibilite() == 0)
                        echo "selected"; ?>>Privée</option>
                </select>
                <input type="hidden" name="modif" value="true">
                <button type="submit">Modifier</button>
            </form>
        </div>
    </main>
</body>

</html>