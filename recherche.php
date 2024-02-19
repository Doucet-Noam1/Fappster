<html>

<head>
    <title>Recherche</title>
    <link rel="stylesheet" href="css/recherche.css">
    <link rel="icon" href="data/images/logo.png">
</head>

<body>
    <main>
        <?php
        require 'base.php';
        use fappster\Type\BD;

        BD::getInstance();
        if (isset($_GET['nom'])) {
            $recherche = $_GET['nom'];
            $genres = $_GET['genre'];
            $annee = $_GET['annee'] == "" ? -1 : intval($_GET['annee']);
            $sorties = BD::rechercheSortie($recherche, $genres, $annee);
            if ($genres != "" || $annee != -1) {
                $artistes = [];
                foreach ($sorties as $sortie) {
                    foreach ($sortie->getArtiste() as $artiste) {
                        if (!in_array($artiste, $artistes))
                            $artistes[] = $artiste;
                    }
                }
                $titres = [];
                foreach ($sorties as $sortie) {
                    foreach ($sortie->getListeTitres() as $titre) {
                        if (!in_array($titre, $titres))
                            $titres[] = $titre;
                    }
                }
            } else {
                $artistes = BD::rechercheArtiste($recherche);
                $titres = BD::rechercheTitre($recherche);
            }

        }
        ?>
        <div id="contenu">
            <h1>Résultats de la recherche</h1>
            <form method="get" action="recherche.php">
                <input type="text" name="nom" id="recherche" placeholder="Recherche">
                <select name="genre">
                    <option value="">Tous les genres</option>
                    <?php
                    foreach (BD::getAllGenres() as $genre) {
                        echo "<option value='" . $genre . "'>" . $genre . "</option>";
                    }
                    ?>
                </select>
                <select name="annee">
                    <option value="">Toutes les années</option>
                    <?php
                    foreach (BD::getAllAnnees() as $annee) {
                        echo "<option value='" . $annee . "'>" . $annee . "</option>";
                    }
                    ?>
                </select>

                <input type="submit" value="Rechercher">
            </form>
            <div id="resultats">
                <div id="artistes">
                    <h2>Artistes</h2>
                    <div id="listeArtistes">
                        <?php
                        foreach ($artistes as $artiste) {
                            $artiste->renderCard();
                        }
                        ?>
                    </div>
                </div>
                <div id="sorties">
                    <h2>Sorties</h2>
                    <div id="listeSorties">
                        <?php
                        foreach ($sorties as $sortie) {
                            $sortie->render();
                        }
                        ?>
                    </div>
                </div>
                <div id="titres">
                    <h2>Titres</h2>
                    <div id="listeTitres">
                        <?php
                        foreach ($titres as $titre) {
                            $titre->renderCard();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>