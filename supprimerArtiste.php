<?php

require "base.php";	
use onzeur\Type\BD;


BD::getInstance();
session_start();
if (($_SESSION['pseudo']!="admin")){
    header('Location: index.php');
    exit();
}

$querry = "DELETE FROM utilisateur WHERE pseudo = '".$_GET['pseudo']."'";
BD::getInstance()->query($querry);
header('location: vueAdmin.php ' );
exit();