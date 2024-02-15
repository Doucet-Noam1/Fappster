<?php

require "base.php";   
use onzeur\Type\BD;

BD::getInstance();

if (!isset($_SESSION['pseudo']) || $_SESSION['pseudo'] != "admin") {
    header('Location: index.php');
    exit();
}

$pseudo = $_GET['pseudo'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['modif']) && $_POST['modif'] === "true") {
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDirectory = "./data/images/users/";
            $fileName = $pseudo . '.jpg';
            $uploadPath = $uploadDirectory . $fileName;
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);
            header('Location: vueAdmin.php');
            
        } 
    }
}
?>

<html>

<head>
    <title>Modification de la photo de profil</title>
    <link rel="stylesheet" href="./css/unifiedForm.css">
</head>

<body>
    <div id="panel">
        <h2>Modifier la photo de profil de <?php echo $pseudo; ?></h2>
        <div class='separator'></div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?pseudo=' . urlencode($pseudo); ?>" enctype="multipart/form-data">
            <label for="photo">Photo de profil :</label>
            <input type="file" name="photo" accept="image/*" /><br>
            <input type="hidden" name="modif" value="true">
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>

</html>
