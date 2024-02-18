<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/unifiedForm.css">
    <link rel="stylesheet" href="./css/creerSortie.css">
    <script src="js/creerSortie.js"></script>
    <title>Créer une sortie</title>
</head>

<body>
    <main>
        <?php
        require 'base.php';
        use onzeur\Type\BD;
        use onzeur\Type\Sortie;

        if (!isset($_SESSION['pseudo'])) {
            header('Location: login.php');
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $typeSortie = intval($_POST['type']);
            $nomSortie = $_POST['nomSortie'];
            $artistes = isset($_POST['feats']) ? $_POST['feats'] : [];
            $date = $_POST['date'];
            $titres = isset($_POST['titres']) ? $_POST['titres'] : [];
            $genres = isset($_POST['genres']) ? $_POST['genres'] : [];
            $visibilite = boolval($_POST['visibilite']);

            var_dump($_POST);
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $cover = $_FILES['photo'];
                $coverTmp = $cover['tmp_name'];
                $coverName = sprintf('%s.%s', sha1_file($coverTmp), pathinfo($cover['name'], PATHINFO_EXTENSION));
                $destPath = BD::DOSSIERCOVERS . $coverName;
                if (!move_uploaded_file($coverTmp, $destPath)) {
                    echo "<script>alert(\"Une erreur s'est produite lors du téléchargement de la cover.\")</script>";
                }
            }
            $auteur = BD::estArtiste($_SESSION['pseudo']) ? BD::getArtiste($_SESSION['pseudo']) : BD::getUtilisateur($_SESSION['pseudo']);
            array_unshift($artistes, $auteur->getPseudo());
            $artistes = array_map(function ($artiste) {
                return BD::getArtiste($artiste);
            }, $artistes);
            $titres = array_map(function ($id) {
                return BD::getTitre($id);
            }, $titres);
            $sortie = Sortie::factory($artistes, $nomSortie, $titres, $date, $coverName, $typeSortie, $genres,$visibilite);
            header('Location: sortie.php?id=' . $sortie->getID());
        }

        ?>


        <div id="contenu">
            <h2>Créer une sortie</h2>
            <div class='separator'></div>
            <form method="post" action="creerSortie.php" enctype="multipart/form-data">
                <label for="type">Type de sortie :</label>
                <select name="type" required>
                    <option selected value disabled>Choisir un type</option>
                    <?php
                    $types = BD::getAllTypes();
                    foreach ($types as $id => $libelle) {
                        echo "<option value='" . $id . "'>" . $libelle . "</option>";
                    }
                    ?>
                </select>
                <label for="nomSortie">Nom de la sortie :</label>
                <input type="text" name="nomSortie" required>
                
                <label for="photo">Cover :</label>
                <input type="file" name="photo" accept="image/*" />
                
                <label for= 'visibilite'>Visibilite :</label>
                <select name = 'visibilite' required> 
                <option selected value disabled>Choisir une visibilite</option>
                <option value= '1'> Public </option>
                <option value= '0'> Prive </option>
                </select>

                <label for="feats">Co-Artistes :</label>
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

                <div id="sortiecommerciale">
                    <label for="date">Date de sortie :</label>
                    <input id="date" type="date" name="date" required>

                    <label for="titres">Titres :</label>

                    <a href="ajouterTitre.php"
                        onclick="return confirm('Les modifications sur ce formulaire seront perdues si vous quittez la page.\nQuitter la page ?')">Ajouter
                        des titres</a>
                    <ol id="listTitres">
                        <li>
                            <select id="titres">
                                <option selected value>Choisir un titre</option>
                                <?php
                                $titres = BD::getTitresBy(BD::getArtiste($_SESSION['pseudo']));
                                foreach ($titres as $titre) {
                                    echo "<option value='" . $titre->getId() . "'>" . $titre->getTitre() . "</option>";
                                }
                                ?>
                            </select>
                        </li>
                    </ol>

                    <label for="genres">Genres :</label>
                    <ul id="listGenres">
                        <li>
                            <select id="genres">
                                <option selected value>Choisir les genres</option>
                                <?php
                                $genres = BD::getAllGenres();
                                foreach ($genres as $libelle) {
                                    echo "<option value='" . $libelle . "'>" . $libelle . "</option>";
                                }
                                ?>
                            </select>
                        </li>
                    </ul>
                </div>

                <button type="submit">Valider</button>
            </form>
        </div>
    </main>
</body>

</html>