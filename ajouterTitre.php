<html>

<head>
    <title>Création d'une musique</title>
    <link rel="stylesheet" href="./css/unifiedForm.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Riot&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pako/2.0.3/pako.min.js"></script>
</head>

<body>
    <main>
        <?php
        require 'base.php';
        use onzeur\Type\Titre;
        use onzeur\Type\BD;


        if (!isset($_SESSION['pseudo'])) {
            header('Location: login.php');
            exit();
        }
        function reload(bool $success)
        {
            header("Location: ajouterTitre.php?upload=" . ($success ? "1" : "0"));
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_FILES['file']['name'])) {
                reload(false);
            }
            if (empty($_FILES['file']['tmp_name'])) {
                reload(false);
            }
            $nomTitre = $_POST['nomTitre'];
            $date = date('d-m-Y');

            $audioFile = $_FILES['file'];
            $audioFileTmp = $audioFile['tmp_name'];

            array_unshift($artistes, $_SESSION['pseudo']);
            $artistes = isset($_POST['feats']) ? $_POST['feats'] : [];
            $artistesString = implode('_', $artistes);

            $audioFileName = $nomTitre . '_' . $artistesString . '.' . pathinfo($audioFile['name'], PATHINFO_EXTENSION); // Nouveau nom du fichier
            $audioFilePath = BD::DOSSIERAUDIOS . $audioFileName;

            if (move_uploaded_file($audioFileTmp, $audioFilePath)) {

                $getID3 = new getID3;
                $audioFileInfo = $getID3->analyze($audioFilePath);
                if (!isset($audioFileInfo['playtime_seconds'])) {
                    unlink($audioFilePath);
                    reload(false);
                }
                $audioDuration = $audioFileInfo['playtime_seconds'];
                $titre = new Titre($nomTitre, BD::getArtiste($_SESSION['pseudo']), $audioDuration, $date, $audioFileName);
                BD::addTitre($titre);
                if (isset($_POST['feats'])) {
                    foreach ($_POST['feats'] as $feat) {
                        $titre->addArtiste(BD::getArtiste($feat));
                    }
                }
                reload(true);
            } else {
                reload(false);
            }
        }
        ?>

        <div id="contenu">
            <?php
            if (isset($_GET['upload'])) {
                if ($_GET['upload'] == "1") {
                    echo "<p class='message success'>Votre musique a bien été ajoutée</p>";
                } else {
                    echo "<p class='message error'>Erreur lors de l'ajout de votre musique</p>";
                }
            }
            ?>
            <h2>Créer une musique</h2>
            <div class='separator'></div>
            <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="nomTitre">Nom du titre :</label>
                <input type="text" id="nomTitre" name="nomTitre" required>

                <label for="file">Audio de votre musique :</label>
                <input type="file" id="file" name="file" accept="audio/*" required>

                <label for="feats">Featurings : (Optionnel)</label>
                <script type="text/javascript" src="js/ajoutArtiste.js"></script>
                <ol id="artistes">
                    <li>
                        <p class="input mini">
                            <?php echo $_SESSION['pseudo'] ?> (Vous)
                        </p>
                    </li>
                    <li>
                        <input id="inputArtistes" type="text" list="dataArtistes" autocomplete="off"
                            placeholder="Artiste" class="mini" onkeypress="cancelForm(event)">
                    </li>
                </ol>
                <button type="button" onclick="add()">Ajouter</button>
                <datalist id="dataArtistes"></datalist>

                <input type="submit" name="submitButton" value="Valider">
                <input type="hidden" name="MAX_FILE_SIZE" value="59000000" />
            </form>
        </div>
    </main>
</body>

</html>