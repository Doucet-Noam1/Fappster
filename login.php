
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion</title>
</head>
<body>
<h2>Connexion/Inscription</h2>
<form method="post" action="gestionlogin.php">
<label for="pseudo">Nom d'utilisateur:</label>
<input type="text" name="pseudo" required><br>
<input type = "Hidden" name= "signup" value="false">

<label for="password">Mot de passe:</label>
<input type="password" name="password" required><br>

<button type="submit">Se connecter</button>
</form>
<form method="post" action="gestionlogin.php">
<label for="pseudo">Nom d'utilisateur:</label>
<input type="text" name="pseudo" required><br>

<label for="password">Mot de passe:</label>
<input type="password" name="password" required><br>
<input type = "Hidden" name= "signup" value="true">
<button type="submit">S'inscrire</button>
</form>
</body>
</html>
