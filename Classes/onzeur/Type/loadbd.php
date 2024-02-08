<?php
function loadbd(){
    $bdd = new PDO('sqlite:fappster.db');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $bdd;
}

?>