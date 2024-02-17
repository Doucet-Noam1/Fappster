<?php

require "base.php";	
use onzeur\Type\BD;

if (($_SESSION['pseudo']!="admin")){
    header('Location: index.php');
    exit();
}

BD::supprimerArtiste($_GET['pseudo']);
header('location: vueAdmin.php ' );
exit();