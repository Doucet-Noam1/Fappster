<?php
session_start();
$pseudo = $_SESSION['pseudo'];

?>

<link rel="stylesheet" href="css/base.css">
<aside>
    <nav>
        <ul>
            <li>
                <a href="/"><object type="image/svg+xml"
                        data="data/images/accueil.svg">Accueil</object><span>Accueil</span></a>
            </li>
            <li>
                <a href="recherche.php"><object type="image/svg+xml"
                        data="data/images/loupe.svg">Recherche</object><span>Rechercher</span></a>
            </li>
            <li>
                <a href="login.php"><object type="image/svg+xml"
                        data="data/images/connexion.svg">Connexion</object><span>Connexion</span></a>
                </li>
                <li>
                <a href="profil.php"><object type="image/svg+xml"
                        data="data/images/connexion.svg">profil</object><span>Profil</span></a>
                </li>
            
                <li>
            <?php if($pseudo == null){
                
                }else{
                echo '<p> <span>'.$pseudo.' </span> </p>';
                }?>
            </li>

        </ul>
    </nav>
</aside>