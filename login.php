
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion</title>
<link rel="stylesheet" href="./Css/unifiedForm.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Protest+Riot&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <img id='logo' src="./data/images/logo.png" alt="Logo">
    </nav>
    <div id="panel">
        <div>
        <h2>Connexion</h2>
<form method="post" action="gestionlogin.php">
<label for="pseudo">Nom d'utilisateur:</label>
<input type="text" name="pseudo" required><br>
<input type = "Hidden" name= "signup" value="false">

<label for="password">Mot de passe:</label>
<input type="password" name="password" required><br>

<button type="submit">Se connecter</button>
</form>
        </div>
        <div class='separator'></div>
        <div>
        <h2>Inscription</h2>
<form method="post" action="gestionlogin.php">
<label for="pseudo">Nom d'utilisateur:</label>
<input type="text" name="pseudo" required><br>

<label for="password">Mot de passe:</label>
<input type="password" name="password" required><br>
<input type = "Hidden" name= "signup" value="true">
<button type="submit">S'inscrire</button>
</form>
        </div>

</div>
</body>
</html>
